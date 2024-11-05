<?php

namespace Litegram;

class GetUpdatesParams implements \JsonSerializable
{
    /**
     * Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates. By default, updates starting with the earliest unconfirmed update are returned. An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id. The negative offset can be specified to retrieve updates starting from -offset update from the end of the updates queue. All previous updates will be forgotten.
     */
    public ?int $offset = null;

    /**
     * Limits the number of updates to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     */
    public ?int $limit = null;

    /**
     * Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling. Should be positive, short polling should be used for testing purposes only.
     */
    public ?int $timeout = null;

    /**
     * A JSON-serialized list of the update types you want your bot to receive. For example, specify ["message", "edited_channel_post", "callback_query"] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member, message_reaction, and message_reaction_count (default). If not specified, the previous setting will be used.
     * Please note that this parameter doesn't affect updates created before the call to the getUpdates, so unwanted updates may be received for a short period of time.
     * @var array<string> $allowed_updates
     */
    public ?array $allowed_updates = null;

    /**
     * @param array<string> $allowed_updates
     */
    public function __construct(
        int $offset = null,
        int $limit = null,
        int $timeout = null,
        array $allowed_updates = null,
    ) {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->timeout = $timeout;
        $this->allowed_updates = $allowed_updates;
    }

    public function jsonSerialize(): mixed
    {
        $obj = (object) [];

        foreach (get_object_vars($this) as $key => $value) {
            if (!is_null($value)) {
                $obj->$key = $value;
            }
        }

        return $obj;
    }
}

class SendMessageParams implements \JsonSerializable
{
    /**
     * Unique identifier of the business connection on behalf of which the message will be sent
     */
    public ?string $business_connection_id = null;

    /**
     * Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     */
    public string|int $chat_id;

    /**
     * Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     */
    public ?int $message_thread_id = null;

    /**
     * Text of the message to be sent, 1-4096 characters after entities parsing
     */
    public string $text;

    /**
     * Mode for parsing entities in the message text. See formatting options for more details.
     */
    public ?string $parse_mode = null;

    /**
     * A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @var array<MessageEntity>
     */
    public ?array $entities = null;

    /**
     * Link preview generation options for the message
     */
    public ?LinkPreviewOptions $link_preview_options = null;

    /**
     * Sends the message silently. Users will receive a notification with no sound.
     */
    public ?bool $disable_notifications = null;

    /**
     * Protects the contents of the sent message from forwarding and saving
     */
    public ?bool $protect_content = null;

    /**
     * Unique identifier of the message effect to be added to the message; for private chats only
     */
    public ?string $message_effect_id = null;

    /**
     * Description of the message to reply to
     */
    public ?ReplyParameters $reply_parameters = null;

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     */
    public InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null;

    /**
     * @param array<MessageEntity> $entities
     */
    public function __construct(
        string|int $chat_id,
        string $text,

        string $business_connection_id = null,
        int $message_thread_id = null,
        string $parse_mode = null,
        array $entities = null,
        LinkPreviewOptions $link_preview_options = null,
        bool $disable_notifications = null,
        bool $protect_content = null,
        string $message_effect_id = null,
        ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ) {
        $this->chat_id = $chat_id;
        $this->text = $text;

        $this->business_connection_id = $business_connection_id;
        $this->message_thread_id = $message_thread_id;
        $this->parse_mode = $parse_mode;
        $this->entities = $entities;
        $this->link_preview_options = $link_preview_options;
        $this->disable_notifications = $disable_notifications;
        $this->protect_content = $protect_content;
        $this->message_effect_id = $message_effect_id;
        $this->reply_parameters = $reply_parameters;
        $this->reply_markup = $reply_markup;
    }

    public function jsonSerialize(): mixed
    {
        $obj = (object) [];

        foreach (get_object_vars($this) as $key => $value) {
            if (!is_null($value)) {
                $obj->$key = $value;
            }
        }

        return $obj;
    }
}

class CopyMessageParams implements \JsonSerializable
{
    /**
     * Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     */
    public string|int $chat_id;

    /**
     * Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     */
    public ?int $message_thread_id = null;

    /**
     * Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     */
    public string|int $from_chat_id;

    /**
     * Message identifier in the chat specified in from_chat_id
     */
    public int $message_id;

    /**
     * New caption for media, 0-1024 characters after entities parsing. If not specified, the original caption is kept
     */
    public ?string $caption = null;

    /**
     * Mode for parsing entities in the new caption. See formatting options for more details.
     */
    public ?string $parse_mode = null;

    /**
     * A JSON-serialized list of special entities that appear in the new caption, which can be specified instead of parse_mode
     * @var array<MessageEntity>
     */
    public ?array $caption_entities = null;

    /**
     * Pass True, if the caption must be shown above the message media. Ignored if a new caption isn't specified.
     */
    public ?bool $show_caption_above_media = null;

    /**
     * Sends the message silently. Users will receive a notification with no sound.
     */
    public ?bool $disable_notifications = null;

    /**
     * Protects the contents of the sent message from forwarding and saving
     */
    public ?bool $protect_content = null;

    /**
     * Description of the message to reply to
     */
    public ?ReplyParameters $reply_parameters = null;

    /**
     * Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user
     */
    public InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null;

    /**
     * @param array<MessageEntity> $caption_entities
     */
    public function __construct(
        string|int $chat_id,
        string|int $from_chat_id,
        int $message_id,

        int $message_thread_id = null,
        string $caption = null,
        string $parse_mode = null,
        array $caption_entities = null,
        bool $show_caption_above_media = null,
        bool $disable_notifications = null,
        bool $protect_content = null,
        ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ) {
        $this->chat_id = $chat_id;
        $this->from_chat_id = $from_chat_id;
        $this->message_id = $message_id;

        $this->message_thread_id = $message_thread_id;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->show_caption_above_media = $show_caption_above_media;
        $this->disable_notifications = $disable_notifications;
        $this->protect_content = $protect_content;
        $this->reply_parameters = $reply_parameters;
        $this->reply_markup = $reply_markup;
    }

    public function jsonSerialize(): mixed
    {
        $obj = (object) [];

        foreach (get_object_vars($this) as $key => $value) {
            if (!is_null($value)) {
                $obj->$key = $value;
            }
        }

        return $obj;
    }
}
