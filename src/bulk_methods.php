<?php

namespace Litegram;

use GuzzleHttp\Promise;
use GuzzleHttp\Client;

class TelegramBulkMethods
{
    /**
     * @param array<CopyMessageParams> $copyMessageParamObjects
     */
    static function copyMessage(array $copyMessageParamObjects): bool
    {
        global $telegramApiUrl;

        $client = new Client([
            'base_uri' => '',
        ]);

        $promises = [];

        foreach ($copyMessageParamObjects as $copyMessageParamObject) {
            array_push(
                $promises,
                $client->requestAsync(
                    'POST',
                    $telegramApiUrl . '/copyMessage',
                    [
                        'json' => [
                            'chat_id' => $copyMessageParamObject->chat_id,
                            'from_chat_id' =>
                                $copyMessageParamObject->from_chat_id,
                            'message_id' => $copyMessageParamObject->message_id,
                        ],
                    ],
                ),
            );
        }

        $responses = Promise\Utils::settle($promises)->wait();
        if (is_iterable($responses)) {
            foreach ($responses as $index => $response) {
                if ($response['state'] != 'fulfilled') {
                    return false; // At least one has failed
                }
            }
        }

        return true;
    }
}
