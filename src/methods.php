<?php

namespace Litegram;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class TelegramMethods
{
    static string $telegramApiUrl = 'https://api.telegram.org/bot';

    /**
     * Use this method to copy messages of any kind. Service messages, paid media messages, giveaway messages, giveaway winners messages, and invoice messages can't be copied. A quiz poll can be copied only if the value of the field correct_option_id is known to the bot. The method is analogous to the method forwardMessage, but the copied message doesn't have a link to the original message. Returns the MessageId of the sent message on success.
     * @throws ClientException
     */
    static function copyMessage(
        string $token,
        CopyMessageParams $params,
        $options = [],
    ): MessageId {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . '/copyMessage',
            [
                'json' => $params,
            ],
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return new MessageId($body_decoded->result);
    }

    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * @throws ClientException
     */
    static function sendMessage(
        string $token,
        SendMessageParams $params,
        $options = [],
    ): Message {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . '/sendMessage',
            [
                'json' => $params,
            ],
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return new Message($body_decoded->result);
    }
}
