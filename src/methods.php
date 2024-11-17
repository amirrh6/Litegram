<?php

namespace Litegram;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;

class TelegramMethods
{
    static string $telegramApiUrl = 'https://api.telegram.org/bot';

    private static function jsonEncodeNonPrimaryFields(object $params)
    {
        $result = [];

        foreach (get_object_vars($params) as $property => $value) {
            if ($value === null) {
                continue;
            }

            if ($value instanceof InputFile) {
                $result[] = [
                    'name' => $property,
                    'contents' => fopen($value->_path, 'r'),
                ];
            } else {
                if (
                    !(
                        is_string($value) ||
                        is_numeric($value) ||
                        is_bool($value)
                    )
                ) {
                    $value = json_encode($value);
                } else {
                    if (is_bool($value)) {
                        $value = $value === true ? 'True' : 'False';
                    }
                }

                $result[] = [
                    'name' => $property,
                    'contents' => $value,
                ];
            }
        }

        return $result;
    }

    // -------------------------------------------------------------------

    /**
     * Use this method to receive incoming updates using long polling (wiki). Returns an Array of Update objects.
     * @return Update[]
     */
    static function getUpdates(
        string $token,
        GetUpdatesParams $params,
        $options = [],
    ): array {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . '/getUpdates',
            [
                'json' => $params,
            ],
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $updates = [];

        foreach ($body_decoded->result as $update) {
            $updates[] = new Update($update);
        }

        return $updates;
    }

    /**
     * Use this method to specify a URL and receive incoming updates via an outgoing webhook. Whenever there is an update for the bot, we will send an HTTPS POST request to the specified URL, containing a JSON-serialized Update. In case of an unsuccessful request, we will give up after a reasonable amount of attempts. Returns True on success.
     * If you'd like to make sure that the webhook was set by you, you can specify secret data in the parameter secret_token. If specified, the request will contain a header “X-Telegram-Bot-Api-Secret-Token” with the secret token as content.
     */
    static function setWebhook(
        string $token,
        SetWebhookParams $params,
        $options = [],
    ): true {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . '/setWebhook',
            [
                'json' => $params,
            ],
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    /**
     * Use this method to remove webhook integration if you decide to switch back to getUpdates. Returns True on success.
     */
    static function deleteWebhook(
        string $token,
        DeleteWebhookParams $params,
        $options = [],
    ): true {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . '/deleteWebhook',
            [
                'json' => $params,
            ],
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    /**
     * Use this method to get current webhook status. Requires no parameters. On success, returns a WebhookInfo object. If the bot is using getUpdates, will return an object with the url field empty.
     */
    static function getWebhookInfo(string $token, $options = []): WebhookInfo
    {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . '/getWebhookInfo',
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return new WebhookInfo($body_decoded->result);
    }

    // -------------------------------------------------------------------

    /**
     * A simple method for testing your bot's authentication token. Requires no parameters. Returns basic information about the bot in form of a User object.
     */
    static function getMe(string $token, $options = []): User
    {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(static::$telegramApiUrl . $token . '/getMe');

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return new User($body_decoded->result);
    }

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally. You must log out the bot before running it locally, otherwise there is no guarantee that the bot will receive updates. After a successful call, you can immediately log in on a local server, but will not be able to log in back to the cloud Bot API server for 10 minutes. Returns True on success. Requires no parameters.
     */
    static function logOut(string $token, $options = []): true
    {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(static::$telegramApiUrl . $token . '/logOut');

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another. You need to delete the webhook before calling this method to ensure that the bot isn't launched again after server restart. The method will return error 429 in the first 10 minutes after the bot is launched. Returns True on success. Requires no parameters.

     */
    static function close(string $token, $options = []): true
    {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(static::$telegramApiUrl . $token . '/close');

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    /**
     * Bulk version of copyMessage (Experimental)
     * @param array<CopyMessageParams> $array_of_params
     */
    static function _bulkCopyMessage(
        string $token,
        array $array_of_params,
        $options = [],
    ): PromiseInterface {
        $client = new Client(['base_uri' => '', ...$options]);

        $promises = [];

        foreach ($array_of_params as $copyMessageParamsObject) {
            array_push(
                $promises,
                $client->requestAsync(
                    'POST',
                    static::$telegramApiUrl . $token . '/copyMessage',
                    [
                        'json' => $copyMessageParamsObject,
                    ],
                ),
            );
        }

        return Utils::settle($promises);
    }

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

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     * @throws ClientException
     */
    static function sendPhoto(
        string $token,
        SendPhotoParams $params,
        $options = [],
    ): Message {
        $client = new Client(['base_uri' => '', ...$options]);

        if ($params->photo instanceof InputFile) {
            $multipart = [
                ...TelegramMethods::jsonEncodeNonPrimaryFields($params),
            ];

            $response = $client->post(
                static::$telegramApiUrl . $token . '/sendPhoto',
                [
                    'multipart' => $multipart,
                ],
            );
        } else {
            $response = $client->post(
                static::$telegramApiUrl . $token . '/sendPhoto',
                [
                    'json' => $params,
                ],
            );
        }

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return new Message($body_decoded->result);
    }

    /**
     * Use this method to send answers to callback queries sent from inline keyboards. The answer will be displayed to the user as a notification at the top of the chat screen or as an alert. On success, True is returned.
     * Alternatively, the user can be redirected to the specified Game URL. For this option to work, you must first create a game for your bot via @BotFather and accept the terms. Otherwise, you may use links like t.me/your_bot?start=XXXX that open your bot with a parameter.
     * @throws ClientException
     */
    static function answerCallbackQuery(
        string $token,
        AnswerCallbackQueryParams $params,
        $options = [],
    ): true {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . '/answerCallbackQuery',
            [
                'json' => $params,
            ],
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    // -------------------------------------------------------------------

    /**
     * Use this method to edit text and game messages. On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned. Note that business messages that were not sent by the bot and do not contain an inline keyboard can only be edited within 48 hours from the time they were sent.
     * @throws ClientException
     */
    static function editMessageText(
        string $token,
        EditMessageTextParams $params,
        $options = [],
    ): Message|true {
        $client = new Client(['base_uri' => '', ...$options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . '/editMessageText',
            [
                'json' => $params,
            ],
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        if (is_bool($body_decoded->result)) {
            return true;
        } else {
            return new Message($body_decoded->result);
        }
    }

    // -------------------------------------------------------------------
}
