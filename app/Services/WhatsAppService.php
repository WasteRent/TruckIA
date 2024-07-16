<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function __construct(private string $token, private string $phone_id)
    {
    }

    public function send(string $phone, string $body)
    {
        return Http::withToken($this->token)
            ->post("https://graph.facebook.com/v16.0/{$this->phone_id}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'text',
                'text' => [
                    'body' => $body,
                ],
            ])
            ->json();
    }

    public function getMedia(string $id)
    {
        $media = Http::withToken($this->token)->get("https://graph.facebook.com/v16.0/{$id}")->json();
        $media['raw_content'] = Http::withToken($this->token)->get($media['url'])->body();

        return $media;
    }
}
