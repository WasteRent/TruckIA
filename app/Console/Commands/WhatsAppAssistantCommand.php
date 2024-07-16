<?php

namespace App\Console\Commands;

use stdClass;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Events\IncidentOpened;
use App\Models\ChatGptMessage;
use App\Models\VehicleIncident;
use App\Services\OpenAIService;
use Illuminate\Console\Command;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Fleet\FleetIncidentController;

class WhatsAppAssistantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:assistant {session_id} {type} {content}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $response = $this->askChatGpt(988);

            if ($this->argument('type') == 'text') {
                $text = $this->argument('content');
            } elseif ($this->argument('type') == 'audio') {
                $text = $this->transcribeAudio($this->argument('content'));
            } else {
                throw new \Exception('Invalid type');
            }

            //Send request to OpenAI
            $response = $this->runConversation($this->argument('session_id'), $text);

            //Display response
            $this->info($response->content);
            app(WhatsAppService::class)->send('+34686764606', $response->content);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function runConversation(string $session_id, string $content)
    {
        ChatGptMessage::create([
            'session_id' => $session_id,
            'message' => ['role' => 'user', 'content' => $content],
        ]);

        $response = $this->askChatGpt($session_id);

        if ($response->choices[0]->message->content) {
            ChatGptMessage::create([
                'session_id' => $session_id,
                'message' => ['role' => 'assistant', 'content' => $response->choices[0]->message->content],
            ]);
        } elseif (count($response->choices[0]->message->toolCalls) > 0) {
            ChatGptMessage::create([
                'session_id' => $session_id,
                'message' => ['role' => 'assistant', 'content' => '', 'tool_calls' => $response->choices[0]->message->toolCalls],
            ]);

            foreach ($response->choices[0]->message->toolCalls as $call) {
                $result = $this->callFunction($call->function->name, $call->function->arguments);
                ChatGptMessage::create([
                    'session_id' => $session_id,
                    'message' => ['role' => 'tool', 'content' => $result, 'tool_call_id' => $call->id, 'name' => $call->function->name],
                ]);
            }

            $response = $this->askChatGpt($session_id);
        }

        return $response->choices[0]->message;
    }

    private function askChatGpt(string $session_id)
    {
        $system = [['role' => 'system', 'content' => 'Eres un asistente de Recambios Vigo, servicio de venta de recambios para coches, ten en cuenta que esta informacion sera visualizada en la plataforma de WhatsApp y formatearas el contenido para que sea perfectamente leido.

                    Puedes responder a:
                    - En que estado se encuentra un vehículo, mostraras su historico de estados de forma ordenada y explicando por los diferentes estados que ha pasado.
                    - Crear una incidencia sobre un vehículo, para crear la incidencia necesitaras que te proporcione el usuario la matricula, descripcion de la incidencia y fecha.
                    - En que estado se encuentra un vehículo, mostraras su historico de estados de forma ordenada y explicando por los diferentes estados que ha pasado.
                    - Historico de todos los matenimientos de un vehiculo, dada toda la informacion de matenimientos con el plan y operaciones listaras los mantenimientos de forma ordenada y estructurada.

                    Ten en cuenta:
                    - Para saber el vehículo puedes solicitar la matricula.
                    - Sustituiras los identificadores de estados por el nombre en español 
                            DISCHARGED = 1
                            SOLD = 2
                            RENTED = 3
                            AVAILABLE = 4
                            WAITING_MAINTENANCE = 5
                            MAINTENANCE_PASSED = 6
                            OUT_OF_SERVICE = 7
                            GARAGE = 8
                            LOAN = 9
                            RESERVED = 10
                            PDI = 11
                            CALLOFF = 12

                    
        ']];
        $history = ChatGptMessage::where('session_id', $session_id)->pluck('message')->toArray();

        $result = app(\OpenAI::class)->chat()->create([
            'model' => 'gpt-4o',
            'messages' => array_merge($system, $history),
            'tools' => $this->getAvailableFunctions(),
        ]);

        return $result;
    }

    private function callFunction(string $func_name, string $args)
    {
        $args = json_decode($args);
        try {
            switch ($func_name) {
                case 'get_state_vehicle':
                    return json_encode(Vehicle::where('plate', $args->plate)->first()->stateHistory->toArray());
                case 'store_incident':
                    return $this->storeIncident($args);
                case 'get_counters':
                    return $this->getCounters($args);
                case 'get_customer_of_vehicle':
                    return json_encode(Vehicle::where('plate', $args->plate)->first()->customer->toArray());
                default:
                    dd($func_name, $args);
            }
        } catch (\Throwable $e) {
            return 'No se ha podido completar la solicitud.';
        }
    }

    private function transcribeAudio(string $meta_media_id)
    {
        $media = app(WhatsAppService::class)->getMedia($meta_media_id);
        $text = app(OpenAIService::class)->transcribe($media['raw_content'], $media['mime_type']);

        return $text;
    }

    private function getAvailableFunctions()
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_state_vehicle',
                    'description' => 'Obtiene el estado de vehículo dada su matricula.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'plate' => [
                                'type' => 'string',
                                'description' => 'Matricula del vehículo',
                            ]
                        ],
                        'required' => ['plate'],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'store_incident',
                    'description' => 'Crea una incidencia sobre un vehiculo',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'incidence' => [
                                'type' => 'string',
                                'description' => 'Descripción de la incidencia',
                            ],
                            'created_at' => [
                                'type' => 'string',
                                'format' => 'date-time',
                                'description' => 'Fecha de la incidencia en formato (ej. 2023-07-16)',
                            ],
                            'plate' => [
                                'type' => 'string',
                                'description' => 'Matricula del vehículo',
                            ]
                        ],
                        'required' => ['reference', 'created_at', 'plate'],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_counters',
                    'description' => 'Obtener historico de mantenimiento de un vehiculo',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'plate' => [
                                'type' => 'string',
                                'description' => 'Matricula del vehículo',
                            ]
                        ],
                        'required' => ['plate'],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_customer_of_vehicle',
                    'description' => 'Obtener datos del cliente asignado a un vehiculo',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'plate' => [
                                'type' => 'string',
                                'description' => 'Matricula del vehículo del cliente',
                            ]
                        ],
                        'required' => ['plate'],
                    ],
                ],
            ],
        ];
    }

    private function storeIncident(stdClass $args)
    {
        try {
            $vehicle = Vehicle::where('plate', $args->plate)
                ->where('fleet_id', 1) //revisar fleet 
                ->first();
            if ($vehicle) {
                $incident = VehicleIncident::create([
                    'user_id' => 637, //revisar autenticacion de usuario
                    'incidence' => $args->incidence,
                    'created_at' => $args->created_at,
                    'vehicle_id' => $vehicle->id
                ]);

                event(new IncidentOpened($incident));

                return json_encode($incident);
            }
            return 'No existe un vehiculo con matricula ' . $args->plate;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function getCounters(stdClass $args)
    {
        try {
            $vehicle = Vehicle::where('plate', $args->plate)
                ->where('fleet_id', 1) //revisar fleet 
                ->first();

                return json_encode($vehicle->counters()->with('plan.operations')->get()->toArray());
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
