<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class WaController extends Controller
{
    public function webhook(Request $request)
    {
        $verify_token = 'truckwatoken!';

        if ($request->hub_verify_token === $verify_token) {
            try {
                DB::table('wa')->insert([
                    'data' => json_encode($request->all()),
                ]);
            } catch (\Throwable $th) {
                return response($th->getMessage(), 200);
            }

            return response($request->hub_challenge, 200)->header('Content-Type', 'text/plain');
        } else {
            return response('Token mismatch', 403);
        }
    }

    public function receive(Request $request)
    {
        $senderNumber = $request->input('From') ?? '';
        $messageBody = $request->input('Body') ?? '';

        DB::table('wa')->insert([
            'phone' => $senderNumber,
            'message' => $messageBody,
            'data' => json_encode($request->all()),
        ]);

        //Route to IA command
        $event = $request->all();
        //It's text message
        if ($event['entry'][0]['changes'][0]['field'] == 'messages' && isset($event['entry'][0]['changes'][0]['value']['messages']) && $event['entry'][0]['changes'][0]['value']['messages'][0]['type'] == 'text') {
            $phone = $event['entry'][0]['changes'][0]['value']['messages'][0]['from'];
            $content = $event['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
            Artisan::call('whatsapp:assistant', ['session_id' => $phone, 'type' => 'text', 'content' => $content]);
        }
        //It's audio message
        elseif ($event['entry'][0]['changes'][0]['field'] == 'messages' && isset($event['entry'][0]['changes'][0]['value']['messages']) && $event['entry'][0]['changes'][0]['value']['messages'][0]['type'] == 'audio') {
            $phone = $event['entry'][0]['changes'][0]['value']['messages'][0]['from'];
            $content = $event['entry'][0]['changes'][0]['value']['messages'][0]['audio']['id'];
            Artisan::call('whatsapp:assistant', ['session_id' => $phone, 'type' => 'audio', 'content' => $content]);
        }

        return response()->json(['success' => true], 200);
    }
}
