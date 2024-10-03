<?php

class GetUpdatesParams implements JsonSerializable
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

class SendMessageParams implements JsonSerializable
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

class CopyMessageParams implements JsonSerializable
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

/**
 * Describes reply parameters for the message that is being sent.
 */
class ReplyParameters implements JsonSerializable
{
    /**
     * Identifier of the message that will be replied to in the current chat, or in the chat chat_id if it is specified
     */
    public int $message_id;

    /**
     * Optional. If the message to be replied to is from a different chat, unique identifier for the chat or username of the channel (in the format @channelusername). Not supported for messages sent on behalf of a business account.
     */
    public string|int|null $chat_id = null;

    /**
     * Optional. Pass True if the message should be sent even if the specified message to be replied to is not found. Always False for replies in another chat or forum topic. Always True for messages sent on behalf of a business account.
     */
    public ?bool $allow_sending_without_reply = null;

    /**
     * Optional. Quoted part of the message to be replied to; 0-1024 characters after entities parsing. The quote must be an exact substring of the message to be replied to, including bold, italic, underline, strikethrough, spoiler, and custom_emoji entities. The message will fail to send if the quote isn't found in the original message.
     */
    public ?string $quote = null;

    /**
     * Optional. Mode for parsing entities in the quote. See formatting options for more details.
     */
    public ?string $quote_parse_mode = null;

    /**
     * Optional. A JSON-serialized list of special entities that appear in the quote. It can be specified instead of quote_parse_mode.
     * @var array<MessageEntity>
     */
    public ?array $quote_entities = null;

    /**
     * Optional. Position of the quote in the original message in UTF-16 code units
     */
    public ?int $quote_position = null;

    /**
     * @param array<MessageEntity> $quote_entities
     */
    public function __construct(
        int $message_id,

        string|int $chat_id = null,
        bool $allow_sending_without_reply = null,
        string $quote = null,
        string $quote_parse_mode = null,
        array $quote_entities = null,
        int $quote_position = null,
    ) {
        $this->message_id = $message_id;

        $this->chat_id = $chat_id;
        $this->allow_sending_without_reply = $allow_sending_without_reply;
        $this->quote = $quote;
        $this->quote_parse_mode = $quote_parse_mode;
        $this->quote_entities = $quote_entities;
        $this->quote_position = $quote_position;
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

/**
 * Upon receiving a message with this object, Telegram clients will remove the current custom keyboard and display the default letter-keyboard. By default, custom keyboards are displayed until a new keyboard is sent by a bot. An exception is made for one-time keyboards that are hidden immediately after the user presses a button (see ReplyKeyboardMarkup). Not supported in channels and for messages sent on behalf of a Telegram Business account.
 */
class ReplyKeyboardRemove implements JsonSerializable
{
    /**
     * Requests clients to remove the custom keyboard (user will not be able to summon this keyboard; if you want to hide the keyboard from sight but keep it accessible, use one_time_keyboard in ReplyKeyboardMarkup)
     */
    public true $remove_keyboard;

    /**
     * Optional. Use this parameter if you want to remove the keyboard for specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     * Example: A user votes in a poll, bot returns confirmation message in reply to the vote and removes the keyboard for that user, while still showing the keyboard with poll options to users who haven't voted yet.
     */
    public ?bool $selective = null;

    public function __construct(true $remove_keyboard, bool $selective = null)
    {
        $this->remove_keyboard = $remove_keyboard;

        $this->selective = $selective;
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

/**
 * This object represents a custom keyboard with reply options (see Introduction to bots for details and examples). Not supported in channels and for messages sent on behalf of a Telegram Business account.
 */
class ReplyKeyboardMarkup implements JsonSerializable
{
    /**
     * Array of button rows, each represented by an Array of KeyboardButton objects
     * @var array<array<KeyboardButton>>
     */
    public array $keyboard;

    /**
     * Optional. Requests clients to always show the keyboard when the regular keyboard is hidden. Defaults to false, in which case the custom keyboard can be hidden and opened with a keyboard icon.
     */
    public ?bool $is_persistent = null;

    /**
     * Optional. Requests clients to resize the keyboard vertically for optimal fit (e.g., make the keyboard smaller if there are just two rows of buttons). Defaults to false, in which case the custom keyboard is always of the same height as the app's standard keyboard.
     */

    public ?bool $resize_keyboard = null;

    /**
     * Optional. Requests clients to hide the keyboard as soon as it's been used. The keyboard will still be available, but clients will automatically display the usual letter-keyboard in the chat - the user can press a special button in the input field to see the custom keyboard again. Defaults to false.
     */
    public ?bool $one_time_keyboard = null;

    /**
     * Optional. Requests clients to hide the keyboard as soon as it's been used. The keyboard will still be available, but clients will automatically display the usual letter-keyboard in the chat - the user can press a special button in the input field to see the custom keyboard again. Defaults to false.
     */
    public ?string $input_field_placeholder = null;

    /**
     * Optional. Use this parameter if you want to show the keyboard to specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply to a message in the same chat and forum topic, sender of the original message.
     * Example: A user requests to change the bot's language, bot replies to the request with a keyboard to select the new language. Other users in the group don't see the keyboard.
     */
    public ?bool $selective;

    /**
     * @param array<array<KeyboardButton>> $keyboard
     */
    public function __construct(
        array $keyboard,
        bool $is_persistent = null,
        bool $resize_keyboard = null,
        bool $one_time_keyboard = null,
        string $input_field_placeholder = null,
        bool $selective = null,
    ) {
        $this->keyboard = $keyboard;

        $this->is_persistent = $is_persistent;
        $this->resize_keyboard = $resize_keyboard;
        $this->one_time_keyboard = $one_time_keyboard;
        $this->input_field_placeholder = $input_field_placeholder;
        $this->selective = $selective;
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

/**
 * This object represents an inline keyboard that appears right next to the message it belongs to.
 */
class InlineKeyboardMarkup implements JsonSerializable
{
    /**
     * Array of button rows, each represented by an Array of InlineKeyboardButton objects
     * * @var array<array<InlineKeyboardButton>>
     */
    public ?array $inline_keyboard;

    /**
     * @param array<array<InlineKeyboardButton>> $inline_keyboard
     */
    public function __construct(array $inline_keyboard)
    {
        $this->inline_keyboard = $inline_keyboard;
    }

    public static function __fromDecodedJson($init_data)
    {
        // @phpstan-ignore new.static
        return new static($init_data->inline_keyboard);
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

/**
 * Upon receiving a message with this object, Telegram clients will display a reply interface to the user (act as if the user has selected the bot's message and tapped 'Reply'). This can be extremely useful if you want to create user-friendly step-by-step interfaces without having to sacrifice privacy mode. Not supported in channels and for messages sent on behalf of a Telegram Business account.
 */
class ForceReply implements JsonSerializable
{
    /**
     * Shows reply interface to the user, as if they manually selected the bot's message and tapped 'Reply'
     */
    public true $force_reply;

    /**
     * Optional. The placeholder to be shown in the input field when the reply is active; 1-64 characters
     */
    public string $input_field_placeholder;

    /**
     * Optional. Use this parameter if you want to force reply from specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     */
    public bool $selective;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }
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

/**
 * This object represents one button of the reply keyboard. At most one of the optional fields must be used to specify type of the button. For simple text buttons, String can be used instead of this object to specify the button text.
 */
class KeyboardButton implements JsonSerializable
{
    /**
     * Text of the button. If none of the optional fields are used, it will be sent as a message when the button is pressed
     */
    public string $text;

    /**
     * Optional. If specified, pressing the button will open a list of suitable users. Identifiers of selected users will be sent to the bot in a “users_shared” service message. Available in private chats only.
     */
    public ?KeyboardButtonRequestUsers $request_users = null;

    /**
     * Optional. If specified, pressing the button will open a list of suitable chats. Tapping on a chat will send its identifier to the bot in a “chat_shared” service message. Available in private chats only.
     */
    public ?KeyboardButtonRequestChat $request_chat = null;

    /**
     * Optional. If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only.
     */
    public ?bool $request_contact = null;

    /**
     * Optional. If True, the user's current location will be sent when the button is pressed. Available in private chats only.
     */
    public ?bool $request_location = null;

    /**
     * Optional. If specified, the user will be asked to create a poll and send it to the bot when the button is pressed. Available in private chats only.
     */
    public ?KeyboardButtonPollType $request_poll = null;

    /**
     * Optional. If specified, the described Web App will be launched when the button is pressed. The Web App will be able to send a “web_app_data” service message. Available in private chats only.
     */
    public ?WebAppInfo $web_app = null;

    public function __construct(
        string $text,
        KeyboardButtonRequestUsers $request_users = null,
        KeyboardButtonRequestChat $request_chat = null,
        bool $request_contact = null,
        bool $request_location = null,
        KeyboardButtonPollType $request_poll = null,
        WebAppInfo $web_app = null,
    ) {
        $this->text = $text;

        $this->request_users = $request_users;
        $this->request_chat = $request_chat;
        $this->request_contact = $request_contact;
        $this->request_location = $request_location;
        $this->request_poll = $request_poll;
        $this->web_app = $web_app;
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

/**
 * This object represents one button of an inline keyboard. Exactly one of the optional fields must be used to specify type of the button.
 */
class InlineKeyboardButton implements JsonSerializable
{
    /**
     * Label text on the button
     */
    public string $text;

    /**
     * Optional. HTTP or tg:// URL to be opened when the button is pressed. Links tg://user?id=<user_id> can be used to mention a user by their identifier without using a username, if this is allowed by their privacy settings.
     */
    public ?string $url = null;

    /**
     * Optional. Data to be sent in a callback query to the bot when the button is pressed, 1-64 bytes
     */
    public ?string $callback_data = null;

    // TODO ...

    public function __construct(
        string $text,
        string $url = null,
        string $callback_data = null,
    ) {
        $this->text = $text;
        $this->url = $url;
        $this->callback_data = $callback_data;
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

/**
 * This object defines the criteria used to request a suitable chat. Information about the selected chat will be shared with the bot when the corresponding button is pressed. The bot will be granted requested rights in the chat if appropriate. More about requesting chats ».
 */
class KeyboardButtonRequestChat implements JsonSerializable
{
    /**
     * Signed 32-bit identifier of the request, which will be received back in the ChatShared object. Must be unique within the message
     */
    public int $request_id;

    /**
     * Pass True to request a channel chat, pass False to request a group or a supergroup chat.
     */
    public ?bool $chat_is_channel = null;

    // TODO ...

    /**
     * Optional. Pass True to request a chat with the bot as a member. Otherwise, no additional restrictions are applied.
     */
    public ?bool $bot_is_member = null;

    /**
     * Optional. Pass True to request the chat's title
     */
    public ?bool $request_title = null;

    /**
     * Optional. Pass True to request the chat's username
     */
    public ?bool $request_username = null;

    /**
     * Optional. Pass True to request the chat's photo
     */
    public ?bool $request_photo = null;

    public function __construct(
        int $request_id,

        bool $chat_is_channel = null,
        bool $bot_is_member = null,
        bool $request_title = null,
        bool $request_username = null,
        bool $request_photo = null,
    ) {
        $this->request_id = $request_id;

        $this->chat_is_channel = $chat_is_channel;
        $this->bot_is_member = $bot_is_member;
        $this->request_title = $request_title;
        $this->request_username = $request_username;
        $this->request_photo = $request_photo;
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
