<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class OpenAIService
{
    const LASTEST_MODEL_4 = 'gpt-4o';

    public function chat(string $content, string $prompt)
    {
        $response = app(\OpenAI::class)->chat()->create([
            'model' => self::LASTEST_MODEL_4,
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => $content],
            ],
            'temperature' => 0,
            'response_format' => ['type' => 'json_object'],
        ]);

        return json_decode($response->choices[0]->message->content, true);
    }

    public function vision(string $prompt, string $file_base64, string $content_type, string $response_format = 'text')
    {
        $response = app(\OpenAI::class)->chat()->create([
            'model' => self::LASTEST_MODEL_4,
            'messages' => [
                ['role' => 'user', 'content' => [
                    ['type' => 'text', 'text' => $prompt],
                    ['type' => 'image_url', 'image_url' => ['url' => "data:{$content_type};base64,{$file_base64}"]],
                ]],
            ],
            'temperature' => 0,
            'response_format' => ['type' => $response_format],
        ]);

        return $response->choices[0]->message->content;
    }

    public function transcribe(string $raw_data, string $mime)
    {
        $name = md5($raw_data);
        $extension = explode('/', $mime)[1];
        $filename = "{$name}.{$extension}";

        if (Storage::disk('local')->put($filename, $raw_data)) {
            $path = storage_path("app/$filename");

            $response = app(\OpenAI::class)->audio()->transcribe([
                'model' => 'whisper-1',
                'file' => fopen($path, 'r'),
                'response_format' => 'verbose_json',
            ])->text;

            unlink($path);

            return $response;
        }

        throw new \Exception('error storing audio');
    }
}
