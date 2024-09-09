<?php

// TODO: Use a namespace

// define("LITEGRAM_BOT_API_VERSION", "6.7");
// define("LITEGRAM_VERSION", "0.1.0");

function remove_invalid_tags(string $txt)
{
    return strip_tags($txt, [
        "b",
        "strong",
        "i",
        "em",
        "u",
        "ins",
        "s",
        "strike",
        "del",
        "span",
        "tg-spoiler",
        "a",
        "tg-emoji",
        "code",
        "pre",
    ]);
}

/**
 * Describes the current status of a webhook
 */
class WebhookInfo
{
    // ...

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
    public ?bool $is_premium = null;
    /**
     * Optional. True, if this user added the bot to the attachment menu
     */
    public ?bool $added_to_attachment_menu = null;
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
            $full_name .= " " . $this->last_name;
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
    public ?bool $is_forum = null;
    /**
     * Optional. Chat photo. Returned only in getChat.
     */
    public ?ChatPhoto $photo = null;
    /**
     * Optional. If non-empty, the list of all active chat usernames; for private chats, supergroups and channels. Returned only in getChat.
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
    public ?bool $has_private_forwards = null;
    /**
     * Optional. True, if the privacy settings of the other party restrict sending voice and video note messages in the private chat. Returned only in getChat.
     */
    public ?bool $has_restricted_voice_and_video_messages = null;
    /**
     * Optional. True, if users need to join the supergroup before they can send messages. Returned only in getChat.
     */
    public ?bool $join_to_send_messages = null;
    /**
     * Optional. True, if all users directly joining the supergroup need to be approved by supergroup administrators. Returned only in getChat.
     */
    public ?bool $join_by_request = null;
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
     * Optional. For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged user; in seconds. Returned only in getChat.
     */
    public ?int $slow_mode_delay = null;
    /**
     * Optional. The time after which all messages sent to the chat will be automatically deleted; in seconds. Returned only in getChat.
     */
    public ?int $message_auto_delete_time = null;
    /**
     * Optional. True, if aggressive anti-spam checks are enabled in the supergroup. The field is only available to chat administrators. Returned only in getChat.
     */
    public ?bool $has_aggressive_anti_spam_enabled = null;
    /**
     * Optional. True, if non-administrators can only get the list of bots and administrators in the chat. Returned only in getChat.
     */
    public ?bool $has_hidden_members = null;
    /**
     * Optional. True, if messages from the chat can't be forwarded to other chats. Returned only in getChat.
     */
    public ?bool $has_protected_content = null;
    /**
     * Optional. For supergroups, name of group sticker set. Returned only in getChat.
     */
    public ?string $sticker_set_name = null;
    /**
     * Optional. True, if the bot can change the group sticker set. Returned only in getChat.
     */
    public ?bool $can_set_sticker_set = null;
    /**
     * Optional. Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice versa; for supergroups and channel chats. This identifier may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier. Returned only in getChat.
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

        if (property_exists($init_data, "photo")) {
            $this->photo = new ChatPhoto($init_data->photo);
        }

        if (property_exists($init_data, "pinned_message")) {
            $this->pinned_message = new Message($init_data->pinned_message);
        }

        if (property_exists($init_data, "permissions")) {
            $this->permissions = new ChatPermissions($init_data->permissions);
        }

        if (property_exists($init_data, "location")) {
            $this->location = new ChatLocation($init_data->location);
        }
    }
}


/**
 */
class MessageId
{
    // ...

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
 */
class MessageEntity
{
    // ...

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
 */
class PhotoSize
{
    // ...

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
 */
class Animation
{
    // ...

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
 */
class Audio
{
    // ...

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
 */
class Document
{
    // ...

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
 */
class Video
{
    // ...

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
 */
class VideoNote
{
    // ...

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
 */
class Voice
{
    // ...

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
 */
class Contact
{
    // ...

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
 */
class Dice
{
    // ...

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
 */
class PollOption
{
    // ...

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

        if (property_exists($init_data, "user")) {
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
 */
class Location
{
    // ...

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
 */
class Venue
{
    // ...

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
 */
class WebAppData
{
    // ...

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
 */
class ProximityAlertTriggered
{
    // ...

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
 */
class MessageAutoDeleteTimerChanged
{
    // ...

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
 */
class ForumTopicCreated
{
    // ...

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
 */
class ForumTopicClosed
{
    // ...

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
 */
class ForumTopicEdited
{
    // ...

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
 */
class ForumTopicReopened
{
    // ...

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
 */
class GeneralForumTopicHidden
{
    // ...

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
 */
class GeneralForumTopicUnhidden
{
    // ...

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
 */
class UserShared
{
    // ...

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
 */
class WriteAccessAllowed
{
    // ...

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
 */
class VideoChatScheduled
{
    // ...

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
 */
class VideoChatStarted
{
    // ...

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
 */
class VideoChatEnded
{
    // ...

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
 */
class VideoChatParticipantsInvited
{
    // ...

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
 */
class UserProfilePhotos
{
    // ...

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
 */
class File
{
    // ...

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
 * Describes a Web App.
 */
class WebAppInfo
{
    /**
     * An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps
     */
    public string $url;

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
 */
class ReplyKeyboardMarkup
{
    // ...

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
 */
class KeyboardButton
{
    // ...

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
 */
class KeyboardButtonRequestUser
{
    // ...

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
 */
class KeyboardButtonRequestChat
{
    // ...

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
 */
class KeyboardButtonPollType
{
    // ...

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
    public mixed $remove_keyboard;
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
 */
class InlineKeyboardButton
{
    // ...

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
 */
class LoginUrl
{
    // ...

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
 */
class SwitchInlineQueryChosenChat
{
    // ...

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
    public bool $force_reply;
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
 */
class ChatPhoto
{
    // ...

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
 */
class ChatInviteLink
{
    // ...

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
 */
class ChatAdministratorRights
{
    // ...

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
 */
class ChatMember
{
    public string $status;
    // ...

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
 */
class ChatMemberOwner
{
    // ...

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
 */
class ChatMemberAdministrator
{
    // ...

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
 */
class ChatMemberMember
{
    // ...

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
 */
class ChatMemberRestricted
{
    // ...

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
 */
class ChatMemberLeft
{
    // ...

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
 */
class ChatMemberBanned
{
    // ...

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
     * Optional. Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
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

        if (property_exists($init_data, "chat")) {
            $this->chat = new Chat($init_data->chat);
        }

        if (property_exists($init_data, "from")) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, "old_chat_member")) {
            $this->old_chat_member = new ChatMember(
                $init_data->old_chat_member
            );
        }

        if (property_exists($init_data, "new_chat_member")) {
            $this->new_chat_member = new ChatMember(
                $init_data->new_chat_member
            );
        }

        if (property_exists($init_data, "invite_link")) {
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

        if (property_exists($init_data, "chat")) {
            $this->chat = new Chat($init_data->chat);
        }

        if (property_exists($init_data, "from")) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, "invite_link")) {
            $this->invite_link = new ChatInviteLink($init_data->invite_link);
        }
    }
}

/**
 */
class ChatPermissions
{
    // ...

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
 */
class ChatLocation
{
    // ...

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
 */
class ForumTopic
{
    // ...

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
 * This object represents a bot command.
 */
class BotCommand
{
    /**
     * Text of the command; 1-32 characters. Can contain only lowercase English letters, digits and underscores.
     */
    public string $command;
    /**
     * Description of the command; 1-256 characters.
     */
    public string $description;

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
 */
class BotCommandScope
{
    // ...

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
 * Represents the default scope of bot commands. Default commands are used if no commands with a narrower scope are specified for the user.
 */
class BotCommandScopeDefault extends BotCommandScope
{
    /**
     * Scope type, must be default
     */
    public string $type = "default";
}

/**
 * Represents the scope of bot commands, covering all private chats.
 */
class BotCommandScopeAllPrivateChats extends BotCommandScope
{
    /**
     * Scope type, must be all_private_chats
     */
    public string $type = "all_private_chats";
}

/**
 * Represents the scope of bot commands, covering all group and supergroup chats.
 */
class BotCommandScopeAllGroupChats extends BotCommandScope
{
    /**
     * Scope type, must be all_group_chats
     */
    public string $type = "all_group_chats";
}

/**
 * Represents the scope of bot commands, covering all group and supergroup chat administrators.
 */
class BotCommandScopeAllChatAdministrators extends BotCommandScope
{
    /**
     * Scope type, must be all_chat_administrators
     */
    public string $type = "all_chat_administrators";
}

/**
 * Represents the scope of bot commands, covering a specific chat.
 */
class BotCommandScopeChat extends BotCommandScope
{
    /**
     * Scope type, must be chat
     */
    public string $type = "chat";
    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     */
    public string|int $chat_id;
}

/**
 * Represents the scope of bot commands, covering all administrators of a specific group or supergroup chat.
 */
class BotCommandScopeChatAdministrators extends BotCommandScope
{
    /**
     * Scope type, must be chat_administrators
     */
    public string $type = "chat_administrators";
    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     */
    public string|int $chat_id;
}

/**
 * Represents the scope of bot commands, covering a specific member of a group or supergroup chat.
 */
class BotCommandScopeChatMember extends BotCommandScope
{
    /**
     * Scope type, must be chat_member
     */
    public string $type = "chat_member";
    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     */
    public string|int $chat_id;
    /**
     * Unique identifier of the target user
     */
    public int $user_id;
}

/**
 * This object represents the bot's name.
 */
class BotName
{
    /**
     * The bot's name
     */
    public string $name;

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
 * This object represents the bot's description.
 */
class BotDescription
{
    /**
     * The bot's description
     */
    public string $description;

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
 */
class BotShortDescription
{
    // ...

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
 */
class MenuButton
{
    // ...

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
 */
class MenuButtonCommands
{
    // ...

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
 */
class MenuButtonWebApp
{
    // ...

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
 */
class MenuButtonDefault
{
    // ...

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
 */
class ResponseParameters
{
    // ...

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
 */
class InputMedia
{
    // ...

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
 */
class InputMediaPhoto
{
    // ...

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
 */
class InputMediaVideo
{
    // ...

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
 */
class InputMediaAnimation
{
    // ...

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
 */
class InputMediaAudio
{
    // ...

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
 */
class InputMediaDocument
{
    // ...

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

class InputFile
{
    public string $_path;

    public function __construct($path)
    {
        $this->_path = $path;
    }
}

/**
 */
class Sticker
{
    // ...

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
 */
class StickerSet
{
    // ...

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
 */
class MaskPosition
{
    // ...

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
 */
class InputSticker
{
    // ...

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

        if (property_exists($init_data, "from")) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, "location")) {
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
 */
class InlineQueryResult
{
    // ...

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

// ...

/**
 */
class InputMessageContent
{
    // ...

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

// ...

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

        if (property_exists($init_data, "from")) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, "location")) {
            $this->location = new Location($init_data->location);
        }
    }
}

/**
 */
class SentWebAppMessage
{
    // ...

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
 */
class LabeledPrice
{
    // ...

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
 */
class Invoice
{
    // ...

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
 */
class ShippingAddress
{
    // ...

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
 */
class OrderInfo
{
    // ...

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
 */
class ShippingOption
{
    // ...

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
 */
class SuccessfulPayment
{
    // ...

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

        if (property_exists($init_data, "from")) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, "shipping_address")) {
            $this->shipping_address = new ShippingAddress(
                $init_data->shipping_address
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

        if (property_exists($init_data, "from")) {
            $this->from = new User($init_data->from);
        }

        if (property_exists($init_data, "order_info")) {
            $this->order_info = new OrderInfo($init_data->order_info);
        }
    }
}

/**
 */
class PassportData
{
    // ...

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
 */
class PassportFile
{
    // ...

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
 */
class EncryptedPassportElement
{
    // ...

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
 */
class EncryptedCredentials
{
    // ...

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
 */
class PassportElementError
{
    // ...

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

// ...

/**
 */
class PassportElementErrorUnspecified
{
    // ...

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
 */
class Game
{
    // ...

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
 */
class CallbackGame
{
    // ...

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
 */
class GameHighScore
{
    // ...

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

// ---- ---- ---- ---- ---- ---- ---- ----

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
        $content_type = "application/json"
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
            "ok" => $ok,
            "description" => $description,
            "error_code" => $error_code,
            "parameters" => $parameters,
            "result" => $result,
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
        throw new Error("NOT IMPLEMENTED YET");
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
        string $secret_token = null
    ): bool {
        $params = [
            "url" => $url,
        ];

        if ($certificate != null) {
            $params["certificate"] = $certificate;
        }

        if ($ip_address != null) {
            $params["ip_address"] = $ip_address;
        }

        if ($max_connections != null) {
            $params["max_connections"] = $max_connections;
        }

        if ($allowed_updates != null) {
            $params["allowed_updates"] = $allowed_updates;
        }

        if ($drop_pending_updates != null) {
            $params["drop_pending_updates"] = $drop_pending_updates;
        }

        if ($secret_token != null) {
            $params["secret_token"] = $secret_token;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/setWebhook";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return boolval($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_webhook(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * Use this method to get current webhook status. Requires no parameters. On success, returns a WebhookInfo object. If the bot is using getUpdates, will return an object with the url field empty.
     */
    function get_webhook_info(): WebhookInfo
    {
        $params = [];

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/getWebhookInfo";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return new WebhookInfo($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
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
            "https://api.telegram.org:443/bot" . $this->bot_token . "/getMe";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return new User($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function log_out(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function close(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup = null
    ): Message {
        $params = [
            "chat_id" => $chat_id,
            "text" => $text,
        ];

        if ($message_thread_id != null) {
            $params["message_thread_id"] = $message_thread_id;
        }

        if ($parse_mode != null) {
            $params["parse_mode"] = $parse_mode;
        }

        if ($text != null && $parse_mode == "HTML") {
            $params["text"] = remove_invalid_tags($params["text"]);
        }

        if ($entities != null) {
            $params["entities"] = $entities;
        }

        if ($disable_web_page_preview != null) {
            $params["disable_web_page_preview"] = $disable_web_page_preview;
        }

        if ($disable_notification != null) {
            $params["disable_notification"] = $disable_notification;
        }

        if ($protect_content != null) {
            $params["protect_content"] = $protect_content;
        }

        if ($reply_to_message_id != null) {
            $params["reply_to_message_id"] = $reply_to_message_id;
        }

        if ($allow_sending_without_reply != null) {
            $params["allow_sending_without_reply"] = $allow_sending_without_reply;
        }

        if ($reply_markup != null) {
            $params["reply_markup"] = $reply_markup;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/sendMessage";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return new Message($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function forward_message(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup = null
    ): MessageId {
        $params = [
            "chat_id" => $chat_id,
            "from_chat_id" => $from_chat_id,
            "message_id" => $message_id,
        ];

        if ($message_thread_id != null) {
            $params["message_thread_id"] = $message_thread_id;
        }

        if ($caption != null) {
            $params["caption"] = $caption;
        }

        if ($parse_mode != null) {
            $params["parse_mode"] = $parse_mode;
        }

        if ($caption_entities != null) {
            $params["caption_entities"] = $caption_entities;
        }

        if ($disable_notification != null) {
            $params["disable_notification"] = $disable_notification;
        }

        if ($protect_content != null) {
            $params["protect_content"] = $protect_content;
        }

        if ($reply_to_message_id != null) {
            $params["reply_to_message_id"] = $reply_to_message_id;
        }

        if ($allow_sending_without_reply != null) {
            $params["allow_sending_without_reply"] = $allow_sending_without_reply;
        }

        if ($reply_markup != null) {
            $params["reply_markup"] = $reply_markup;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/copyMessage";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return new MessageId($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_photo(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_audio(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $reply_markup = null
    ): Message {
        $params = [
            "chat_id" => $chat_id,
            "document" => $document,
        ];

        if ($message_thread_id != null) {
            $params["message_thread_id"] = $message_thread_id;
        }

        if ($thumbnail != null) {
            $params["thumbnail"] = $thumbnail;
        }

        if ($caption != null) {
            $params["caption"] = $caption;
        }

        if ($parse_mode != null) {
            $params["parse_mode"] = $parse_mode;
        }

        if (isset($params["caption"]) && $parse_mode == "HTML") {
            $params["caption"] = remove_invalid_tags($params["caption"]);
        }

        if ($caption_entities != null) {
            $params["caption_entities"] = $caption_entities;
        }

        if ($disable_content_type_detection != null) {
            $params["disable_content_type_detection"] = $disable_content_type_detection;
        }

        if ($disable_notification != null) {
            $params["disable_notification"] = $disable_notification;
        }

        if ($protect_content != null) {
            $params["protect_content"] = $protect_content;
        }

        if ($reply_to_message_id != null) {
            $params["reply_to_message_id"] = $reply_to_message_id;
        }

        if ($allow_sending_without_reply != null) {
            $params["allow_sending_without_reply"] = $allow_sending_without_reply;
        }

        if ($reply_markup != null) {
            $params["reply_markup"] = $reply_markup;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/sendDocument";

        // ---

        if ($document instanceof InputFile || $thumbnail instanceof InputFile) {
            if ($document instanceof InputFile) {
                $params["document"] = new CURLFile($document->_path);
            }

            if ($thumbnail instanceof InputFile) {
                $params["thumbnail"] = new CURLFile($thumbnail->_path);
            }

            $payload = $params;
            $response = self::send_request(
                $telegram_api_url,
                $payload,
                "multipart/form-data"
            );
        } else {
            $payload = self::je($params);
            $response = self::send_request($telegram_api_url, $payload);
        }

        if ($response["ok"]) {
            return new Message($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_video(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_animation(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_voice(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_video_note(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_media_group(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_location(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_venue(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_contact(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_poll(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_dice(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_chat_action(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_user_profile_photos(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_file(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function ban_chat_member(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unban_chat_member(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function restrict_chat_member(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function promote_chat_member(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_administrator_custom_title(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function ban_chat_sender_chat(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unban_chat_sender_chat(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_permissions(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function export_chat_invite_link(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function create_chat_invite_link(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_chat_invite_link(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function revoke_chat_invite_link(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function approve_chat_join_request(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function decline_chat_join_request(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_photo(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_chat_photo(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_title(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_description(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function pin_chat_message(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unpin_chat_message(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unpin_all_chat_messages(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function leave_chat(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_chat(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_chat_administrators(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_chat_member_count(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * Use this method to get information about a member of a chat. The method is only guaranteed to work for other users if the bot is an administrator in the chat. Returns a ChatMember object on success.
     * @param string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     * @param int $user_id Unique identifier of the target user
     */
    function get_chat_member(string|int $chat_id, int $user_id): ChatMember
    {
        $params = [
            "chat_id" => $chat_id,
            "user_id" => $user_id,
        ];

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/getChatMember";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return new ChatMember($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_sticker_set(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_chat_sticker_set(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_forum_topic_icon_stickers(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function create_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function close_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function reopen_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unpin_all_forum_topic_messages(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_general_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function close_general_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function reopen_general_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function hide_general_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function unhide_general_forum_topic(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
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
        int $cache_time = null
    ): bool {
        $params = [
            "callback_query_id" => $callback_query_id,
        ];

        if ($text != null) {
            $params["text"] = $text;
        }

        if ($show_alert != null) {
            $params["show_alert"] = $show_alert;
        }

        if ($url != null) {
            $params["url"] = $url;
        }

        if ($cache_time != null) {
            $params["cache_time"] = $cache_time;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/answerCallbackQuery";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return boolval($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * Use this method to change the list of the bot's commands. See this manual for more details about bot commands. Returns True on success.
     * @param array<BotCommand> $commands A JSON-serialized list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     * @param BotCommandScope $scope A JSON-serialized object, describing scope of users for which the commands are relevant. Defaults to BotCommandScopeDefault.
     * @param string $language_code A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     */
    function set_my_commands(
        array $commands,
        BotCommandScope $scope = null,
        string $language_code = null
    ): bool {
        $params = [
            "commands" => $commands,
        ];

        if ($scope != null) {
            $params["scope"] = $scope;
        }

        if ($language_code != null) {
            $params["language_code"] = $language_code;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/setMyCommands";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return boolval($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_my_commands(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * Use this method to get the current list of the bot's commands for the given scope and user language. Returns an Array of BotCommand objects. If commands aren't set, an empty list is returned.
     * @param BotCommandScope $scope A JSON-serialized object, describing scope of users. Defaults to BotCommandScopeDefault.
     * @param string $language_code A two-letter ISO 639-1 language code or an empty string
     * @return array<BotCommand>
     */
    function get_my_commands($scope = null, string $language_code = null): array
    {
        $params = [];

        if ($scope != null) {
            $params["scope"] = $scope;
        }

        if ($language_code != null) {
            $params["language_code"] = $language_code;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/getMyCommands";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            $bot_commands_array = [];

            if (is_iterable($response["result"])) {
                foreach ($response["result"] as $obj) {
                    $bot_commands_array[] = new BotCommand($obj);
                }
            }

            return $bot_commands_array;
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
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
        string $language_code = null
    ): bool {
        $params = [];

        if ($name != null) {
            $params["name"] = $name;
        }

        if ($language_code != null) {
            $params["language_code"] = $language_code;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/setMyName";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return boolval($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
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
            $params["language_code"] = $language_code;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/getMyName";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return new BotName($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
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
        string $language_code = null
    ): bool {
        $params = [];

        if ($description != null) {
            $params["description"] = $description;
        }

        if ($language_code != null) {
            $params["language_code"] = $language_code;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/setMyDescription";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return boolval($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
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
            $params["language_code"] = $language_code;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/getMyDescription";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return new BotDescription($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
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
        string $language_code = null
    ): bool {
        $params = [];

        if ($short_description != null) {
            $params["short_description"] = $short_description;
        }

        if ($language_code != null) {
            $params["language_code"] = $language_code;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/setMyShortDescription";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return boolval($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }
    /**
     * Use this method to get the current bot description for the given user language. Returns BotDescription on success.
     * @param string $language_code A two-letter ISO 639-1 language code or an empty string
     */
    function get_my_short_description(
        string $language_code = null
    ): BotShortDescription {
        $params = [];

        if ($language_code != null) {
            $params["language_code"] = $language_code;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/getMyShortDescription";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return new BotShortDescription($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_chat_menu_button(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_chat_menu_button(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_my_default_administrator_rights(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_my_default_administrator_rights(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
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
        InlineKeyboardMarkup $reply_markup = null
    ): bool|Message {
        $params = [
            "text" => $text,
        ];

        if ($chat_id != null) {
            $params["chat_id"] = $chat_id;
        }

        if ($message_id != null) {
            $params["message_id"] = $message_id;
        }

        if ($inline_message_id != null) {
            $params["inline_message_id"] = $inline_message_id;
        }

        if ($parse_mode != null) {
            $params["parse_mode"] = $parse_mode;
        }

        if ($text != null && $parse_mode == "HTML") {
            $params["text"] = remove_invalid_tags($params["text"]);
        }

        if ($entities != null) {
            $params["entities"] = $entities;
        }

        if ($disable_web_page_preview != null) {
            $params["disable_web_page_preview"] = $disable_web_page_preview;
        }

        if ($reply_markup != null) {
            $params["reply_markup"] = $reply_markup;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/editMessageText";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            if (is_bool($response["result"])) {
                return $response["result"];
            }

            return new Message($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_message_caption(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_message_media(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function edit_message_live_location(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function stop_message_live_location(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
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
        InlineKeyboardMarkup $reply_markup = null
    ): bool|Message {
        $params = [];

        if ($chat_id != null) {
            $params["chat_id"] = $chat_id;
        }

        if ($message_id != null) {
            $params["message_id"] = $message_id;
        }

        if ($inline_message_id != null) {
            $params["inline_message_id"] = $inline_message_id;
        }
        if ($reply_markup != null) {
            $params["reply_markup"] = $reply_markup;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/editMessageReplyMarkup";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            if (is_bool($response["result"])) {
                return $response["result"];
            }

            return new Message($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function stop_poll(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_message(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    // ---- ---- ---- ---- STICKERS---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_sticker(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_sticker_set(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_custom_emoji_stickers(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function upload_sticker_file(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function create_new_sticker_set(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function add_sticker_to_set(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_position_in_set(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_sticker_from_set(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_emoji_list(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_keywords(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_mask_position(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_set_title(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_sticker_set_thumbnail(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_custom_emoji_sticker_set_thumbnail(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function delete_sticker_set(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
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
        InlineQueryResultsButton $button = null
    ): bool {
        $params = [
            "inline_query_id" => $inline_query_id,
            "results" => $results,
        ];

        if ($cache_time != null) {
            $params["cache_time"] = $cache_time;
        }

        if ($is_personal != null) {
            $params["is_personal"] = $is_personal;
        }

        if ($next_offset != null) {
            $params["next_offset"] = $next_offset;
        }

        if ($button != null) {
            $params["button"] = $button;
        }

        $telegram_api_url =
            "https://api.telegram.org:443/bot" .
            $this->bot_token .
            "/answerInlineQuery";

        // ---

        $payload = self::je($params);

        $response = self::send_request($telegram_api_url, $payload);
        if ($response["ok"]) {
            return boolval($response["result"]);
        } else {
            if (gettype($response["description"]) == "string") {
                throw new Exception($response["description"]);
            } else {
                throw new Exception("Error!");
            }
        }
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function answer_web_app_query(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    // ---- ---- ---- ---- PAYMENTS ---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_invoice(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function create_invoice_link(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function answer_shipping_query(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function answer_pre_checkout_query(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    // ---- ---- ---- ---- TELEGRAM PASSPORT ---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_passport_data_errors(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    // ---- ---- ---- ---- GAMES ---- ---- ---- ----

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function send_game(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function set_game_score(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }

    /**
     * NOT IMPLEMENTED YET! DO NOT USE
     */
    function get_game_high_scores(): void
    {
        throw new Error("NOT IMPLEMENTED YET");
    }
}
