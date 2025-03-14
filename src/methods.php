<?php

namespace Litegram;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;

class TelegramMethods
{
    static string $telegramApiUrl = 'https://api.telegram.org/bot';

    private static function _jsonEncodeNonPrimaryFields(object $params)
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

    /**
     * @throws GuzzleException
     */
    private static function _sendRequest(
        string $token,
        string $methodUrl,
        array $options,
        array $guzzle_options,
    ) {
        $final_guzzle_options = [];

        if (count($guzzle_options) != 0) {
            $final_guzzle_options = $guzzle_options;
        } elseif (
            isset($GLOBALS['global_guzzle_options']) &&
            is_array($GLOBALS['global_guzzle_options'])
        ) {
            $final_guzzle_options = $GLOBALS['global_guzzle_options'];
        } else {
            $final_guzzle_options = ['timeout' => 10];
        }

        $client = new Client(['base_uri' => '', ...$final_guzzle_options]);

        $response = $client->post(
            static::$telegramApiUrl . $token . "/$methodUrl",
            $options,
        );

        $body = (string) $response->getBody();
        $body_decoded = json_decode($body);

        return $body_decoded;
    }

    private static function _getMethodName(string $classMethodName)
    {
        return substr($classMethodName, strrpos($classMethodName, '::') + 2);
    }

    // -------------------------------------------------------------------

    /**
     * Use this method to receive incoming updates using long polling (wiki). Returns an Array of Update objects.
     * @return Update[]
     * @throws Exception
     */
    static function getUpdates(
        string $token,
        GetUpdatesParams $params,
        $guzzle_options = [],
    ): array {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $updates = [];
        foreach ($body_decoded->result as $update) {
            $updates[] = Update::build($update);
        }
        return $updates;
    }

    /**
     * Use this method to specify a URL and receive incoming updates via an outgoing webhook. Whenever there is an update for the bot, we will send an HTTPS POST request to the specified URL, containing a JSON-serialized Update. In case of an unsuccessful request, we will give up after a reasonable amount of attempts. Returns True on success.
     * If you'd like to make sure that the webhook was set by you, you can specify secret data in the parameter secret_token. If specified, the request will contain a header “X-Telegram-Bot-Api-Secret-Token” with the secret token as content.
     * @return true
     * @throws Exception
     */
    static function setWebhook(
        string $token,
        SetWebhookParams $params,
        $guzzle_options = [],
    ): true {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    /**
     * Use this method to remove webhook integration if you decide to switch back to getUpdates. Returns True on success.
     * @return true
     * @throws Exception
     */
    static function deleteWebhook(
        string $token,
        DeleteWebhookParams $params,
        $guzzle_options = [],
    ): true {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    /**
     * Use this method to get current webhook status. Requires no parameters. On success, returns a WebhookInfo object. If the bot is using getUpdates, will return an object with the url field empty.
     * @return WebhookInfo
     * @throws Exception
     */
    static function getWebhookInfo(
        string $token,
        $guzzle_options = [],
    ): WebhookInfo {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $obj = new WebhookInfo();
        $obj->__FillPropsFromObject($body_decoded->result);

        return $obj;
    }

    // -------------------------------------------------------------------

    /**
     * A simple method for testing your bot's authentication token. Requires no parameters. Returns basic information about the bot in form of a User object.
     * @return User
     * @throws Exception
     */
    static function getMe(string $token, $guzzle_options = []): User
    {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $obj = new User();
        $obj->__FillPropsFromObject($body_decoded->result);

        return $obj;
    }

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally. You must log out the bot before running it locally, otherwise there is no guarantee that the bot will receive updates. After a successful call, you can immediately log in on a local server, but will not be able to log in back to the cloud Bot API server for 10 minutes. Returns True on success. Requires no parameters.
     * @return true
     * @throws Exception
     */
    static function logOut(string $token, $guzzle_options = []): true
    {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another. You need to delete the webhook before calling this method to ensure that the bot isn't launched again after server restart. The method will return error 429 in the first 10 minutes after the bot is launched. Returns True on success. Requires no parameters.
     * @return true
     * @throws Exception
     */
    static function close(string $token, $guzzle_options = []): true
    {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * @return Message
     * @throws Exception
     */
    static function sendMessage(
        string $token,
        SendMessageParams $params,
        $guzzle_options = [],
    ): Message {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $obj = new Message();
        $obj->__FillPropsFromObject($body_decoded->result);

        return $obj;
    }

    /**
     * Use this method to forward messages of any kind. Service messages and messages with protected content can't be forwarded. On success, the sent Message is returned.
     * @return Message
     * @throws Exception
     */
    static function forwardMessage(
        string $token,
        ForwardMessageParams $params,
        $guzzle_options = [],
    ): Message {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $obj = new Message();
        $obj->__FillPropsFromObject($body_decoded->result);

        return $obj;
    }

    /**
     * Use this method to forward multiple messages of any kind. If some of the specified messages can't be found or forwarded, they are skipped. Service messages and messages with protected content can't be forwarded. Album grouping is kept for forwarded messages. On success, an array of MessageId of the sent messages is returned.
     * @return array<MessageId>
     * @throws Exception
     */
    static function forwardMessages(
        string $token,
        ForwardMessagesParams $params,
        $guzzle_options = [],
    ): array {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $array = [];

        foreach ($body_decoded->result as $result) {
            $obj = new MessageId();
            $obj->__FillPropsFromObject($result);
            $array[] = $obj;
        }

        return $array;
    }

    /**
     * Use this method to copy messages of any kind. Service messages, paid media messages, giveaway messages, giveaway winners messages, and invoice messages can't be copied. A quiz poll can be copied only if the value of the field correct_option_id is known to the bot. The method is analogous to the method forwardMessage, but the copied message doesn't have a link to the original message. Returns the MessageId of the sent message on success.
     * @return MessageId
     * @throws Exception
     */
    static function copyMessage(
        string $token,
        CopyMessageParams $params,
        $guzzle_options = [],
    ): MessageId {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $obj = new MessageId();
        $obj->__FillPropsFromObject($body_decoded->result);

        return $obj;
    }

    /**
     * Use this method to copy messages of any kind. If some of the specified messages can't be found or copied, they are skipped. Service messages, paid media messages, giveaway messages, giveaway winners messages, and invoice messages can't be copied. A quiz poll can be copied only if the value of the field correct_option_id is known to the bot. The method is analogous to the method forwardMessages, but the copied messages don't have a link to the original message. Album grouping is kept for copied messages. On success, an array of MessageId of the sent messages is returned.
     * @return array<MessageId>
     * @throws Exception
     */
    static function copyMessages(
        string $token,
        CopyMessagesParams $params,
        $guzzle_options = [],
    ): array {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $array = [];

        foreach ($body_decoded->result as $result) {
            $obj = new MessageId();
            $obj->__FillPropsFromObject($result);
            $array[] = $obj;
        }

        return $array;
    }

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     * @return Message
     * @throws Exception
     */
    static function sendPhoto(
        string $token,
        SendPhotoParams $params,
        $guzzle_options = [],
    ): Message {
        if ($params->photo instanceof InputFile) {
            $options = [
                'multipart' => [
                    ...TelegramMethods::_jsonEncodeNonPrimaryFields($params),
                ],
            ];
        } else {
            $options = [
                'json' => $params,
            ];
        }

        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            $options,
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $obj = new Message();
        $obj->__FillPropsFromObject($body_decoded->result);

        return $obj;
    }

    /**
     * Use this method to send general files. On success, the sent Message is returned. Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     * @return Message
     * @throws Exception
     */
    static function sendDocument(
        string $token,
        SendDocumentParams $params,
        $guzzle_options = [],
    ): Message {
        if (
            $params->document instanceof InputFile ||
            $params->thumbnail instanceof InputFile
        ) {
            $options = [
                'multipart' => [
                    ...TelegramMethods::_jsonEncodeNonPrimaryFields($params),
                ],
            ];
        } else {
            $options = [
                'json' => $params,
            ];
        }

        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            $options,
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        $obj = new Message();
        $obj->__FillPropsFromObject($body_decoded->result);

        return $obj;
    }

    /**
     * Use this method to send answers to callback queries sent from inline keyboards. The answer will be displayed to the user as a notification at the top of the chat screen or as an alert. On success, True is returned.
     * Alternatively, the user can be redirected to the specified Game URL. For this option to work, you must first create a game for your bot via @BotFather and accept the terms. Otherwise, you may use links like t.me/your_bot?start=XXXX that open your bot with a parameter.
     * @return true
     * @throws Exception
     */
    static function answerCallbackQuery(
        string $token,
        AnswerCallbackQueryParams $params,
        $guzzle_options = [],
    ): true {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        return true;
    }

    // -------------------------------------------------------------------

    /**
     * Bulk version of copyMessage (Experimental)
     * @param array<CopyMessageParams> $array_of_params
     * @return PromiseInterface
     */
    static function _bulkCopyMessage(
        string $token,
        array $array_of_params,
        $guzzle_options = [],
    ): PromiseInterface {
        $final_guzzle_options = [];

        if (count($guzzle_options) != 0) {
            $final_guzzle_options = $guzzle_options;
        } elseif (
            isset($GLOBALS['global_guzzle_options']) &&
            is_array($GLOBALS['global_guzzle_options'])
        ) {
            $final_guzzle_options = $GLOBALS['global_guzzle_options'];
        } else {
            $final_guzzle_options = ['timeout' => 10];
        }

        $client = new Client(['base_uri' => '', ...$final_guzzle_options]);

        $promises = [];

        // TODO: Adapt the code style of the ordinary functions

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

    // -------------------------------------------------------------------

    /**
     * Use this method to edit text and game messages. On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned. Note that business messages that were not sent by the bot and do not contain an inline keyboard can only be edited within 48 hours from the time they were sent.
     * @return Message|true
     * @throws Exception
     */
    static function editMessageText(
        string $token,
        EditMessageTextParams $params,
        $guzzle_options = [],
    ): Message|true {
        $body_decoded = TelegramMethods::_sendRequest(
            $token,
            TelegramMethods::_getMethodName(__METHOD__),
            [
                'json' => $params,
            ],
            $guzzle_options,
        );

        if (!is_object($body_decoded)) {
            throw new Exception('Could not decode the response!');
        }

        if (is_bool($body_decoded->result)) {
            return true;
        } else {
            $obj = new Message();
            $obj->__FillPropsFromObject($body_decoded->result);

            return $obj;
        }
    }

    // -------------------------------------------------------------------
}
