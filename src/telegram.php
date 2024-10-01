<?php

function remove_invalid_tags(string $txt)
{
    return strip_tags($txt, [
        'b',
        'strong',
        'i',
        'em',
        'u',
        'ins',
        's',
        'strike',
        'del',
        'span',
        'tg-spoiler',
        'a',
        'tg-emoji',
        'code',
        'pre',
    ]);
}

class Telegram
{
    private string $bot_token;

    public function __construct(string $bot_token)
    {
        $this->bot_token = $bot_token;
    }

    /**
     * @return array{ok: mixed, description:mixed, error_code:mixed, parameters:mixed, result:mixed}
     */
    private static function send_request(
        string $url,
        mixed $payload,
        $content_type = 'application/json',
    ): array {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:$content_type"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);

        $ok = $description = $error_code = $parameters = $result = null;

        if (is_string($data)) {
            $data_decoded = json_decode($data);
            if (is_object($data_decoded)) {
                $ok = isset($data_decoded->ok) ? $data_decoded->ok : null;

                // If ok is false:
                $description = isset($data_decoded->description)
                    ? $data_decoded->description
                    : null;
                $error_code = isset($data_decoded->error_code)
                    ? $data_decoded->error_code
                    : null;
                $parameters = isset($data_decoded->parameters)
                    ? $data_decoded->parameters
                    : null;

                // If ok is true:
                $result = isset($data_decoded->result)
                    ? $data_decoded->result
                    : null;
            }
        }

        return [
            'ok' => $ok,
            'description' => $description,
            'error_code' => $error_code,
            'parameters' => $parameters,
            'result' => $result,
        ];
    }

    public static function je(mixed $data, bool $compress = false): string|false
    {
        if ($compress) {
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    // ---- ---- ---- ---- GETTING UPDATES ---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_updates(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to specify a URL and receive incoming updates via an outgoing webhook. Whenever there is an update for the bot, we will send an HTTPS POST request to the specified URL, containing a JSON-serialized Update. In case of an unsuccessful request, we will give up after a reasonable amount of attempts. Returns True on success.
     * If you'd like to make sure that the webhook was set by you, you can specify secret data in the parameter secret_token. If specified, the request will contain a header “X-Telegram-Bot-Api-Secret-Token” with the secret token as content
     * @param string $url HTTPS URL to send updates to. Use an empty string to remove webhook integration
     * @param mixed $certificate Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
     * @param string $ip_address The fixed IP address which will be used to send webhook requests instead of the IP address resolved through DNS
     * @param int $max_connections The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot's server, and higher values to increase your bot's throughput.
     * @param array<string> $allowed_updates A JSON-serialized list of the update types you want your bot to receive. For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member (default). If not specified, the previous setting will be used. Please note that this parameter doesn't affect updates created before the call to the setWebhook, so unwanted updates may be received for a short period of time.
     * @param bool $drop_pending_updates Pass True to drop all pending updates
     * @param string $secret_token A secret token to be sent in a header “X-Telegram-Bot-Api-Secret-Token” in every webhook request, 1-256 characters. Only characters A-Z, a-z, 0-9, _ and - are allowed. The header is useful to ensure that the request comes from a webhook set by you.
     */
    public function set_webhook(
        string $url,
        mixed $certificate = null,
        string $ip_address = null,
        int $max_connections = null,
        array $allowed_updates = null,
        bool $drop_pending_updates = null,
        string $secret_token = null,
    ): bool {
        $params = [
            'url' => $url,
        ];

        if ($certificate != null) {
            $params['certificate'] = $certificate;
        }

        if ($ip_address != null) {
            $params['ip_address'] = $ip_address;
        }

        if ($max_connections != null) {
            $params['max_connections'] = $max_connections;
        }

        if ($allowed_updates != null) {
            $params['allowed_updates'] = $allowed_updates;
        }

        if ($drop_pending_updates != null) {
            $params['drop_pending_updates'] = $drop_pending_updates;
        }

        if ($secret_token != null) {
            $params['secret_token'] = $secret_token;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/setWebhook';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return boolval($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_webhook(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to get current webhook status. Requires no parameters. On success, returns a WebhookInfo object. If the bot is using getUpdates, will return an object with the url field empty.
     */
    function get_webhook_info(): WebhookInfo
    {
        $params = [];

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/getWebhookInfo';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return new WebhookInfo($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    // ---- ---- ---- ---- AVAILABLE METHODS ---- ---- ---- ----

    /**
     * A simple method for testing your bot's authentication token. Requires no parameters. Returns basic information about the bot in form of a User object.
     */
    function get_me(): User
    {
        $params = [];

        $telegram_api_url =
            'https://api.telegram.org:443/bot' . $this->bot_token . '/getMe';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return new User($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function log_out(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function close(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * @param string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param int $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param array<MessageEntity> $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool $disable_web_page_preview Disables link previews for links in this message
     * @param bool $disable_notification Sends the message silently. Users will receive a notification with no s
     * @param bool $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     */
    function send_message(
        string|int $chat_id,
        string $text,
        int $message_thread_id = null,
        string $parse_mode = null,
        array $entities = null,
        bool $disable_web_page_preview = null,
        bool $disable_notification = null,
        bool $protect_content = null,
        int $reply_to_message_id = null,
        bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup = null,
    ): Message {
        $params = [
            'chat_id' => $chat_id,
            'text' => $text,
        ];

        if ($message_thread_id != null) {
            $params['message_thread_id'] = $message_thread_id;
        }

        if ($parse_mode != null) {
            $params['parse_mode'] = $parse_mode;
        }

        if ($text != null && $parse_mode == 'HTML') {
            $params['text'] = remove_invalid_tags($params['text']);
        }

        if ($entities != null) {
            $params['entities'] = $entities;
        }

        if ($disable_web_page_preview != null) {
            $params['disable_web_page_preview'] = $disable_web_page_preview;
        }

        if ($disable_notification != null) {
            $params['disable_notification'] = $disable_notification;
        }

        if ($protect_content != null) {
            $params['protect_content'] = $protect_content;
        }

        if ($reply_to_message_id != null) {
            $params['reply_to_message_id'] = $reply_to_message_id;
        }

        if ($allow_sending_without_reply != null) {
            $params[
                'allow_sending_without_reply'
            ] = $allow_sending_without_reply;
        }

        if ($reply_markup != null) {
            $params['reply_markup'] = $reply_markup;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/sendMessage';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return new Message($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function forward_message(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to copy messages of any kind. Service messages and invoice messages can't be copied. A quiz poll can be copied only if the value of the field correct_option_id is known to the bot. The method is analogous to the method forwardMessage, but the copied message doesn't have a link to the original message. Returns the MessageId of the sent message on success.
     * @param string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|int $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param int $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string $caption New caption for media, 0-1024 characters after entities parsing. If not specified, the original caption is kept
     * @param string $parse_mode Mode for parsing entities in the new caption. See formatting options for more details.
     * @param array<MessageEntity> $caption_entities A JSON-serialized list of special entities that appear in the new caption, which can be specified instead of parse_mode
     * @param bool $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     */
    function copy_message(
        string|int $chat_id,
        string|int $from_chat_id,
        int $message_id,
        int $message_thread_id = null,
        string $caption = null,
        string $parse_mode = null,
        array $caption_entities = null,
        bool $disable_notification = null,
        bool $protect_content = null,
        int $reply_to_message_id = null,
        bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup = null,
    ): MessageId {
        $params = [
            'chat_id' => $chat_id,
            'from_chat_id' => $from_chat_id,
            'message_id' => $message_id,
        ];

        if ($message_thread_id != null) {
            $params['message_thread_id'] = $message_thread_id;
        }

        if ($caption != null) {
            $params['caption'] = $caption;
        }

        if ($parse_mode != null) {
            $params['parse_mode'] = $parse_mode;
        }

        if ($caption_entities != null) {
            $params['caption_entities'] = $caption_entities;
        }

        if ($disable_notification != null) {
            $params['disable_notification'] = $disable_notification;
        }

        if ($protect_content != null) {
            $params['protect_content'] = $protect_content;
        }

        if ($reply_to_message_id != null) {
            $params['reply_to_message_id'] = $reply_to_message_id;
        }

        if ($allow_sending_without_reply != null) {
            $params[
                'allow_sending_without_reply'
            ] = $allow_sending_without_reply;
        }

        if ($reply_markup != null) {
            $params['reply_markup'] = $reply_markup;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/copyMessage';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return new MessageId($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_photo(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_audio(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to send general files. On success, the sent Message is returned. Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     * @param string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param InputFile|string $document File to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. More information on Sending Files »
     * @param int $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param InputFile|string $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files »
     * @param string $caption New caption for media, 0-1024 characters after entities parsing. If not specified, the original caption is kept
     * @param string $parse_mode Mode for parsing entities in the new caption. See formatting options for more details.
     * @param array<MessageEntity> $caption_entities A JSON-serialized list of special entities that appear in the new caption, which can be specified instead of parse_mode
     * @param bool $disable_content_type_detection Disables automatic server-side content type detection for files uploaded using multipart/form-data
     * @param bool $disable_notification Sends the message silently. Users will receive a notification with no sound.
     * @param bool $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     */
    function send_document(
        string|int $chat_id,
        InputFile|string $document,
        int $message_thread_id = null,
        InputFile|string $thumbnail = null,
        string $caption = null,
        string $parse_mode = null,
        array $caption_entities = null,
        bool $disable_content_type_detection = null,
        bool $disable_notification = null,
        bool $protect_content = null,
        int $reply_to_message_id = null,
        bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup = null,
    ): Message {
        $params = [
            'chat_id' => $chat_id,
            'document' => $document,
        ];

        if ($message_thread_id != null) {
            $params['message_thread_id'] = $message_thread_id;
        }

        if ($thumbnail != null) {
            $params['thumbnail'] = $thumbnail;
        }

        if ($caption != null) {
            $params['caption'] = $caption;
        }

        if ($parse_mode != null) {
            $params['parse_mode'] = $parse_mode;
        }

        if (isset($params['caption']) && $parse_mode == 'HTML') {
            $params['caption'] = remove_invalid_tags($params['caption']);
        }

        if ($caption_entities != null) {
            $params['caption_entities'] = $caption_entities;
        }

        if ($disable_content_type_detection != null) {
            $params[
                'disable_content_type_detection'
            ] = $disable_content_type_detection;
        }

        if ($disable_notification != null) {
            $params['disable_notification'] = $disable_notification;
        }

        if ($protect_content != null) {
            $params['protect_content'] = $protect_content;
        }

        if ($reply_to_message_id != null) {
            $params['reply_to_message_id'] = $reply_to_message_id;
        }

        if ($allow_sending_without_reply != null) {
            $params[
                'allow_sending_without_reply'
            ] = $allow_sending_without_reply;
        }

        if ($reply_markup != null) {
            $params['reply_markup'] = $reply_markup;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/sendDocument';

        // ---

        if ($document instanceof InputFile || $thumbnail instanceof InputFile) {
            if ($document instanceof InputFile) {
                $params['document'] = new CURLFile($document->_path);
            }

            if ($thumbnail instanceof InputFile) {
                $params['thumbnail'] = new CURLFile($thumbnail->_path);
            }

            $payload = $params;
            $response = self::send_request(
                $telegram_api_url,
                $payload,
                'multipart/form-data',
            );
        } else {
            $payload = self::je($params);
            $response = self::send_request($telegram_api_url, $payload);
        }

        if ($response['ok']) {
            return new Message($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_video(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_animation(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_voice(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_video_note(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_media_group(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_location(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_venue(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_contact(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_poll(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_dice(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_chat_action(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_user_profile_photos(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_file(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function ban_chat_member(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unban_chat_member(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function restrict_chat_member(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function promote_chat_member(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_administrator_custom_title(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function ban_chat_sender_chat(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unban_chat_sender_chat(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_permissions(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function export_chat_invite_link(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function create_chat_invite_link(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_chat_invite_link(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function revoke_chat_invite_link(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function approve_chat_join_request(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function decline_chat_join_request(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_photo(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_chat_photo(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_title(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_description(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function pin_chat_message(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unpin_chat_message(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unpin_all_chat_messages(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function leave_chat(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_chat(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_chat_administrators(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_chat_member_count(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to get information about a member of a chat. The method is only guaranteed to work for other users if the bot is an administrator in the chat. Returns a ChatMember object on success.
     * @param string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     */
    function get_chat_member(string|int $chat_id, int $user_id): ChatMember
    {
        $params = [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
        ];

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/getChatMember';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return new ChatMember($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_sticker_set(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_chat_sticker_set(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_forum_topic_icon_stickers(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function create_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function close_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function reopen_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unpin_all_forum_topic_messages(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_general_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function close_general_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function reopen_general_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function hide_general_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unhide_general_forum_topic(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to send answers to callback queries sent from inline keyboards. The answer will be displayed to the user as a notification at the top of the chat screen or as an alert. On success, True is returned.
     * @param string $callback_query_id Unique identifier for the query to be answered
     * @param string $text Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters
     * @param bool $show_alert If True, an alert will be shown by the client instead of a notification at the top of the chat screen. Defaults to false.
     * @param string $url URL that will be opened by the user's client. If you have created a Game and accepted the conditions via @BotFather, specify the URL that opens your game - note that this will only work if the query comes from a callback_game button. Otherwise, you may use links like t.me/your_bot?start=XXXX that open your bot with a parameter.
     * @param int $cache_time The maximum amount of time in seconds that the result of the callback query may be cached client-side. Telegram apps will support caching starting in version 3.14. Defaults to 0.
     */
    function answer_callback_query(
        string $callback_query_id,
        string $text = null,
        bool $show_alert = null,
        string $url = null,
        int $cache_time = null,
    ): bool {
        $params = [
            'callback_query_id' => $callback_query_id,
        ];

        if ($text != null) {
            $params['text'] = $text;
        }

        if ($show_alert != null) {
            $params['show_alert'] = $show_alert;
        }

        if ($url != null) {
            $params['url'] = $url;
        }

        if ($cache_time != null) {
            $params['cache_time'] = $cache_time;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/answerCallbackQuery';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return boolval($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * Use this method to change the list of the bot's commands. See this manual for more details about bot commands. Returns True on success.
     * @param array<BotCommand> $commands A JSON-serialized list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     * @param BotCommandScopeDefault|BotCommandScopeAllPrivateChats|BotCommandScopeAllGroupChats|BotCommandScopeAllChatAdministrators|BotCommandScopeChat|BotCommandScopeChatAdministrators|BotCommandScopeChatMember $scope A JSON-serialized object, describing scope of users for which the commands are relevant. Defaults to BotCommandScopeDefault.
     * @param string $language_code A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     */
    function set_my_commands(
        array $commands,
        BotCommandScopeDefault|BotCommandScopeAllPrivateChats|BotCommandScopeAllGroupChats|BotCommandScopeAllChatAdministrators|BotCommandScopeChat|BotCommandScopeChatAdministrators|BotCommandScopeChatMember $scope = null,
        string $language_code = null,
    ): bool {
        $params = [
            'commands' => $commands,
        ];

        if ($scope != null) {
            $params['scope'] = $scope;
        }

        if ($language_code != null) {
            $params['language_code'] = $language_code;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/setMyCommands';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return boolval($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_my_commands(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to get the current list of the bot's commands for the given scope and user language. Returns an Array of BotCommand objects. If commands aren't set, an empty list is returned.
     * @param BotCommandScopeDefault|BotCommandScopeAllPrivateChats|BotCommandScopeAllGroupChats|BotCommandScopeAllChatAdministrators|BotCommandScopeChat|BotCommandScopeChatAdministrators|BotCommandScopeChatMember $scope A JSON-serialized object, describing scope of users. Defaults to BotCommandScopeDefault.
     * @param string $language_code A two-letter ISO 639-1 language code or an empty string
     * @return array<BotCommand>
     */
    function get_my_commands($scope = null, string $language_code = null): array
    {
        $params = [];

        if ($scope != null) {
            $params['scope'] = $scope;
        }

        if ($language_code != null) {
            $params['language_code'] = $language_code;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/getMyCommands';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            $bot_commands_array = [];

            if (is_iterable($response['result'])) {
                foreach ($response['result'] as $obj) {
                    $bot_commands_array[] = new BotCommand($obj);
                }
            }

            return $bot_commands_array;
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * Use this method to change the bot's name. Returns True on success.
     * @param string $name New bot name; 0-64 characters. Pass an empty string to remove the dedicated name for the given language.
     * @param string $language_code A two-letter ISO 639-1 language code. If empty, the name will be shown to all users for whose language there is no dedicated name.
     */
    function set_my_name(
        string $name = null,
        string $language_code = null,
    ): bool {
        $params = [];

        if ($name != null) {
            $params['name'] = $name;
        }

        if ($language_code != null) {
            $params['language_code'] = $language_code;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/setMyName';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return boolval($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * Use this method to get the current bot name for the given user language. Returns BotName on success.
     * @param string $language_code A two-letter ISO 639-1 language code or an empty string
     */
    function get_my_name(string $language_code = null): BotName
    {
        $params = [];

        if ($language_code != null) {
            $params['language_code'] = $language_code;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/getMyName';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return new BotName($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * Use this method to change the bot's description, which is shown in the chat with the bot if the chat is empty. Returns True on success.
     * @param string $description New bot description; 0-512 characters. Pass an empty string to remove the dedicated description for the given language.
     * @param string $language_code A two-letter ISO 639-1 language code. If empty, the description will be applied to all users for whose language there is no dedicated description.
     */
    function set_my_description(
        string $description = null,
        string $language_code = null,
    ): bool {
        $params = [];

        if ($description != null) {
            $params['description'] = $description;
        }

        if ($language_code != null) {
            $params['language_code'] = $language_code;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/setMyDescription';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return boolval($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * Use this method to get the current bot description for the given user language. Returns BotDescription on success.
     * @param string $language_code A two-letter ISO 639-1 language code or an empty string
     */
    function get_my_description(string $language_code = null): BotDescription
    {
        $params = [];

        if ($language_code != null) {
            $params['language_code'] = $language_code;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/getMyDescription';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return new BotDescription($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * Use this method to change the bot's short description, which is shown on the bot's profile page and is sent together with the link when users share the bot. Returns True on success.
     * @param string $short_description New short description for the bot; 0-120 characters. Pass an empty string to remove the dedicated short description for the given language.
     * @param string $language_code A two-letter ISO 639-1 language code. If empty, the short description will be applied to all users for whose language there is no dedicated short description.
     */
    function set_my_short_description(
        string $short_description = null,
        string $language_code = null,
    ): bool {
        $params = [];

        if ($short_description != null) {
            $params['short_description'] = $short_description;
        }

        if ($language_code != null) {
            $params['language_code'] = $language_code;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/setMyShortDescription';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return boolval($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }
    /**
     * Use this method to get the current bot description for the given user language. Returns BotDescription on success.
     * @param string $language_code A two-letter ISO 639-1 language code or an empty string
     */
    function get_my_short_description(
        string $language_code = null,
    ): BotShortDescription {
        $params = [];

        if ($language_code != null) {
            $params['language_code'] = $language_code;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/getMyShortDescription';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return new BotShortDescription($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_menu_button(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_chat_menu_button(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_my_default_administrator_rights(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_my_default_administrator_rights(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    // ---- ---- ---- ---- UPDATING MESSAGES ---- ---- ---- ----

    /**
     * Use this method to edit text and game messages. On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     * @param string $text New text of the message, 1-4096 characters after entities parsing
     * @param string|int $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param string $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param array<MessageEntity> $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool $disable_web_page_preview Disables link previews for links in this message
     * @param InlineKeyboardMarkup $reply_markup A JSON-serialized object for an inline keyboard.
     */
    function edit_message_text(
        string $text,
        string|int $chat_id = null,
        int $message_id = null,
        string $inline_message_id = null,
        string $parse_mode = null,
        array $entities = null,
        bool $disable_web_page_preview = null,
        InlineKeyboardMarkup $reply_markup = null,
    ): bool|Message {
        $params = [
            'text' => $text,
        ];

        if ($chat_id != null) {
            $params['chat_id'] = $chat_id;
        }

        if ($message_id != null) {
            $params['message_id'] = $message_id;
        }

        if ($inline_message_id != null) {
            $params['inline_message_id'] = $inline_message_id;
        }

        if ($parse_mode != null) {
            $params['parse_mode'] = $parse_mode;
        }

        if ($text != null && $parse_mode == 'HTML') {
            $params['text'] = remove_invalid_tags($params['text']);
        }

        if ($entities != null) {
            $params['entities'] = $entities;
        }

        if ($disable_web_page_preview != null) {
            $params['disable_web_page_preview'] = $disable_web_page_preview;
        }

        if ($reply_markup != null) {
            $params['reply_markup'] = $reply_markup;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/editMessageText';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            if (is_bool($response['result'])) {
                return $response['result'];
            }

            return new Message($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_message_caption(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_message_media(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_message_live_location(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function stop_message_live_location(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * Use this method to edit only the reply markup of messages. On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     * @param string|int $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param int $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup $reply_markup A JSON-serialized object for an inline keyboard.
     */
    function edit_message_reply_markup(
        string|int $chat_id = null,
        int $message_id = null,
        string $inline_message_id = null,
        InlineKeyboardMarkup $reply_markup = null,
    ): bool|Message {
        $params = [];

        if ($chat_id != null) {
            $params['chat_id'] = $chat_id;
        }

        if ($message_id != null) {
            $params['message_id'] = $message_id;
        }

        if ($inline_message_id != null) {
            $params['inline_message_id'] = $inline_message_id;
        }
        if ($reply_markup != null) {
            $params['reply_markup'] = $reply_markup;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/editMessageReplyMarkup';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            if (is_bool($response['result'])) {
                return $response['result'];
            }

            return new Message($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function stop_poll(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_message(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    // ---- ---- ---- ---- STICKERS---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_sticker(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_sticker_set(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_custom_emoji_stickers(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function upload_sticker_file(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function create_new_sticker_set(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function add_sticker_to_set(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_position_in_set(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_sticker_from_set(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_emoji_list(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_keywords(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_mask_position(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_set_title(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_set_thumbnail(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_custom_emoji_sticker_set_thumbnail(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_sticker_set(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    // ---- ---- ---- ---- INLINE MODE ---- ---- ---- ----

    /**
     * Use this method to send answers to an inline query. On success, True is returned. No more than 50 results per query are allowed.
     * @param string $inline_query_id Unique identifier for the answered query
     * @param array<InlineQueryResult> $results A JSON-serialized array of results for the inline query
     * @param int $cache_time The maximum amount of time in seconds that the result of the inline query may be cached on the server. Defaults to 300.
     * @param bool $is_personal Pass True if results may be cached on the server side only for the user that sent the query. By default, results may be returned to any user who sends the same query
     * @param string $next_offset Pass the offset that a client should send in the next query with the same text to receive more results. Pass an empty string if there are no more results or if you don't support pagination. Offset length can't exceed 64 bytes.
     * @param InlineQueryResultsButton $button A JSON-serialized object describing a button to be shown above inline query results
     */
    function answer_inline_query(
        string $inline_query_id,
        array $results,
        int $cache_time = null,
        bool $is_personal = null,
        string $next_offset = null,
        InlineQueryResultsButton $button = null,
    ): bool {
        $params = [
            'inline_query_id' => $inline_query_id,
            'results' => $results,
        ];

        if ($cache_time != null) {
            $params['cache_time'] = $cache_time;
        }

        if ($is_personal != null) {
            $params['is_personal'] = $is_personal;
        }

        if ($next_offset != null) {
            $params['next_offset'] = $next_offset;
        }

        if ($button != null) {
            $params['button'] = $button;
        }

        $telegram_api_url =
            'https://api.telegram.org:443/bot' .
            $this->bot_token .
            '/answerInlineQuery';

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response['ok']) {
            return boolval($response['result']);
        } else {
            if (gettype($response['description']) == 'string') {
                throw new Exception($response['description']);
            } else {
                throw new Exception('Error!');
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function answer_web_app_query(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    // ---- ---- ---- ---- PAYMENTS ---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_invoice(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function create_invoice_link(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function answer_shipping_query(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function answer_pre_checkout_query(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    // ---- ---- ---- ---- TELEGRAM PASSPORT ---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_passport_data_errors(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    // ---- ---- ---- ---- GAMES ---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_game(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_game_score(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_game_high_scores(): void
    {
        throw new Error('NOT IMPLEMENTED YET');
    }
}
