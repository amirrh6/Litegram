<?php

use GuzzleHttp\Client;

class TelegramMethods
{
    static function copyMessage(SendMessageParams $params): object
    {
        global $telegramApiUrl;

        $client = new Client(['base_uri' => '']);
        $response = $client->post($telegramApiUrl . '/copyMessage', [
            'json' => $params,
        ]);

        return (object) [];
    }

    static function sendMessage(SendMessageParams $params): object
    {
        global $telegramApiUrl;

        $client = new Client(['base_uri' => '']);
        $response = $client->post($telegramApiUrl . '/sendMessage', [
            'json' => $params,
        ]);

        return (object) [];
    }
}
