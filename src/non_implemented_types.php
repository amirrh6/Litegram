<?php

namespace Litegram;

/**
 * TODO:
 * Describes the current status of a webhook
 */
#[\AllowDynamicProperties]
class WebhookInfo
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 * This object represents one special entity in a text message. For example, hashtags, usernames, URLs, etc.
 */
#[\AllowDynamicProperties]
class MessageEntity
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 * This object represents one size of a photo or a file / sticker thumbnail.
 */
#[\AllowDynamicProperties]
class PhotoSize
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 * This object represents an animation file (GIF or H.264/MPEG-4 AVC video without sound).
 */
#[\AllowDynamicProperties]
class Animation
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 * This object represents an audio file to be treated as music by the Telegram clients.
 */
#[\AllowDynamicProperties]
class Audio
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 * This object represents a general file (as opposed to photos, voice messages and audio files).
 */
#[\AllowDynamicProperties]
class Document
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 * This object represents a video file.
 */
#[\AllowDynamicProperties]
class Video
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 * This object represents a video message (available in Telegram apps as of v.4.0).
 */
#[\AllowDynamicProperties]
class VideoNote
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 * This object represents a voice note.
 */
#[\AllowDynamicProperties]
class Voice
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class MessageReactionUpdated
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class MessageReactionCountUpdated
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatBoostUpdated
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatBoostRemoved
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class UsersShared
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class PaidMediaInfo
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class RefundedPayment
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatBoostAdded
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatBackground
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Giveaway
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class GiveawayCreated
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class GiveawayCompleted
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class GiveawayWinners
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Story
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ExternalReplyInfo
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class TextQuote
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class LinkPreviewOptions
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class MessageOrigin
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Contact
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Dice
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class PollOption
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Location
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Venue
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class WebAppData
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ProximityAlertTriggered
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class MessageAutoDeleteTimerChanged
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ForumTopicCreated
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ForumTopicClosed
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ForumTopicEdited
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ForumTopicReopened
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class GeneralForumTopicHidden
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class GeneralForumTopicUnhidden
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class WriteAccessAllowed
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class VideoChatScheduled
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class VideoChatStarted
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class VideoChatEnded
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class VideoChatParticipantsInvited
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class UserProfilePhotos
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class File
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class KeyboardButtonRequestUsers
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class KeyboardButtonPollType
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class LoginUrl
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class SwitchInlineQueryChosenChat
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatPhoto
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatInviteLink
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatAdministratorRights
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatMemberOwner
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatMemberAdministrator
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatMemberMember
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatMemberRestricted
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatMemberLeft
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatMemberBanned
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ForumTopic
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class BotShortDescription
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class PassportData
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class PassportFile
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class EncryptedPassportElement
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class EncryptedCredentials
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class PassportElementError
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class PassportElementErrorUnspecified
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Game
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class CallbackGame
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class GameHighScore
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class SentWebAppMessage
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class LabeledPrice
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Invoice
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ShippingAddress
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class OrderInfo
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ShippingOption
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class SuccessfulPayment
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class InlineQueryResult
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class InputMessageContent
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Sticker
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class StickerSet
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class InputMediaPhoto
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class InputMediaVideo
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class InputMediaAnimation
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class InputMediaAudio
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class InputMediaDocument
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class MenuButtonCommands
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class MenuButtonWebApp
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class MenuButtonDefault
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ResponseParameters
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class MaskPosition
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class InputSticker
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatPermissions
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ChatLocation
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class Birthdate
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class BusinessIntro
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class BusinessLocation
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class BusinessOpeningHours
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

/**
 * TODO:
 */
#[\AllowDynamicProperties]
class ReactionType
{
    public function __construct($init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}
