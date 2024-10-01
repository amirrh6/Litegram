<?php

// TODO: Use a namespace

// define("LITEGRAM_BOT_API_VERSION", "6.7");
// define("LITEGRAM_VERSION", "0.1.0");

/**
 * This object represents a Telegram user or bot.
 */
class User
{
    /**
     * Unique identifier for this user or bot. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public int $id;

    /**
     * True, if this user is a bot
     */
    public bool $is_bot;

    /**
     * User's or bot's first name
     */
    public string $first_name;

    /**
     * Optional. User's or bot's last name
     */
    public ?string $last_name = null;

    /**
     * Optional. User's or bot's username
     */
    public ?string $username = null;

    /**
     * Optional. IETF language tag of the user's language
     */
    public ?string $language_code = null;

    /**
     * Optional. True, if this user is a Telegram Premium user
     */
    public ?true $is_premium = null;

    /**
     * Optional. True, if this user added the bot to the attachment menu
     */
    public ?true $added_to_attachment_menu = null;

    /**
     * Optional. True, if the bot can be invited to groups. Returned only in getMe.
     */
    public ?bool $can_join_groups = null;

    /**
     * Optional. True, if privacy mode is disabled for the bot. Returned only in getMe.
     */
    public ?bool $can_read_all_group_messages = null;

    /**
     * Optional. True, if the bot supports inline queries. Returned only in getMe.
     */
    public ?bool $supports_inline_queries = null;

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

    public function get_full_name(): string
    {
        $full_name = $this->first_name;
        if ($this->last_name != null) {
            $full_name .= ' ' . $this->last_name;
        }
        return $full_name;
    }
}

/**
 * This object represents a chat.
 */
class Chat
{
    /**
     * Unique identifier for this chat. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public int $id;

    /**
     * Type of chat, can be either “private”, “group”, “supergroup” or “channel”
     */
    public string $type;

    /**
     * Optional. Title, for supergroups, channels and group chats
     */
    public ?string $title = null;

    /**
     * Optional. Username, for private chats, supergroups and channels if available
     */
    public ?string $username = null;

    /**
     * Optional. First name of the other party in a private chat
     */
    public ?string $first_name = null;

    /**
     * Optional. Last name of the other party in a private chat
     */
    public ?string $last_name = null;

    /**
     * Optional. True, if the supergroup chat is a forum (has topics enabled)
     */
    public ?true $is_forum = null;

    /**
     * Optional. Chat photo. Returned only in getChat.
     */
    public ?ChatPhoto $photo = null;

    /**
     * Optional. If non-empty, the list of all active chat usernames;
     *  for private chats, supergroups and channels. Returned only in getChat.
     * @var array<string>
     */
    public ?array $active_usernames = null;

    /**
     * Optional. Custom emoji identifier of emoji status of the other party in a private chat. Returned only in getChat.
     */
    public ?string $emoji_status_custom_emoji_id = null;

    /**
     * Optional. Bio of the other party in a private chat. Returned only in getChat.
     */
    public ?string $bio = null;

    /**
     * Optional. True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id> links only in chats with the user. Returned only in getChat.
     */
    public ?true $has_private_forwards = null;

    /**
     * Optional. True, if the privacy settings of the other party restrict sending voice and video note messages in the private chat. Returned only in getChat.
     */
    public ?true $has_restricted_voice_and_video_messages = null;

    /**
     * Optional. True, if users need to join the supergroup before they can send messages. Returned only in getChat.
     */
    public ?true $join_to_send_messages = null;

    /**
     * Optional. True, if all users directly joining the supergroup need to be approved by supergroup administrators. Returned only in getChat.
     */
    public ?true $join_by_request = null;

    /**
     * Optional. Description, for groups, supergroups and channel chats. Returned only in getChat.
     */
    public ?string $description = null;

    /**
     * Optional. Primary invite link, for groups, supergroups and channel chats. Returned only in getChat.
     */
    public ?string $invite_link = null;

    /**
     * Optional. The most recent pinned message (by sending date). Returned only in getChat.
     */
    public ?Message $pinned_message = null;

    /**
     * Optional. Default chat member permissions, for groups and supergroups. Returned only in getChat.
     */
    public ?ChatPermissions $permissions = null;

    /**
     * Optional. For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged user;
     *  in seconds. Returned only in getChat.
     */
    public ?int $slow_mode_delay = null;

    /**
     * Optional. The time after which all messages sent to the chat will be automatically deleted;
     *  in seconds. Returned only in getChat.
     */
    public ?int $message_auto_delete_time = null;

    /**
     * Optional. True, if aggressive anti-spam checks are enabled in the supergroup. The field is only available to chat administrators. Returned only in getChat.
     */
    public ?true $has_aggressive_anti_spam_enabled = null;

    /**
     * Optional. True, if non-administrators can only get the list of bots and administrators in the chat. Returned only in getChat.
     */
    public ?true $has_hidden_members = null;

    /**
     * Optional. True, if messages from the chat can't be forwarded to other chats. Returned only in getChat.
     */
    public ?true $has_protected_content = null;

    /**
     * Optional. For supergroups, name of group sticker set. Returned only in getChat.
     */
    public ?string $sticker_set_name = null;

    /**
     * Optional. True, if the bot can change the group sticker set. Returned only in getChat.
     */
    public ?true $can_set_sticker_set = null;

    /**
     * Optional. Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice versa;
     *  for supergroups and channel chats. This identifier may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier. Returned only in getChat.
     */
    public ?int $linked_chat_id = null;

    /**
     * Optional. For supergroups, the location to which the supergroup is connected. Returned only in getChat.
     */
    public ?ChatLocation $location = null;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }

        if (property_exists($init_data, 'photo')) {
            $this->photo = new ChatPhoto($init_data->photo);
        }

        if (property_exists($init_data, 'pinned_message')) {
            $this->pinned_message = new Message($init_data->pinned_message);
        }

        if (property_exists($init_data, 'permissions')) {
            $this->permissions = new ChatPermissions($init_data->permissions);
        }

        if (property_exists($init_data, 'location')) {
            $this->location = new ChatLocation($init_data->location);
        }
    }
}

/**
 * This object represents an answer of a user in a non-anonymous poll.
 */
class PollAnswer
{
    /**
     * Unique poll identifier
     */
    public string $poll_id;

    /**
     * The user, who changed the answer to the poll
     */
    public User $user;

    /**
     * 0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.
     * @var array<int>
     */
    public array $option_ids;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }

        if (property_exists($init_data, 'user')) {
            $this->user = new User($init_data->user);
        }
    }
}

/**
 * This object contains information about a poll.
 */
class Poll
{
    /**
     * Unique poll identifier
     */
    public string $id;

    /**
     * Poll question, 1-300 characters
     */
    public string $question;

    /**
     * List of poll options
     * @var array<PollOption>
     */
    public ?array $options;

    /**
     * Total number of users that voted in the poll
     */
    public int $total_voter_count;

    /**
     * True, if the poll is closed
     */
    public bool $is_closed;

    /**
     * True, if the poll is anonymous
     */
    public bool $is_anonymous;

    /**
     * Poll type, currently can be “regular” or “quiz”
     */
    public string $type;

    /**
     * True, if the poll allows multiple answers
     */
    public bool $allows_multiple_answers;

    /**
     * Optional. 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.
     */
    public ?int $correct_option_id = null;

    /**
     * Optional. Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters
     */
    public ?string $explanation = null;

    /**
     * Optional. Special entities like usernames, URLs, bot commands, etc. that appear in the explanation
     * @var array<MessageEntity>
     */
    public ?array $explanation_entities = null;

    /**
     * Optional. Amount of time in seconds the poll will be active after creation
     */
    public ?int $open_period = null;

    /**
     * Optional. Point in time (Unix timestamp) when the poll will be automatically closed
     */
    public ?int $close_date = null;

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
}

/**
 * Upon receiving a message with this object, Telegram clients will remove the current custom keyboard and display the default letter-keyboard. By default, custom keyboards are displayed until a new keyboard is sent by a bot. An exception is made for one-time keyboards that are hidden immediately after the user presses a button (see ReplyKeyboardMarkup).
 */
class ReplyKeyboardRemove
{
    /**
     * Requests clients to remove the custom keyboard (user will not be able to summon this keyboard; if you want to hide the keyboard from sight but keep it accessible, use one_time_keyboard in ReplyKeyboardMarkup)
     */
    public true $remove_keyboard;

    /**
     * Optional. Use this parameter if you want to remove the keyboard for specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     * Example: A user votes in a poll, bot returns confirmation message in reply to the vote and removes the keyboard for that user, while still showing the keyboard with poll options to users who haven't voted yet.
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
}

/**
 * This object represents an inline keyboard that appears right next to the message it belongs to.
 */
class InlineKeyboardMarkup
{
    /**
     * // TODO: Avoid 'mixed' type
     * Array of button rows, each represented by an Array of InlineKeyboardButton objects
     */
    public mixed $inline_keyboard;

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
}

/**
 * Upon receiving a message with this object, Telegram clients will display a reply interface to the user (act as if the user has selected the bot's message and tapped 'Reply'). This can be extremely useful if you want to create user-friendly step-by-step interfaces without having to sacrifice privacy mode
 */
class ForceReply
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
}

/**
 * This object represents changes in the status of a chat member.
 */
class ChatMemberUpdated
{
    /**
     * Chat the user belongs to
     */
    public Chat $chat;

    /**
     * Performer of the action, which resulted in the change
     */
    public User $from;

    /**
     * Date the change was done in Unix time
     */
    public int $date;

    /**
     * Previous information about the chat member
     */
    public ChatMember $old_chat_member;

    /**
     * New information about the chat member
     */
    public ChatMember $new_chat_member;

    /**
     * Optional. Chat invite link, which was used by the user to join the chat for joining by invite link events only.
     */
    public ?ChatInviteLink $invite_link = null;

    /**
     * Optional. True, if the user joined the chat via a chat folder invite link
     */
    public ?bool $via_chat_folder_invite_link = null;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }

        if (property_exists($init_data, 'chat')) {
            $this->chat = new Chat($init_data->chat);
        }

        if (property_exists($init_data, 'from')) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, 'old_chat_member')) {
            $this->old_chat_member = new ChatMember(
                $init_data->old_chat_member,
            );
        }

        if (property_exists($init_data, 'new_chat_member')) {
            $this->new_chat_member = new ChatMember(
                $init_data->new_chat_member,
            );
        }

        if (property_exists($init_data, 'invite_link')) {
            $this->invite_link = new ChatInviteLink($init_data->invite_link);
        }
    }
}

/**
 * Represents a join request sent to a chat.
 */
class ChatJoinRequest
{
    /**
     * Chat to which the request was sent
     */
    public Chat $chat;

    /**
     * User that sent the join request
     */
    public User $from;

    /**
     * Identifier of a private chat with the user who sent the join request. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. The bot can use this identifier for 24 hours to send messages until the join request is processed, assuming no other administrator contacted the user.
     */
    public int $user_chat_id;

    /**
     * Date the request was sent in Unix time
     */
    public int $date;

    /**
     * Optional. Bio of the user.
     */
    public ?string $bio = null;

    /**
     * Optional. Chat invite link that was used by the user to send the join request
     */
    public ?ChatInviteLink $invite_link = null;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }

        if (property_exists($init_data, 'chat')) {
            $this->chat = new Chat($init_data->chat);
        }

        if (property_exists($init_data, 'from')) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, 'invite_link')) {
            $this->invite_link = new ChatInviteLink($init_data->invite_link);
        }
    }
}

class InputFile
{
    public string $_path;

    public function __construct($path)
    {
        $this->_path = $path;
    }
}

/**
 * This object represents an incoming inline query. When the user sends an empty query, your bot could return some default or trending results.
 */
class InlineQuery
{
    /**
     * Unique identifier for this query
     */
    public string $id;

    /**
     * Sender
     */
    public User $from;

    /**
     * Text of the query (up to 256 characters)
     */
    public string $query;

    /**
     * Offset of the results to be returned, can be controlled by the bot
     */
    public string $offset;

    /**
     * Optional. Type of the chat from which the inline query was sent. Can be either “sender” for a private chat with the inline query sender, “private”, “group”, “supergroup”, or “channel”. The chat type should be always known for requests sent from official clients and most third-party clients, unless the request was sent from a secret chat
     */
    public ?string $chat_type;

    /**
     * Optional. Sender location, only for bots that request user location
     */
    public ?Location $location;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }

        if (property_exists($init_data, 'from')) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, 'location')) {
            $this->location = new Location($init_data->location);
        }
    }
}

/**
 * This object represents a button to be shown above inline query results. You must use exactly one of the optional fields.
 */
class InlineQueryResultsButton
{
    /**
     * Label text on the button
     */
    public string $text;

    /**
     * Optional. Description of the Web App that will be launched when the user presses the button. The Web App will be able to switch back to the inline mode using the method switchInlineQuery inside the Web App.
     */
    public ?WebAppInfo $web_app = null;

    /**
     * Optional. Deep-linking parameter for the /start message sent to the bot when a user presses the button. 1-64 characters, only A-Z, a-z, 0-9, _ and - are allowed.
     * Example: An inline bot that sends YouTube videos can ask the user to connect the bot to their YouTube account to adapt search results accordingly. To do this, it displays a 'Connect your YouTube account' button above the results, or even before showing any. The user presses the button, switches to a private chat with the bot and, in doing so, passes a start parameter that instructs the bot to return an OAuth link. Once done, the bot can offer a switch_inline button so that the user can easily return to the chat where they wanted to use the bot's inline capabilities.
     */
    public ?string $start_parameter = null;

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
}

/**
 * Represents a result of an inline query that was chosen by the user and sent to their chat partner.
 */
class ChosenInlineResult
{
    /**
     * The unique identifier for the result that was chosen
     */
    public string $result_id;

    /**
     * The user that chose the result
     */
    public User $from;

    /**
     * Optional. Sender location, only for bots that require user location
     */
    public ?Location $location = null;

    /**
     * Optional. Identifier of the sent inline message. Available only if there is an inline keyboard attached to the message. Will be also received in callback queries and can be used to edit the message.
     */
    public ?string $inline_message_id = null;

    /**
     * The query that was used to obtain the result
     */
    public string $query;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }

        if (property_exists($init_data, 'from')) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, 'location')) {
            $this->location = new Location($init_data->location);
        }
    }
}

/**
 * This object contains information about an incoming shipping query.
 */
class ShippingQuery
{
    /**
     * Unique query identifier
     */
    public string $id;

    /**
     * User who sent the query
     */
    public User $from;

    /**
     * Bot specified invoice payload
     */
    public string $invoice_payload;

    /**
     * User specified shipping address
     */
    public ShippingAddress $shipping_address;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }

        if (property_exists($init_data, 'from')) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, 'shipping_address')) {
            $this->shipping_address = new ShippingAddress(
                $init_data->shipping_address,
            );
        }
    }
}

/**
 * This object contains information about an incoming pre-checkout query.
 */
class PreCheckoutQuery
{
    /**
     * Unique query identifier
     */
    public string $id;

    /**
     * User who sent the query
     */
    public User $from;

    /**
     * Three-letter ISO 4217 currency code
     */
    public string $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     */
    public int $total_amount;

    /**
     * Bot specified invoice payload
     */
    public string $invoice_payload;

    /**
     * Optional. Identifier of the shipping option chosen by the user
     */
    public ?string $shipping_option_id = null;

    /**
     * Optional. Order information provided by the user
     */
    public ?OrderInfo $order_info = null;

    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if ($value instanceof stdClass) {
            } else {
                $this->$key = $init_data->$key;
            }
        }

        if (property_exists($init_data, 'from')) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, 'order_info')) {
            $this->order_info = new OrderInfo($init_data->order_info);
        }
    }
}
