<?php

namespace Litegram;

class GetUpdatesParams extends CustomJsonSerialization
{
    public $limit;
    public $offset;
    public $timeout;
    public $allowed_updates;

    /**
     * @param ?int $offset Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates. By default, updates starting with the earliest unconfirmed update are returned. An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id. The negative offset can be specified to retrieve updates starting from -offset update from the end of the updates queue. All previous updates will be forgotten.
     * @param ?int $limit Limits the number of updates to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @param ?int $timeout Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling. Should be positive, short polling should be used for testing purposes only.
     * @param ?array<string> $allowed_updates A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used. Please note that this parameter doesn't affect updates created before the call to the getUpdates, so unwanted updates may be received for a short period of time.
     */
    public static function build(
        ?int $limit = null,
        ?int $offset = null,
        ?int $timeout = null,
        ?array $allowed_updates = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->limit = $limit;
        $obj->offset = $offset;
        $obj->timeout = $timeout;
        $obj->allowed_updates = $allowed_updates;

        return $obj;
    }
}

class SetWebhookParams extends CustomJsonSerialization
{
    public $url;
    public $certificate;
    public $ip_address;
    public $max_connections;
    public $allowed_updates;
    public $drop_pending_updates;
    public $secret_token;

    /**
     * @param string $url HTTPS URL to send updates to. Use an empty string to remove webhook integration
     * @param ?InputFile $certificate Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
     * @param ?string $ip_address The fixed IP address which will be used to send webhook requests instead of the IP address resolved through DNS
     * @param ?int $max_connections The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot's server, and higher values to increase your bot's throughput.
     * @param ?array<string> $allowed_updates A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used. Please note that this parameter doesn't affect updates created before the call to the setWebhook, so unwanted updates may be received for a short period of time.
     * @param ?bool $drop_pending_updates Pass True to drop all pending updates
     * @param ?string $secret_token A secret token to be sent in a header “X-Telegram-Bot-Api-Secret-Token” in every webhook request, 1-256 characters. Only characters A-Z, a-z, 0-9, _ and - are allowed. The header is useful to ensure that the request comes from a webhook set by you.
     */
    public static function build(
        string $url,
        ?InputFile $certificate = null,
        ?string $ip_address = null,
        ?int $max_connections = null,
        ?array $allowed_updates = null,
        ?bool $drop_pending_updates = null,
        ?string $secret_token = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->url = $url;
        $obj->certificate = $certificate;
        $obj->ip_address = $ip_address;
        $obj->max_connections = $max_connections;
        $obj->allowed_updates = $allowed_updates;
        $obj->drop_pending_updates = $drop_pending_updates;
        $obj->secret_token = $secret_token;

        return $obj;
    }
}

class DeleteWebhookParams extends CustomJsonSerialization
{
    /*
     * Pass True to drop all pending updates
     */
    public ?bool $drop_pending_updates;

    /**
     * @param ?bool $drop_pending_updates Pass True to drop all pending updates
     */
    public static function build(?bool $drop_pending_updates = null)
    {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->drop_pending_updates = $drop_pending_updates;

        return $obj;
    }
}

class SendMessageParams extends CustomJsonSerialization
{
    public $chat_id;
    public $text;
    public $business_connection_id;
    public $message_thread_id;
    public $parse_mode;
    public $entities;
    public $link_preview_options;
    public $disable_notifications;
    public $protect_content;
    public $allow_paid_broadcast;
    public $message_effect_id;
    public $reply_parameters;
    public $reply_markup;

    /**
     * @param string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param ?string $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param ?int $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param ?string $parse_mode Mode for parsing entities in the message text. See formatting options for more details.
     * @param ?array<MessageEntity> $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param ?LinkPreviewOptions $link_preview_options Link preview generation options for the message
     * @param ?bool $disable_notifications Sends the message silently. Users will receive a notification with no sound.
     * @param ?bool $protect_content Protects the contents of the sent message from forwarding and saving
     * @param ?bool $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param ?string $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param ?ReplyParameters $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     */
    public static function build(
        string|int $chat_id,
        string $text,
        ?string $business_connection_id = null,
        ?int $message_thread_id = null,
        ?string $parse_mode = null,
        ?array $entities = null,
        ?LinkPreviewOptions $link_preview_options = null,
        ?bool $disable_notifications = null,
        ?bool $protect_content = null,
        ?bool $allow_paid_broadcast = null,
        ?string $message_effect_id = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->chat_id = $chat_id;
        $obj->text = $text;
        $obj->business_connection_id = $business_connection_id;
        $obj->message_thread_id = $message_thread_id;
        $obj->parse_mode = $parse_mode;
        $obj->entities = $entities;
        $obj->link_preview_options = $link_preview_options;
        $obj->disable_notifications = $disable_notifications;
        $obj->protect_content = $protect_content;
        $obj->allow_paid_broadcast = $allow_paid_broadcast;
        $obj->message_effect_id = $message_effect_id;
        $obj->reply_parameters = $reply_parameters;
        $obj->reply_markup = $reply_markup;

        return $obj;
    }
}

class ForwardMessageParams extends CustomJsonSerialization
{
    public $chat_id;
    public $from_chat_id;
    public $message_id;
    public $message_thread_id;
    public $disable_notifications;
    public $protect_content;

    /**
     * @param string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|int $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param ?int $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param ?bool $disable_notifications Sends the message silently. Users will receive a notification with no sound.
     * @param ?bool $protect_content Protects the contents of the sent message from forwarding and saving
     */
    public static function build(
        string|int $chat_id,
        string|int $from_chat_id,
        int $message_id,
        ?int $message_thread_id = null,
        ?bool $disable_notifications = null,
        ?bool $protect_content = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->chat_id = $chat_id;
        $obj->from_chat_id = $from_chat_id;
        $obj->message_id = $message_id;
        $obj->message_thread_id = $message_thread_id;
        $obj->disable_notifications = $disable_notifications;
        $obj->protect_content = $protect_content;

        return $obj;
    }
}

class CopyMessageParams extends CustomJsonSerialization
{
    public $chat_id;
    public $from_chat_id;
    public $message_id;
    public $message_thread_id;
    public $caption;
    public $parse_mode;
    public $caption_entities;
    public $show_caption_above_media;
    public $disable_notifications;
    public $protect_content;
    public $allow_paid_broadcast;
    public $reply_parameters;
    public $reply_markup;

    /**
     * @param string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|int $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param ?int $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param ?string $caption New caption for media, 0-1024 characters after entities parsing. If not specified, the original caption is kept
     * @param ?string $parse_mode Mode for parsing entities in the new caption. See formatting options for more detail
     * @param ?array<MessageEntity> $caption_entities A JSON-serialized list of special entities that appear in the new caption, which can be specified instead of parse_mode
     * @param ?bool $show_caption_above_media Pass True, if the caption must be shown above the message media. Ignored if a new caption isn't specified.
     * @param ?bool $disable_notifications Sends the message silently. Users will receive a notification with no sound.
     * @param ?bool $protect_content Protects the contents of the sent message from forwarding and saving
     * @param ?bool $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param ?ReplyParameters $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     */
    public static function build(
        string|int $chat_id,
        string|int $from_chat_id,
        int $message_id,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ?string $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $show_caption_above_media = null,
        ?bool $disable_notifications = null,
        ?bool $protect_content = null,
        ?bool $allow_paid_broadcast = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->chat_id = $chat_id;
        $obj->from_chat_id = $from_chat_id;
        $obj->message_id = $message_id;
        $obj->message_thread_id = $message_thread_id;
        $obj->caption = $caption;
        $obj->parse_mode = $parse_mode;
        $obj->caption_entities = $caption_entities;
        $obj->show_caption_above_media = $show_caption_above_media;
        $obj->disable_notifications = $disable_notifications;
        $obj->protect_content = $protect_content;
        $obj->allow_paid_broadcast = $allow_paid_broadcast;
        $obj->reply_parameters = $reply_parameters;
        $obj->reply_markup = $reply_markup;

        return $obj;
    }
}

class SendPhotoParams extends CustomJsonSerialization
{
    public $chat_id;
    public $photo;
    public $business_connection_id;
    public $message_thread_id;
    public $caption;
    public $parse_mode;
    public $caption_entities;
    public $show_caption_above_media;
    public $has_spoiler;
    public $disable_notifications;
    public $protect_content;
    public $allow_paid_broadcast;
    public $message_effect_id;
    public $reply_parameters;
    public $reply_markup;

    /**
     * @param string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|InputFile $photo Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload a new photo using multipart/form-data. The photo must be at most 10 MB in size. The photo's width and height must not exceed 10000 in total. Width and height ratio must be at most 20. More information on Sending Files »
     * @param ?string $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param ?int $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param ?string $caption Photo caption (may also be used when resending photos by file_id), 0-1024 characters after entities parsing
     * @param ?string $parse_mode Mode for parsing entities in the photo caption. See formatting options for more details.
     * @param ?array<MessageEntity> $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param ?bool $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param ?bool $has_spoiler Pass True if the photo needs to be covered with a spoiler animation
     * @param ?bool $disable_notifications Sends the message silently. Users will receive a notification with no sound.
     * @param ?bool $protect_content Protects the contents of the sent message from forwarding and saving
     * @param ?bool $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param ?string $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param ?ReplyParameters $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     */
    public static function build(
        string|int $chat_id,
        string|InputFile $photo,
        ?string $business_connection_id = null,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ?string $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $show_caption_above_media = null,
        ?bool $has_spoiler = null,
        ?bool $disable_notifications = null,
        ?bool $protect_content = null,
        ?bool $allow_paid_broadcast = null,
        ?string $message_effect_id = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->chat_id = $chat_id;
        $obj->photo = $photo;
        $obj->business_connection_id = $business_connection_id;
        $obj->message_thread_id = $message_thread_id;
        $obj->caption = $caption;
        $obj->parse_mode = $parse_mode;
        $obj->caption_entities = $caption_entities;
        $obj->show_caption_above_media = $show_caption_above_media;
        $obj->has_spoiler = $has_spoiler;
        $obj->disable_notifications = $disable_notifications;
        $obj->protect_content = $protect_content;
        $obj->allow_paid_broadcast = $allow_paid_broadcast;
        $obj->message_effect_id = $message_effect_id;
        $obj->reply_parameters = $reply_parameters;
        $obj->reply_markup = $reply_markup;

        return $obj;
    }
}

class SendDocumentParams extends CustomJsonSerialization
{
    public $chat_id;
    public $document;
    public $business_connection_id;
    public $message_thread_id;
    public $thumbnail;
    public $caption;
    public $parse_mode;
    public $caption_entities;
    public $disable_content_type_detection;
    public $disable_notifications;
    public $protect_content;
    public $allow_paid_broadcast;
    public $message_effect_id;
    public $reply_parameters;
    public $reply_markup;

    /**
     * @param string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param string|InputFile $document File to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. More information on Sending Files »
     * @param ?string $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param ?int $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|InputFile|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. More information on Sending Files »
     * @param ?string $caption Document caption (may also be used when resending documents by file_id), 0-1024 characters after entities parsing
     * @param ?string $parse_mode Mode for parsing entities in the document caption. See formatting options for more details.
     * @param ?array<MessageEntity> $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param ?bool $disable_content_type_detection Disables automatic server-side content type detection for files uploaded using multipart/form-data
     * @param ?bool $disable_notifications Sends the message silently. Users will receive a notification with no sound.
     * @param ?bool $protect_content Protects the contents of the sent message from forwarding and saving
     * @param ?bool $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring broadcasting limits for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param ?string $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param ?ReplyParameters $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     */
    public static function build(
        string|int $chat_id,
        string|InputFile $document,
        ?string $business_connection_id = null,
        ?int $message_thread_id = null,
        string|InputFile|null $thumbnail = null,
        ?string $caption = null,
        ?string $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $disable_content_type_detection = null,
        ?bool $disable_notifications = null,
        ?bool $protect_content = null,
        ?bool $allow_paid_broadcast = null,
        ?string $message_effect_id = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->chat_id = $chat_id;
        $obj->document = $document;
        $obj->business_connection_id = $business_connection_id;
        $obj->message_thread_id = $message_thread_id;
        $obj->thumbnail = $thumbnail;
        $obj->caption = $caption;
        $obj->parse_mode = $parse_mode;
        $obj->caption_entities = $caption_entities;
        $obj->disable_content_type_detection = $disable_content_type_detection;
        $obj->disable_notifications = $disable_notifications;
        $obj->protect_content = $protect_content;
        $obj->allow_paid_broadcast = $allow_paid_broadcast;
        $obj->message_effect_id = $message_effect_id;
        $obj->reply_parameters = $reply_parameters;
        $obj->reply_markup = $reply_markup;

        return $obj;
    }
}

class EditMessageTextParams extends CustomJsonSerialization
{
    public $text;
    public $business_connection_id;
    public $chat_id;
    public $message_id;
    public $inline_message_id;
    public $parse_mode;
    public $entities;
    public $link_preview_options;
    public $reply_markup;

    /**
     * @param string $text New text of the message, 1-4096 characters after entities parsing
     * @param ?string $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|int|null $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @param ?int $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param ?int $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param ?string $parse_mode Mode for parsing entities in the photo caption. See formatting options for more details.
     * @param ?array<MessageEntity> $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param ?LinkPreviewOptions $link_preview_options Link preview generation options for the message
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup A JSON-serialized object for an inline keyboard.
     */
    public static function build(
        string $text,
        ?string $business_connection_id = null,
        string|int|null $chat_id = null,
        ?int $message_id = null,
        ?int $inline_message_id = null,
        ?string $parse_mode = null,
        ?array $entities = null,
        ?LinkPreviewOptions $link_preview_options = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->text = $text;
        $obj->business_connection_id = $business_connection_id;
        $obj->chat_id = $chat_id;
        $obj->message_id = $message_id;
        $obj->inline_message_id = $inline_message_id;
        $obj->parse_mode = $parse_mode;
        $obj->entities = $entities;
        $obj->link_preview_options = $link_preview_options;
        $obj->reply_markup = $reply_markup;

        return $obj;
    }
}

class AnswerCallbackQueryParams extends CustomJsonSerialization
{
    public $callback_query_id;
    public $text;
    public $show_alert;
    public $url;
    public $cache_time;

    /**
     * @param string $callback_query_id Unique identifier for the query to be answered
     * @param ?string $text Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters
     * @param ?bool $show_alert If True, an alert will be shown by the client instead of a notification at the top of the chat screen. Defaults to false.
     * @param ?string $url URL that will be opened by the user's client. If you have created a Game and accepted the conditions via @BotFather, specify the URL that opens your game - note that this will only work if the query comes from a callback_game button. Otherwise, you may use links like t.me/your_bot?start=XXXX that open your bot with a parameter.
     * @param ?int $cache_time The maximum amount of time in seconds that the result of the callback query may be cached client-side. Telegram apps will support caching starting in version 3.14. Defaults to 0.
     */
    public static function build(
        string $callback_query_id,
        ?string $text = null,
        ?bool $show_alert = null,
        ?string $url = null,
        ?int $cache_time = null,
    ) {
        // @phpstan-ignore new.static
        $obj = new static();

        $obj->callback_query_id = $callback_query_id;
        $obj->text = $text;
        $obj->show_alert = $show_alert;
        $obj->url = $url;
        $obj->cache_time = $cache_time;

        return $obj;
    }
}
