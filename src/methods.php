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
        if (isset($GLOBALS['LITEGRAM_LOGGER'])) {
            try {
                $GLOBALS[$GLOBALS['LITEGRAM_LOGGER']]->debug(
                    json_encode(
                        $params,
                        JSON_UNESCAPED_UNICODE |
                            JSON_PRETTY_PRINT |
                            JSON_UNESCAPED_SLASHES,
                    ),
                );
            } catch (\Throwable $th) {
            }
        }

        global $telegramApiUrl;

        $client = new Client(['base_uri' => '']);
        $response = $client->post($telegramApiUrl . '/sendMessage', [
            'json' => $params,
        ]);

        return (object) [];
    }
}
