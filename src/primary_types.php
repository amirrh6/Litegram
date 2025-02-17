<?php

namespace Litegram;

use Exception;

// TODO: Use constructor property promotion (https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion)
// TODO: Consider the need for manually filling array of with objects of the suitable class in __FillPropsFromObject()
// TODO: Consider if classes of union types should be converted to an abstract class or perhaps an interface

function property_exists_and_is_object(
    object|string $object_or_class,
    string $property,
): bool {
    return property_exists($object_or_class, $property) &&
        is_object($object_or_class->$property);
}

function choose_message_origin_subclass(object $init_data_origin)
{
    switch ($init_data_origin->type) {
        case 'user':
            return new MessageOriginUser();
        case 'hidden_user':
            return new MessageOriginHiddenUser();
        case 'chat':
            return new MessageOriginChat();
        case 'channel':
            return new MessageOriginChannel();
        default:
            throw new Exception('Unexpected type: ' . $init_data_origin->type);
    }
}

function choose_chat_member_subclass(object $init_data_chat_member)
{
    switch ($init_data_chat_member->status) {
        case 'creator':
            return new ChatMemberOwner();
        case 'administrator':
            return new ChatMemberAdministrator();
        case 'member':
            return new ChatMemberMember();
        case 'restricted':
            return new ChatMemberRestricted();
        case 'left':
            return new ChatMemberLeft();
        case 'kicked':
            return new ChatMemberBanned();
        default:
            throw new Exception(
                'Unexpected status: ' . $init_data_chat_member->status,
            );
    }
}

/**
 * This class provided a custom JSON serialization which does not include fields that evaluate to null
 */
class CustomJsonSerialization implements \JsonSerializable
{
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

    public function __construct()
    {
    }

    public function _jsonPrettyPrint()
    {
        return json_encode(
            $this,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        );
    }

    public function __FillPropsFromObject(object $init_data)
    {
        $arr = get_object_vars($init_data);
        foreach ($arr as $key => $value) {
            if (!($value instanceof \stdClass)) {
                $this->$key = $init_data->$key;
            }
        }
    }
}

// -------------------------------------------------------------------

/**
 * This object represents an incoming update.
 * At most one of the optional parameters can be present in any given update.
 */
class Update extends CustomJsonSerialization
{
    // TODO: Consider if optional properties should be initialized to null or not.

    /**
     * The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially. This ID becomes especially handy if you're using webhooks, since it allows you to ignore repeated updates or to restore the correct update sequence, should they get out of order. If there are no new updates for at least a week, then identifier of the next update will be chosen randomly instead of sequentially.
     */
    public int $update_id;

    /**
     * Optional. New incoming message of any kind - text, photo, sticker, etc.
     */
    public ?Message $message = null;

    /**
     * Optional. New version of a message that is known to the bot and was edited
     */
    public ?Message $edited_message = null;

    /**
     * Optional. New incoming channel post of any kind - text, photo, sticker, etc.
     */
    public ?Message $channel_post = null;

    /**
     * Optional. New version of a channel post that is known to the bot and was edited
     */
    public ?Message $edited_channel_post = null;

    /**
     * Optional. The bot was connected to or disconnected from a business account, or a user edited an existing connection with the bot
     */
    public ?BusinessConnection $business_connection = null;

    /**
     * Optional. New message from a connected business account
     */
    public ?Message $business_message = null;

    /**
     * Optional. New version of a message from a connected business account
     */
    public ?Message $edited_business_message = null;

    /**
     * Optional. Messages were deleted from a connected business account
     */
    public ?BusinessMessagesDeleted $deleted_business_message = null;

    /**
     * Optional. A reaction to a message was changed by a user. The bot must be an administrator in the chat and must explicitly specify "message_reaction" in the list of allowed_updates to receive these updates. The update isn't received for reactions set by bots.
     */
    public ?MessageReactionUpdated $message_reaction = null;

    /**
     * Optional. Reactions to a message with anonymous reactions were changed. The bot must be an administrator in the chat and must explicitly specify "message_reaction_count" in the list of allowed_updates to receive these updates. The updates are grouped and can be sent with delay up to a few minutes.
     */
    public ?MessageReactionCountUpdated $message_reaction_count = null;

    /**
     * Optional. New incoming inline query
     */
    public ?InlineQuery $inline_query = null;

    /**
     * Optional. The result of an inline query that was chosen by a user and sent to their chat partner. Please see our documentation on the feedback collecting for details on how to enable these updates for your bot.
     */
    public ?ChosenInlineResult $chosen_inline_result = null;

    /**
     * Optional. New incoming callback query
     */
    public ?CallbackQuery $callback_query = null;

    /**
     * Optional. New incoming shipping query. Only for invoices with flexible price
     */
    public ?ShippingQuery $shipping_query = null;

    /**
     * Optional. New incoming pre-checkout query. Contains full information about checkout
     */
    public ?PreCheckoutQuery $pre_checkout_query = null;

    /**
     * Optional. A user purchased paid media with a non-empty payload sent by the bot in a non-channel chat
     */
    public ?PaidMediaPurchased $purchased_paid_media = null;

    /**
     * Optional. New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
     */
    public ?Poll $poll = null;

    /**
     * Optional. A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself.
     */
    public ?PollAnswer $poll_answer = null;

    /**
     * Optional. The bot's chat member status was updated in a chat. For private chats, this update is received only when the bot is blocked or unblocked by the user.
     */
    public ?ChatMemberUpdated $my_chat_member = null;

    /**
     * Optional. A chat member's status was updated in a chat. The bot must be an administrator in the chat and must explicitly specify “chat_member” in the list of allowed_updates to receive these updates.
     */
    public ?ChatMemberUpdated $chat_member = null;

    /**
     * Optional. A request to join the chat has been sent. The bot must have the can_invite_users administrator right in the chat to receive these updates.
     */
    public ?ChatJoinRequest $chat_join_request = null;

    /**
     * Optional. A chat boost was added or changed. The bot must be an administrator in the chat to receive these updates.
     */
    public ?ChatBoostUpdated $chat_boost = null;

    /**
     * Optional. A boost was removed from a chat. The bot must be an administrator in the chat to receive these updates.
     */
    public ?ChatBoostRemoved $removed_chat_boost = null;

    public function __construct(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        // TODO: Think of a better way to automatically initialize these properties

        if (property_exists_and_is_object($init_data, 'message')) {
            $this->message = new Message();
            $this->message->__FillPropsFromObject($init_data->message);
        }

        if (property_exists_and_is_object($init_data, 'edited_message')) {
            $this->edited_message = new Message();
            $this->edited_message->__FillPropsFromObject(
                $init_data->edited_message,
            );
        }

        if (property_exists_and_is_object($init_data, 'channel_post')) {
            $this->channel_post = new Message();
            $this->channel_post->__FillPropsFromObject(
                $init_data->channel_post,
            );
        }

        if (property_exists_and_is_object($init_data, 'edited_channel_post')) {
            $this->edited_channel_post = new Message();
            $this->edited_channel_post->__FillPropsFromObject(
                $init_data->edited_channel_post,
            );
        }

        if (property_exists_and_is_object($init_data, 'business_connection')) {
            $this->business_connection = new BusinessConnection();
            $this->business_connection->__FillPropsFromObject(
                $init_data->business_connection,
            );
        }

        if (property_exists_and_is_object($init_data, 'business_message')) {
            $this->business_message = new Message();
            $this->business_message->__FillPropsFromObject(
                $init_data->business_message,
            );
        }

        if (
            property_exists_and_is_object($init_data, 'edited_business_message')
        ) {
            $this->edited_business_message = new Message();
            $this->edited_business_message->__FillPropsFromObject(
                $init_data->edited_business_message,
            );
        }

        if (
            property_exists_and_is_object(
                $init_data,
                'deleted_business_message',
            )
        ) {
            $this->deleted_business_message = new BusinessMessagesDeleted();
            $this->deleted_business_message->__FillPropsFromObject(
                $init_data->deleted_business_message,
            );
        }

        if (property_exists_and_is_object($init_data, 'message_reaction')) {
            $this->message_reaction = new MessageReactionUpdated();
            $this->message_reaction->__FillPropsFromObject(
                $init_data->message_reaction,
            );
        }

        if (
            property_exists_and_is_object($init_data, 'message_reaction_count')
        ) {
            $this->message_reaction_count = new MessageReactionCountUpdated();
            $this->message_reaction_count->__FillPropsFromObject(
                $init_data->message_reaction_count,
            );
        }

        if (property_exists_and_is_object($init_data, 'inline_query')) {
            $this->inline_query = new InlineQuery();
            $this->inline_query->__FillPropsFromObject(
                $init_data->inline_query,
            );
        }

        if (property_exists_and_is_object($init_data, 'chosen_inline_result')) {
            $this->chosen_inline_result = new ChosenInlineResult();
            $this->inline_query->__FillPropsFromObject(
                $init_data->chosen_inline_result,
            );
        }

        if (property_exists_and_is_object($init_data, 'callback_query')) {
            $this->callback_query = new CallbackQuery();
            $this->callback_query->__FillPropsFromObject(
                $init_data->callback_query,
            );
        }

        if (property_exists_and_is_object($init_data, 'shipping_query')) {
            $this->shipping_query = new ShippingQuery();
            $this->shipping_query->__FillPropsFromObject(
                $init_data->shipping_query,
            );
        }

        if (property_exists_and_is_object($init_data, 'pre_checkout_query')) {
            $this->pre_checkout_query = new PreCheckoutQuery();
            $this->pre_checkout_query->__FillPropsFromObject(
                $init_data->pre_checkout_query,
            );
        }

        if (property_exists_and_is_object($init_data, 'purchased_paid_media')) {
            $this->purchased_paid_media = new PaidMediaPurchased();
            $this->purchased_paid_media->__FillPropsFromObject(
                $init_data->purchased_paid_media,
            );
        }

        if (property_exists_and_is_object($init_data, 'poll')) {
            $this->poll = new Poll();
            $this->poll->__FillPropsFromObject($init_data->poll);
        }

        if (property_exists_and_is_object($init_data, 'poll_answer')) {
            $this->poll_answer = new PollAnswer();
            $this->poll_answer->__FillPropsFromObject($init_data->poll_answer);
        }

        if (property_exists_and_is_object($init_data, 'my_chat_member')) {
            $this->my_chat_member = new ChatMemberUpdated();
            $this->my_chat_member->__FillPropsFromObject(
                $init_data->my_chat_member,
            );
        }

        if (property_exists_and_is_object($init_data, 'chat_member')) {
            $this->chat_member = new ChatMemberUpdated();
            $this->chat_member->__FillPropsFromObject($init_data->chat_member);
        }

        if (property_exists_and_is_object($init_data, 'chat_join_request')) {
            $this->chat_join_request = new ChatJoinRequest();
            $this->chat_join_request->__FillPropsFromObject(
                $init_data->chat_join_request,
            );
        }

        if (property_exists_and_is_object($init_data, 'chat_boost')) {
            $this->chat_boost = new ChatBoostUpdated();
            $this->chat_boost->__FillPropsFromObject($init_data->chat_boost);
        }

        if (property_exists_and_is_object($init_data, 'removed_chat_boost')) {
            $this->removed_chat_boost = new ChatBoostRemoved();
            $this->removed_chat_boost->__FillPropsFromObject(
                $init_data->removed_chat_boost,
            );
        }
    }
}

/**
 * Describes the current status of a webhook
 */
class WebhookInfo extends CustomJsonSerialization
{
    /**
     * Webhook URL, may be empty if webhook is not set up
     */
    public string $url;

    /**
     * True, if a custom certificate was provided for webhook certificate checks
     */
    public bool $has_custom_certificate;

    /**
     * Number of updates awaiting delivery
     */
    public int $pending_update_count;

    /**
     * Optional. Currently used webhook IP address
     */
    public ?string $ip_address = null;

    /**
     * Optional. Unix time for the most recent error that happened when trying to deliver an update via webhook
     */
    public ?int $last_error_date = null;

    /**
     * Optional. Error message in human-readable format for the most recent error that happened when trying to deliver an update via webhook
     */
    public ?string $last_error_message = null;

    /**
     * Optional. Unix time of the most recent error that happened when trying to synchronize available updates with Telegram datacenters
     */
    public ?int $last_synchronization_error_date = null;

    /**
     * Optional. The maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery
     */
    public ?int $max_connections = null;

    /**
     * @var array<string> $allowed_updates Optional. A list of update types the bot is subscribed to. Defaults to all update types except chat_member
     */
    public ?array $allowed_updates = null;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

// -------------------------------------------------------------------

/**
 * This object represents a Telegram user or bot.
 */
class User extends CustomJsonSerialization
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

    /**
     * Optional. True, if the bot can be connected to a Telegram Business account to receive its messages. Returned only in getMe.
     */
    public ?bool $can_connect_to_business = null;

    /**
     * Optional. True, if the bot has a main Web App. Returned only in getMe.
     */
    public ?bool $has_main_web_app = null;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }

    public function _get_full_name(): string
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
class Chat extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object contains full information about a chat.
 */
class ChatFullInfo extends CustomJsonSerialization
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
     * Identifier of the accent color for the chat name and backgrounds of the chat photo, reply header, and link preview. See accent colors for more details.
     */
    public int $accent_color_id;

    /**
     * The maximum number of reactions that can be set on a message in the chat
     */
    public int $max_reaction_count;

    /**
     * Optional. Chat photo
     */
    public ?ChatPhoto $photo = null;

    /**
     * Optional. If non-empty, the list of all active chat usernames; for private chats, supergroups and channels
     * @var array<string>
     */
    public ?array $active_usernames = null;

    /**
     * Optional. For private chats, the date of birth of the user
     */
    public ?Birthdate $birthdate = null;

    /**
     * Optional. For private chats with business accounts, the intro of the business
     */
    public ?BusinessIntro $business_intro = null;

    /**
     * Optional. For private chats with business accounts, the location of the business
     */
    public ?BusinessLocation $business_location = null;

    /**
     * Optional. For private chats with business accounts, the opening hours of the business
     */
    public ?BusinessOpeningHours $business_opening_hours = null;

    /**
     * Optional. For private chats, the personal channel of the user
     */
    public ?Chat $personal_chat = null;

    /**
     * Optional. List of available reactions allowed in the chat. If omitted, then all emoji reactions are allowed.
     * @var array<ReactionType>
     */
    public ?array $available_reactions = null;

    /**
     * Optional. Custom emoji identifier of the emoji chosen by the chat for the reply header and link preview background
     */
    public ?string $background_custom_emoji_id = null;

    /**
     * Optional. Identifier of the accent color for the chat's profile background. See profile accent colors for more details.
     */
    public ?int $profile_accent_color_id = null;

    /**
     * Optional. Custom emoji identifier of the emoji chosen by the chat for its profile background
     */
    public ?string $profile_background_custom_emoji_id = null;

    /**
     * Optional. Custom emoji identifier of emoji status of the other party in a private chat.
     */
    public ?string $emoji_status_custom_emoji_id = null;

    /**
     * Optional. Expiration date of the emoji status of the chat or the other party in a private chat, in Unix time, if any
     */
    public ?int $emoji_status_expiration_date = null;

    /**
     * Optional. Bio of the other party in a private chat.
     */
    public ?string $bio = null;

    /**
     * Optional. True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id> links only in chats with the user.
     */
    public ?true $has_private_forwards = null;

    /**
     * Optional. True, if the privacy settings of the other party restrict sending voice and video note messages in the private chat.
     */
    public ?true $has_restricted_voice_and_video_messages = null;

    /**
     * Optional. True, if users need to join the supergroup before they can send messages.
     */
    public ?true $join_to_send_messages = null;

    /**
     * Optional. True, if all users directly joining the supergroup need to be approved by supergroup administrators.
     */
    public ?true $join_by_request = null;

    /**
     * Optional. Description, for groups, supergroups and channel chats.
     */
    public ?string $description = null;

    /**
     * Optional. Primary invite link, for groups, supergroups and channel chats.
     */
    public ?string $invite_link = null;

    /**
     * Optional. The most recent pinned message (by sending date).
     */
    public ?Message $pinned_message = null;

    /**
     * Optional. Default chat member permissions, for groups and supergroups.
     */
    public ?ChatPermissions $permissions = null;

    /**
     * Optional. True, if paid media messages can be sent or forwarded to the channel chat. The field is available only for channel chats.
     */
    public ?true $can_send_paid_media = null;

    /**
     * Optional. For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged user;
     *  in seconds.
     */
    public ?int $slow_mode_delay = null;

    /**
     * Optional. For supergroups, the minimum number of boosts that a non-administrator user needs to add in order to ignore slow mode and chat permissions
     */
    public ?int $unrestrict_boost_count = null;

    /**
     * Optional. The time after which all messages sent to the chat will be automatically deleted;
     *  in seconds.
     */
    public ?int $message_auto_delete_time = null;

    /**
     * Optional. True, if aggressive anti-spam checks are enabled in the supergroup. The field is only available to chat administrators.
     */
    public ?true $has_aggressive_anti_spam_enabled = null;

    /**
     * Optional. True, if non-administrators can only get the list of bots and administrators in the chat.
     */
    public ?true $has_hidden_members = null;

    /**
     * Optional. True, if messages from the chat can't be forwarded to other chats.
     */
    public ?true $has_protected_content = null;

    /**
     * Optional. True, if new chat members will have access to old messages; available only to chat administrators
     */
    public ?true $has_visible_history = null;

    /**
     * Optional. For supergroups, name of group sticker set.
     */
    public ?string $sticker_set_name = null;

    /**
     * Optional. True, if the bot can change the group sticker set.
     */
    public ?true $can_set_sticker_set = null;

    /**
     * Optional. For supergroups, the name of the group's custom emoji sticker set. Custom emoji from this set can be used by all users and bots in the group.
     */
    public ?string $custom_emoji_sticker_set_name = null;

    /**
     * Optional. Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice versa;
     *  for supergroups and channel chats. This identifier may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier.
     */
    public ?int $linked_chat_id = null;

    /**
     * Optional. For supergroups, the location to which the supergroup is connected.
     */
    public ?ChatLocation $location = null;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'photo')) {
            $this->photo = new ChatPhoto();
            $this->photo->__FillPropsFromObject($init_data->photo);
        }

        if (property_exists_and_is_object($init_data, 'birthdate')) {
            $this->birthdate = new Birthdate();
            $this->birthdate->__FillPropsFromObject($init_data->birthdate);
        }

        if (property_exists_and_is_object($init_data, 'business_intro')) {
            $this->business_intro = new BusinessIntro();
            $this->business_intro->__FillPropsFromObject(
                $init_data->business_intro,
            );
        }

        if (property_exists_and_is_object($init_data, 'business_location')) {
            $this->business_location = new BusinessLocation();
            $this->business_location->__FillPropsFromObject(
                $init_data->business_location,
            );
        }

        if (
            property_exists_and_is_object($init_data, 'business_opening_hours')
        ) {
            $this->business_opening_hours = new BusinessOpeningHours();
            $this->business_opening_hours->__FillPropsFromObject(
                $init_data->business_opening_hours,
            );
        }

        if (property_exists_and_is_object($init_data, 'personal_chat')) {
            $this->personal_chat = new Chat();
            $this->personal_chat->__FillPropsFromObject(
                $init_data->personal_chat,
            );
        }

        if (property_exists_and_is_object($init_data, 'pinned_message')) {
            $this->pinned_message = new Message();
            $this->pinned_message->__FillPropsFromObject(
                $init_data->pinned_message,
            );
        }

        if (property_exists_and_is_object($init_data, 'permissions')) {
            $this->permissions = new ChatPermissions();
            $this->permissions->__FillPropsFromObject($init_data->permissions);
        }

        if (property_exists_and_is_object($init_data, 'location')) {
            $this->location = new ChatLocation();
            $this->location->__FillPropsFromObject($init_data->location);
        }
    }
}

/**
 * This object represents a message.
 */
// Needed because sometimes Telegram adds some properties in order to ensure backward compatibility
#[\AllowDynamicProperties]
class Message extends CustomJsonSerialization implements
    MaybeInaccessibleMessage
{
    /**
     * Unique message identifier inside this chat
     */
    public int $message_id;

    /**
     * Optional. Unique identifier of a message thread to which the message belongs; for supergroups only
     */
    public ?int $message_thread_id = null;

    /**
     * Optional. Sender of the message; empty for messages sent to channels. For backward compatibility, the field contains a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     */
    public ?User $from = null;

    /**
     * Optional. Sender of the message, sent on behalf of a chat. For example, the channel itself for channel posts, the supergroup itself for messages from anonymous group administrators, the linked channel for messages automatically forwarded to the discussion group. For backward compatibility, the field from contains a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     */
    public ?Chat $sender_chat = null;

    /**
     * Optional. If the sender of the message boosted the chat, the number of boosts added by the user
     */
    public ?int $sender_boost_count = null;

    /**
     * Optional. The bot that actually sent the message on behalf of the business account. Available only for outgoing messages sent on behalf of the connected business account.
     */
    public ?User $sender_business_bot = null;

    /**
     * Date the message was sent in Unix time
     */
    public int $date;

    /**
     * Optional. Unique identifier of the business connection from which the message was received. If non-empty, the message belongs to a chat of the corresponding business account that is independent from any potential bot chat which might share the same identifier.
     */
    public ?string $business_connection_id = null;

    /**
     * Conversation the message belongs to
     */
    public Chat $chat;

    /**
     * (MessageOrigin) Optional. Information about the original message for forwarded messages
     */
    public MessageOriginUser|MessageOriginHiddenUser|MessageOriginChat|MessageOriginChannel|null $forward_origin = null;

    /**
     * Optional. True, if the message is sent to a forum topic
     */
    public ?true $is_topic_message = null;

    /**
     * Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion group
     */
    public ?true $is_automatic_forward = null;

    /**
     * Optional. For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
     */
    public ?Message $reply_to_message = null;

    /**
     * Optional. Information about the message that is being replied to, which may come from another chat or forum topic
     */
    public ?ExternalReplyInfo $external_reply = null;

    /**
     * Optional. For replies that quote part of the original message, the quoted part of the message
     */
    public ?TextQuote $quote = null;

    /**
     * Optional. For replies to a story, the original story
     */
    public ?Story $reply_to_story = null;

    /**
     * Optional. Bot through which the message was sent
     */
    public ?User $via_bot = null;

    /**
     * Optional. Date the message was last edited in Unix time
     */
    public ?int $edit_date = null;

    /**
     * Optional. True, if the message can't be forwarded
     */
    public ?true $has_protected_content = null;

    /**
     * Optional. True, if the message was sent by an implicit action, for example, as an away or a greeting business message, or as a scheduled message
     */
    public ?true $is_from_offline = null;

    /**
     * Optional. The unique identifier of a media message group this message belongs to
     */
    public ?string $media_group_id = null;

    /**
     * Optional. Signature of the post author for messages in channels, or the custom title of an anonymous group administrator
     */
    public ?string $author_signature = null;

    /**
     * Optional. For text messages, the actual UTF-8 text of the message
     */
    public ?string $text = null;

    /**
     * Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
     * @var array<MessageEntity>
     */
    public ?array $entities = null;

    /**
     * Optional. Options used for link preview generation for the message, if it is a text message and link preview options were changed
     */
    public ?LinkPreviewOptions $link_preview_options = null;

    /**
     * Optional. Unique identifier of the message effect added to the message
     */
    public ?string $effect_Id = null;

    /**
     * Optional. Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set
     */
    public ?Animation $animation = null;

    /**
     * Optional. Message is an audio file, information about the file
     */
    public ?Audio $audio = null;

    /**
     * Optional. Message is a general file, information about the file
     */
    public ?Document $document = null;

    /**
     * Optional. Message contains paid media; information about the paid media
     */
    public ?PaidMediaInfo $paid_media = null;

    /**
     * Optional. Message is a photo, available sizes of the photo
     * @var array<PhotoSize>
     */
    public ?array $photo = null;

    /**
     * Optional. Message is a sticker, information about the sticker
     */
    public ?Sticker $sticker = null;

    /**
     * Optional. Message is a forwarded story
     */
    public ?Story $story = null;

    /**
     * Optional. Message is a video, information about the video
     */
    public ?Video $video = null;

    /**
     * Optional. Message is a video note, information about the video message
     */
    public ?VideoNote $video_note = null;

    /**
     * Optional. Message is a voice message, information about the file
     */
    public ?Voice $voice = null;

    /**
     * Optional. Caption for the animation, audio, document, photo, video or voice
     */
    public ?string $caption = null;

    /**
     * Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption
     * @var array<MessageEntity>
     */
    public ?array $caption_entities = null;

    /**
     * Optional. True, if the caption must be shown above the message media
     */
    public ?true $show_caption_above_media = null;

    /**
     * Optional. True, if the message media is covered by a spoiler animation
     */
    public ?true $has_media_spoiler = null;

    /**
     * Optional. Message is a shared contact, information about the contact
     */
    public ?Contact $contact = null;

    /**
     * Optional. Message is a dice with random value
     */
    public ?Dice $dice = null;

    /**
     * Optional. Message is a game, information about the game. More about games »
     */
    public ?Game $game = null;

    /**
     * Optional. Message is a native poll, information about the poll
     */
    public ?Poll $poll = null;

    /**
     * Optional. Message is a venue, information about the venue. For backward compatibility, when this field is set, the location field will also be set
     */
    public ?Venue $venue = null;

    /**
     * Optional. Message is a shared location, information about the location
     */
    public ?Location $location = null;

    /**
     * Optional. New members that were added to the group or supergroup and information about them (the bot itself may be one of these members)
     * @var array<User>
     */
    public ?array $new_chat_members = null;

    /**
     * Optional. A member was removed from the group, information about them (this member may be the bot itself)
     */
    public ?User $left_chat_member = null;

    /**
     * Optional. A chat title was changed to this value
     */
    public ?string $new_chat_title = null;

    /**
     * Optional. A chat photo was change to this value
     * @var array<PhotoSize>
     */
    public ?array $new_chat_photo = null;

    /**
     * Optional. Service message: the chat photo was deleted
     */
    public ?true $delete_chat_photo = null;

    /**
     * Optional. Service message: the group has been created
     */
    public ?true $group_chat_created = null;

    /**
     * Optional. Service message: the supergroup has been created. This field can't be received in a message coming through updates, because bot can't be a member of a supergroup when it is created. It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup.
     */
    public ?true $supergroup_chat_created = null;

    /**
     * Optional. Service message: the channel has been created. This field can't be received in a message coming through updates, because bot can't be a member of a channel when it is created. It can only be found in reply_to_message if someone replies to a very first message in a channel.
     */
    public ?true $channel_chat_created = null;

    /**
     * Optional. Service message: auto-delete timer settings changed in the chat
     */
    public ?MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed = null;

    /**
     * Optional. The group has been migrated to a supergroup with the specified identifier. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public ?int $migrate_to_chat_id = null;

    /**
     * Optional. The supergroup has been migrated from a group with the specified identifier. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public ?int $migrate_from_chat_id = null;

    /**
     * (MaybeInaccessibleMessage) Optional. Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
     */
    public Message|InaccessibleMessage|null $pinned_message = null;

    /**
     * Optional. Message is an invoice for a payment, information about the invoice. More about payments »
     */
    public ?Invoice $invoice = null;

    /**
     * Optional. Message is a service message about a successful payment, information about the payment. More about payments »
     */
    public ?SuccessfulPayment $successful_payment = null;

    /**
     * Optional. Message is a service message about a refunded payment, information about the payment. More about payments »
     */
    public ?RefundedPayment $refunded_payment = null;

    /**
     * Optional. Service message: a user was shared with the bot
     */
    public ?UsersShared $users_shared = null;

    /**
     * Optional. Service message: a chat was shared with the bot
     */
    public ?ChatShared $chat_shared = null;

    /**
     * Optional. The domain name of the website on which the user has logged in. More about Telegram Login »
     */
    public ?string $connected_website = null;

    /**
     * Optional. Service message: the user allowed the bot added to the attachment menu to write messages
     */
    public ?WriteAccessAllowed $write_access_allowed = null;

    /**
     * Optional. Telegram Passport data
     */
    public ?PassportData $passport_data = null;

    /**
     * Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live Location.
     */
    public ?ProximityAlertTriggered $proximity_alert_triggered = null;

    /**
     * Optional. Service message: user boosted the chat
     */
    public ?ChatBoostAdded $boost_added = null;

    /**
     * Optional. Service message: chat background set
     */
    public ?ChatBackground $chat_background_set = null;

    /**
     * Optional. Service message: forum topic created
     */
    public ?ForumTopicCreated $forum_topic_created = null;

    /**
     * Optional. Service message: forum topic edited
     */
    public ?ForumTopicEdited $forum_topic_edited = null;

    /**
     * Optional. Service message: forum topic closed
     */
    public ?ForumTopicClosed $forum_topic_closed = null;

    /**
     * Optional. Service message: forum topic reopened
     */
    public ?ForumTopicReopened $forum_topic_reopened = null;

    /**
     * Optional. Service message: the 'General' forum topic hidden
     */
    public ?GeneralForumTopicHidden $general_forum_topic_hidden = null;

    /**
     * Optional. Service message: the 'General' forum topic unhidden
     */
    public ?GeneralForumTopicUnhidden $general_forum_topic_unhidden = null;

    /**
     * Optional. Service message: a scheduled giveaway was created
     */
    public ?GiveawayCreated $giveaway_created = null;

    /**
     * Optional. The message is a scheduled giveaway message
     */
    public ?Giveaway $giveaway = null;

    /**
     * Optional. The message is a scheduled giveaway message
     */
    public ?GiveawayWinners $giveaway_winners = null;

    /**
     * Optional. Service message: a giveaway without public winners was completed
     */
    public ?GiveawayCompleted $giveaway_completed = null;

    /**
     * Optional. Service message: video chat scheduled
     */
    public ?VideoChatScheduled $video_chat_scheduled = null;

    /**
     * Optional. Service message: video chat started
     */
    public ?VideoChatStarted $video_chat_started = null;

    /**
     * Optional. Service message: video chat ended
     */
    public ?VideoChatEnded $video_chat_ended = null;

    /**
     * Optional. Service message: new participants invited to a video chat
     */
    public ?VideoChatParticipantsInvited $video_chat_participants_invited = null;

    /**
     * Optional. Service message: data sent by a Web App
     */
    public ?WebAppData $web_app_data = null;

    /**
     * Optional. Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }

        if (property_exists_and_is_object($init_data, 'sender_chat')) {
            $this->sender_chat = new Chat();
            $this->sender_chat->__FillPropsFromObject($init_data->sender_chat);
        }

        if (property_exists_and_is_object($init_data, 'sender_business_bot')) {
            $this->sender_business_bot = new User();
            $this->sender_business_bot->__FillPropsFromObject(
                $init_data->sender_business_bot,
            );
        }

        if (property_exists_and_is_object($init_data, 'chat')) {
            $this->chat = new Chat();
            $this->chat->__FillPropsFromObject($init_data->chat);
        }

        if (property_exists_and_is_object($init_data, 'forward_origin')) {
            $this->forward_origin = choose_message_origin_subclass(
                $init_data->forward_origin,
            );
            $this->forward_origin->__FillPropsFromObject(
                $init_data->forward_origin,
            );
        }

        if (property_exists_and_is_object($init_data, 'reply_to_message')) {
            $this->reply_to_message = new Message();
            $this->reply_to_message->__FillPropsFromObject(
                $init_data->reply_to_message,
            );
        }

        if (property_exists_and_is_object($init_data, 'external_reply')) {
            $this->external_reply = new ExternalReplyInfo();
            $this->external_reply->__FillPropsFromObject(
                $init_data->external_reply,
            );
        }

        if (property_exists_and_is_object($init_data, 'quote')) {
            $this->quote = new TextQuote();
            $this->quote->__FillPropsFromObject($init_data->quote);
        }

        if (property_exists_and_is_object($init_data, 'reply_to_story')) {
            $this->reply_to_story = new Story();
            $this->reply_to_story->__FillPropsFromObject(
                $init_data->reply_to_story,
            );
        }

        if (property_exists_and_is_object($init_data, 'via_bot')) {
            $this->via_bot = new User();
            $this->via_bot->__FillPropsFromObject($init_data->via_bot);
        }

        if (property_exists_and_is_object($init_data, 'link_preview_options')) {
            $this->link_preview_options = new LinkPreviewOptions();
            $this->link_preview_options->__FillPropsFromObject(
                $init_data->link_preview_options,
            );
        }

        if (property_exists_and_is_object($init_data, 'animation')) {
            $this->animation = new Animation();
            $this->animation->__FillPropsFromObject($init_data->animation);
        }

        if (property_exists_and_is_object($init_data, 'audio')) {
            $this->audio = new Audio();
            $this->audio->__FillPropsFromObject($init_data->audio);
        }

        if (property_exists_and_is_object($init_data, 'document')) {
            $this->document = new Document();
            $this->document->__FillPropsFromObject($init_data->document);
        }

        if (property_exists_and_is_object($init_data, 'paid_media')) {
            $this->paid_media = new PaidMediaInfo();
            $this->paid_media->__FillPropsFromObject($init_data->paid_media);
        }

        if (property_exists_and_is_object($init_data, 'sticker')) {
            $this->sticker = new Sticker();
            $this->sticker->__FillPropsFromObject($init_data->sticker);
        }

        if (property_exists_and_is_object($init_data, 'story')) {
            $this->story = new Story();
            $this->story->__FillPropsFromObject($init_data->story);
        }

        if (property_exists_and_is_object($init_data, 'video')) {
            $this->video = new Video();
            $this->video->__FillPropsFromObject($init_data->video);
        }

        if (property_exists_and_is_object($init_data, 'video_note')) {
            $this->video_note = new VideoNote();
            $this->video_note->__FillPropsFromObject($init_data->video_note);
        }

        if (property_exists_and_is_object($init_data, 'voice')) {
            $this->voice = new Voice();
            $this->voice->__FillPropsFromObject($init_data->voice);
        }

        if (property_exists_and_is_object($init_data, 'contact')) {
            $this->contact = new Contact();
            $this->contact->__FillPropsFromObject($init_data->contact);
        }

        if (property_exists_and_is_object($init_data, 'dice')) {
            $this->dice = new Dice();
            $this->dice->__FillPropsFromObject($init_data->dice);
        }

        if (property_exists_and_is_object($init_data, 'game')) {
            $this->game = new Game();
            $this->game->__FillPropsFromObject($init_data->game);
        }

        if (property_exists_and_is_object($init_data, 'poll')) {
            $this->poll = new Poll();
            $this->poll->__FillPropsFromObject($init_data->poll);
        }

        if (property_exists_and_is_object($init_data, 'venue')) {
            $this->venue = new Venue();
            $this->venue->__FillPropsFromObject($init_data->venue);
        }

        if (property_exists_and_is_object($init_data, 'location')) {
            $this->location = new Location();
            $this->location->__FillPropsFromObject($init_data->location);
        }

        if (property_exists_and_is_object($init_data, 'left_chat_member')) {
            $this->left_chat_member = new User();
            $this->left_chat_member->__FillPropsFromObject(
                $init_data->left_chat_member,
            );
        }

        if (
            property_exists_and_is_object(
                $init_data,
                'message_auto_delete_timer_changed',
            )
        ) {
            $this->message_auto_delete_timer_changed = new MessageAutoDeleteTimerChanged();
            $this->message_auto_delete_timer_changed->__FillPropsFromObject(
                $init_data->message_auto_delete_timer_changed,
            );
        }

        if (property_exists_and_is_object($init_data, 'pinned_message')) {
            $this->pinned_message = new Message();
            $this->pinned_message->__FillPropsFromObject(
                $init_data->pinned_message,
            );
        }

        if (property_exists_and_is_object($init_data, 'invoice')) {
            $this->invoice = new Invoice();
            $this->invoice->__FillPropsFromObject($init_data->invoice);
        }

        if (property_exists_and_is_object($init_data, 'successful_payment')) {
            $this->successful_payment = new SuccessfulPayment();
            $this->successful_payment->__FillPropsFromObject(
                $init_data->successful_payment,
            );
        }

        if (property_exists_and_is_object($init_data, 'refunded_payment')) {
            $this->refunded_payment = new RefundedPayment();
            $this->refunded_payment->__FillPropsFromObject(
                $init_data->refunded_payment,
            );
        }

        if (property_exists_and_is_object($init_data, 'users_shared')) {
            $this->users_shared = new UsersShared();
            $this->users_shared->__FillPropsFromObject(
                $init_data->users_shared,
            );
        }

        if (property_exists_and_is_object($init_data, 'chat_shared')) {
            $this->chat_shared = new ChatShared();
            $this->chat_shared->__FillPropsFromObject($init_data->chat_shared);
        }

        if (property_exists_and_is_object($init_data, 'write_access_allowed')) {
            $this->write_access_allowed = new WriteAccessAllowed();
            $this->write_access_allowed->__FillPropsFromObject(
                $init_data->write_access_allowed,
            );
        }

        if (property_exists_and_is_object($init_data, 'passport_data')) {
            $this->passport_data = new PassportData();
            $this->passport_data->__FillPropsFromObject(
                $init_data->passport_data,
            );
        }

        if (
            property_exists_and_is_object(
                $init_data,
                'proximity_alert_triggered',
            )
        ) {
            $this->proximity_alert_triggered = new ProximityAlertTriggered();
            $this->proximity_alert_triggered->__FillPropsFromObject(
                $init_data->proximity_alert_triggered,
            );
        }

        if (property_exists_and_is_object($init_data, 'boost_added')) {
            $this->boost_added = new ChatBoostAdded();
            $this->boost_added->__FillPropsFromObject($init_data->boost_added);
        }

        if (property_exists_and_is_object($init_data, 'chat_background_set')) {
            $this->chat_background_set = new ChatBackground();
            $this->chat_background_set->__FillPropsFromObject(
                $init_data->chat_background_set,
            );
        }

        if (property_exists_and_is_object($init_data, 'forum_topic_created')) {
            $this->forum_topic_created = new ForumTopicCreated();
            $this->forum_topic_created->__FillPropsFromObject(
                $init_data->forum_topic_created,
            );
        }

        if (property_exists_and_is_object($init_data, 'forum_topic_edited')) {
            $this->forum_topic_edited = new ForumTopicEdited();
            $this->forum_topic_edited->__FillPropsFromObject(
                $init_data->forum_topic_edited,
            );
        }

        if (property_exists_and_is_object($init_data, 'forum_topic_closed')) {
            $this->forum_topic_closed = new ForumTopicClosed();
            $this->forum_topic_closed->__FillPropsFromObject(
                $init_data->forum_topic_closed,
            );
        }

        if (property_exists_and_is_object($init_data, 'forum_topic_reopened')) {
            $this->forum_topic_reopened = new ForumTopicReopened();
            $this->forum_topic_reopened->__FillPropsFromObject(
                $init_data->forum_topic_reopened,
            );
        }

        if (
            property_exists_and_is_object(
                $init_data,
                'general_forum_topic_hidden',
            )
        ) {
            $this->general_forum_topic_hidden = new GeneralForumTopicHidden();
            $this->general_forum_topic_hidden->__FillPropsFromObject(
                $init_data->general_forum_topic_hidden,
            );
        }

        if (
            property_exists_and_is_object(
                $init_data,
                'general_forum_topic_unhidden',
            )
        ) {
            $this->general_forum_topic_unhidden = new GeneralForumTopicUnhidden();
            $this->general_forum_topic_unhidden->__FillPropsFromObject(
                $init_data->general_forum_topic_unhidden,
            );
        }

        if (property_exists_and_is_object($init_data, 'giveaway_created')) {
            $this->giveaway_created = new GiveawayCreated();
            $this->giveaway_created->__FillPropsFromObject(
                $init_data->giveaway_created,
            );
        }

        if (property_exists_and_is_object($init_data, 'giveaway')) {
            $this->giveaway = new Giveaway();
            $this->giveaway->__FillPropsFromObject($init_data->giveaway);
        }

        if (property_exists_and_is_object($init_data, 'giveaway_winners')) {
            $this->giveaway_winners = new GiveawayWinners();
            $this->giveaway_winners->__FillPropsFromObject(
                $init_data->giveaway_winners,
            );
        }

        if (property_exists_and_is_object($init_data, 'giveaway_completed')) {
            $this->giveaway_completed = new GiveawayCompleted();
            $this->giveaway_completed->__FillPropsFromObject(
                $init_data->giveaway_completed,
            );
        }

        if (property_exists_and_is_object($init_data, 'video_chat_scheduled')) {
            $this->video_chat_scheduled = new VideoChatScheduled();
            $this->video_chat_scheduled->__FillPropsFromObject(
                $init_data->video_chat_scheduled,
            );
        }

        if (property_exists_and_is_object($init_data, 'video_chat_started')) {
            $this->video_chat_started = new VideoChatStarted();
            $this->video_chat_started->__FillPropsFromObject(
                $init_data->video_chat_started,
            );
        }

        if (property_exists_and_is_object($init_data, 'video_chat_ended')) {
            $this->video_chat_ended = new VideoChatEnded();
            $this->video_chat_ended->__FillPropsFromObject(
                $init_data->video_chat_ended,
            );
        }

        if (
            property_exists_and_is_object(
                $init_data,
                'video_chat_participants_invited',
            )
        ) {
            $this->video_chat_participants_invited = new VideoChatParticipantsInvited();
            $this->video_chat_participants_invited->__FillPropsFromObject(
                $init_data->video_chat_participants_invited,
            );
        }

        if (property_exists_and_is_object($init_data, 'web_app_data')) {
            $this->web_app_data = new WebAppData();
            $this->web_app_data->__FillPropsFromObject(
                $init_data->web_app_data,
            );
        }

        if (property_exists_and_is_object($init_data, 'reply_markup')) {
            $this->reply_markup = new InlineKeyboardMarkup([]);
            $this->reply_markup->__FillPropsFromObject(
                $init_data->reply_markup,
            );
        }
    }
}

/**
 * This object represents a unique message identifier.
 */
class MessageId extends CustomJsonSerialization
{
    /**
     * Unique message identifier
     */
    public int $message_id;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Union type
 * This object describes a message that can be inaccessible to the bot. It can be one of Message | InaccessibleMessage
 */
interface MaybeInaccessibleMessage
{
}

/**
 * This object describes a message that was deleted or is otherwise inaccessible to the bot.
 */
class InaccessibleMessage extends CustomJsonSerialization implements
    MaybeInaccessibleMessage
{
    /**
     * Chat the message belonged to
     */
    public Chat $chat;

    /**
     * Unique message identifier inside the chat
     */
    public int $message_id;

    /**
     * Always 0. The field can be used to differentiate regular and inaccessible messages.
     */
    public int $date;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'chat')) {
            $this->chat = new Chat();
            $this->chat->__FillPropsFromObject($init_data->chat);
        }
    }
}

/**
 * This object represents one special entity in a text message. For example, hashtags, usernames, URLs, etc.
 */
class MessageEntity extends CustomJsonSerialization
{
    /**
     * Type of the entity. Currently, can be “mention” (@username), “hashtag” (#hashtag or #hashtag@chatusername), “cashtag” ($USD or $USD@chatusername), “bot_command” (/start@jobs_bot), “url” (https://telegram.org), “email” (do-not-reply@telegram.org), “phone_number” (+1-212-555-0123), “bold” (bold text), “italic” (italic text), “underline” (underlined text), “strikethrough” (strikethrough text), “spoiler” (spoiler message), “blockquote” (block quotation), “expandable_blockquote” (collapsed-by-default block quotation), “code” (monowidth string), “pre” (monowidth block), “text_link” (for clickable text URLs), “text_mention” (for users without usernames), “custom_emoji” (for inline custom emoji stickers)
     */
    public string $type;

    /**
     * Offset in UTF-16 code units to the start of the entity
     */
    public int $offset;

    /**
     * Length of the entity in UTF-16 code units
     */
    public int $length;

    /**
     * Optional. For “text_link” only, URL that will be opened after user taps on the text
     */
    public ?string $url;

    /**
     * Optional. For “text_mention” only, the mentioned user
     */
    public ?User $user;

    /**
     * Optional. For “pre” only, the programming language of the entity text
     */
    public ?string $language;

    /**
     * Optional. For “custom_emoji” only, unique identifier of the custom emoji. Use getCustomEmojiStickers to get full information about the sticker
     */
    public ?string $custom_emoji_id;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'user')) {
            $this->user = new User();
            $this->user->__FillPropsFromObject($init_data->user);
        }
    }
}

/**
 * This object contains information about the quoted part of a message that is replied to by the given message.
 */
class TextQuote extends CustomJsonSerialization
{
    /**
     * Text of the quoted part of a message that is replied to by the given message
     */
    public string $text;

    /**
     * Optional. Special entities that appear in the quote. Currently, only bold, italic, underline, strikethrough, spoiler, and custom_emoji entities are kept in quotes.
     * @var array<MessageEntity>
     */
    public ?array $entities;

    /**
     * Approximate quote position in the original message in UTF-16 code units as specified by the sender
     */
    public int $position;

    /**
     * Optional. True, if the quote was chosen manually by the message sender. Otherwise, the quote was added automatically by the server.
     */
    public ?True $is_manual = true;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object contains information about a message that is being replied to, which may come from another chat or forum topic.
 */
class ExternalReplyInfo extends CustomJsonSerialization
{
    /**
     * (MessageOrigin) Origin of the message replied to by the given message
     */
    public MessageOriginUser|MessageOriginHiddenUser|MessageOriginChat|MessageOriginChannel $origin;

    /**
     * Optional. Chat the original message belongs to. Available only if the chat is a supergroup or a channel.
     */
    public ?Chat $chat;

    /**
     * Optional. Unique message identifier inside the original chat. Available only if the original chat is a supergroup or a channel.
     */
    public ?int $message_id;

    /**
     * Optional. Options used for link preview generation for the original message, if it is a text message
     */
    public ?LinkPreviewOptions $link_preview_options;

    /**
     * Optional. Message is an animation, information about the animation
     */
    public ?Animation $animation;

    /**
     * Optional. Message is an audio file, information about the file
     */
    public ?Audio $audio;

    /**
     * Optional. Message is a general file, information about the file
     */
    public ?Document $document;

    /**
     * Optional. Message contains paid media; information about the paid media
     */
    public ?PaidMediaInfo $paid_media;

    /**
     * Optional. Message is a photo, available sizes of the photo
     * @var array<PhotoSize>
     */
    public ?array $photo;

    /**
     * Optional. Message is a sticker, information about the sticker
     */
    public ?Sticker $sticker;

    /**
     * Optional. Message is a forwarded story
     */
    public ?Story $story;

    /**
     * Optional. Message is a video, information about the video
     */
    public ?Video $video;

    /**
     * Optional. Message is a video note, information about the video message
     */
    public ?VideoNote $video_note;

    /**
     * Optional. Message is a voice message, information about the file
     */
    public ?Voice $voice;

    /**
     * Optional. True, if the message media is covered by a spoiler animation
     */
    public ?True $has_media_spoiler;

    /**
     * Optional. Message is a shared contact, information about the contact
     */
    public ?Contact $contact;

    /**
     * Optional. Message is a dice with random value
     */
    public ?Dice $dice;

    /**
     * Optional. Message is a game, information about the game. More about games »
     */
    public ?Game $game;

    /**
     * Optional. Message is a scheduled giveaway, information about the giveaway
     */
    public ?Giveaway $giveaway;

    /**
     * Optional. A giveaway with public winners was completed
     */
    public ?GiveawayWinners $giveaway_winners;

    /**
     * Optional. Message is an invoice for a payment, information about the invoice. More about payments »
     */
    public ?Invoice $invoice;

    /**
     * Optional. Message is a shared location, information about the location
     */
    public ?Location $location;

    /**
     * Optional. Message is a native poll, information about the poll
     */
    public ?Poll $poll;

    /**
     * Optional. Message is a venue, information about the venue
     */
    public ?Venue $venue;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'origin')) {
            $this->origin = choose_message_origin_subclass($init_data->origin);
            $this->origin->__FillPropsFromObject($init_data->origin);
        }

        if (property_exists_and_is_object($init_data, 'chat')) {
            $this->chat = new Chat();
            $this->chat->__FillPropsFromObject($init_data->chat);
        }

        if (property_exists_and_is_object($init_data, 'link_preview_options')) {
            $this->link_preview_options = new LinkPreviewOptions();
            $this->link_preview_options->__FillPropsFromObject(
                $init_data->link_preview_options,
            );
        }

        if (property_exists_and_is_object($init_data, 'animation')) {
            $this->animation = new Animation();
            $this->animation->__FillPropsFromObject($init_data->animation);
        }

        if (property_exists_and_is_object($init_data, 'audio')) {
            $this->audio = new Audio();
            $this->audio->__FillPropsFromObject($init_data->audio);
        }

        if (property_exists_and_is_object($init_data, 'document')) {
            $this->document = new Document();
            $this->document->__FillPropsFromObject($init_data->document);
        }

        if (property_exists_and_is_object($init_data, 'paid_media')) {
            $this->paid_media = new PaidMediaInfo();
            $this->paid_media->__FillPropsFromObject($init_data->paid_media);
        }

        if (property_exists_and_is_object($init_data, 'sticker')) {
            $this->sticker = new Sticker();
            $this->sticker->__FillPropsFromObject($init_data->sticker);
        }

        if (property_exists_and_is_object($init_data, 'story')) {
            $this->story = new Story();
            $this->story->__FillPropsFromObject($init_data->story);
        }

        if (property_exists_and_is_object($init_data, 'video')) {
            $this->video = new Video();
            $this->video->__FillPropsFromObject($init_data->video);
        }

        if (property_exists_and_is_object($init_data, 'video_note')) {
            $this->video_note = new VideoNote();
            $this->video_note->__FillPropsFromObject($init_data->video_note);
        }

        if (property_exists_and_is_object($init_data, 'voice')) {
            $this->voice = new Voice();
            $this->voice->__FillPropsFromObject($init_data->voice);
        }

        if (property_exists_and_is_object($init_data, 'contact')) {
            $this->contact = new Contact();
            $this->contact->__FillPropsFromObject($init_data->contact);
        }

        if (property_exists_and_is_object($init_data, 'dice')) {
            $this->dice = new Dice();
            $this->dice->__FillPropsFromObject($init_data->dice);
        }

        if (property_exists_and_is_object($init_data, 'game')) {
            $this->game = new Game();
            $this->game->__FillPropsFromObject($init_data->game);
        }

        if (property_exists_and_is_object($init_data, 'giveaway')) {
            $this->giveaway = new Giveaway();
            $this->giveaway->__FillPropsFromObject($init_data->giveaway);
        }

        if (property_exists_and_is_object($init_data, 'giveaway_winners')) {
            $this->giveaway_winners = new GiveawayWinners();
            $this->giveaway_winners->__FillPropsFromObject(
                $init_data->giveaway_winners,
            );
        }

        if (property_exists_and_is_object($init_data, 'invoice')) {
            $this->invoice = new Invoice();
            $this->invoice->__FillPropsFromObject($init_data->invoice);
        }

        if (property_exists_and_is_object($init_data, 'location')) {
            $this->location = new Location();
            $this->location->__FillPropsFromObject($init_data->location);
        }

        if (property_exists_and_is_object($init_data, 'poll')) {
            $this->poll = new Poll();
            $this->poll->__FillPropsFromObject($init_data->poll);
        }

        if (property_exists_and_is_object($init_data, 'venue')) {
            $this->venue = new Venue();
            $this->venue->__FillPropsFromObject($init_data->venue);
        }
    }
}

/**
 * Describes reply parameters for the message that is being sent.
 */
class ReplyParameters extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }

    // TODO: Replace statements such as 'int $quote_position = null' with '?int $quote_position' inside function declaration

    /**
     * @param int $message_id Identifier of the message that will be replied to in the current chat, or in the chat chat_id if it is specified
     * @param string|int|null $chat_id Optional. If the message to be replied to is from a different chat, unique identifier for the chat or username of the channel (in the format @channelusername). Not supported for messages sent on behalf of a business account.
     * @param ?bool $allow_sending_without_reply Optional. Pass True if the message should be sent even if the specified message to be replied to is not found. Always False for replies in another chat or forum topic. Always True for messages sent on behalf of a business account.
     * @param ?string $quote Optional. Quoted part of the message to be replied to; 0-1024 characters after entities parsing. The quote must be an exact substring of the message to be replied to, including bold, italic, underline, strikethrough, spoiler, and custom_emoji entities. The message will fail to send if the quote isn't found in the original message.
     * @param ?string $quote_parse_mode Optional. Mode for parsing entities in the quote. See formatting options for more details.
     * @param ?array<MessageEntity> $quote_entities Optional. A JSON-serialized list of special entities that appear in the quote. It can be specified instead of quote_parse_mode.
     * @param ?int $quote_position Optional. Position of the quote in the original message in UTF-16 code units
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
}

/**
 * Union type
 * This object describes the origin of a message. It can be one of MessageOriginUser | MessageOriginHiddenUser | MessageOriginChat | MessageOriginChannel
 */
interface MessageOrigin
{
}

/**
 * The message was originally sent by a known user.
 */
class MessageOriginUser extends CustomJsonSerialization implements MessageOrigin
{
    /**
     * Type of the message origin, always “user”
     */
    public string $type;

    /**
     * Date the message was sent originally in Unix time
     */
    public int $date;

    /**
     * User that sent the message originally
     */
    public User $sender_user;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'sender_user')) {
            $this->sender_user = new User();
            $this->sender_user->__FillPropsFromObject($init_data->sender_user);
        }
    }
}

/**
 * The message was originally sent by an unknown user.
 */
class MessageOriginHiddenUser extends CustomJsonSerialization implements
    MessageOrigin
{
    /**
     * Type of the message origin, always “hidden_user”
     */
    public string $type;

    /**
     * Date the message was sent originally in Unix time
     */
    public int $date;

    /**
     * Name of the user that sent the message originally
     */
    public string $sender_user_name;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * The message was originally sent on behalf of a chat to a group chat.
 */
class MessageOriginChat extends CustomJsonSerialization implements MessageOrigin
{
    /**
     * Type of the message origin, always “chat”
     */
    public string $type;

    /**
     * Date the message was sent originally in Unix time
     */
    public int $date;

    /**
     * Chat that sent the message originally
     */
    public Chat $sender_chat;

    /**
     * Optional. For messages originally sent by an anonymous chat administrator, original message author signature
     */
    public ?string $author_signature;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'sender_chat')) {
            $this->sender_chat = new Chat();
            $this->sender_chat->__FillPropsFromObject($init_data->sender_chat);
        }
    }
}

/**
 * The message was originally sent to a channel chat.
 */
class MessageOriginChannel extends CustomJsonSerialization implements
    MessageOrigin
{
    /**
     * Type of the message origin, always “chat”
     */
    public string $type;

    /**
     * Date the message was sent originally in Unix time
     */
    public int $date;

    /**
     * Channel chat to which the message was originally sent
     */
    public Chat $chat;

    /**
     * Unique message identifier inside the chat
     */
    public int $message_id;

    /**
     * Optional. Signature of the original post author
     */
    public ?string $author_signature;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'chat')) {
            $this->chat = new Chat();
            $this->chat->__FillPropsFromObject($init_data->chat);
        }
    }
}

/**
 * TODO: Implement
 * This object represents one size of a photo or a file / sticker thumbnail.
 */
#[\AllowDynamicProperties]
class PhotoSize extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * This object represents an animation file (GIF or H.264/MPEG-4 AVC video without sound).
 */
#[\AllowDynamicProperties]
class Animation extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * This object represents an audio file to be treated as music by the Telegram clients.
 */
#[\AllowDynamicProperties]
class Audio extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * This object represents a general file (as opposed to photos, voice messages and audio files).
 */
#[\AllowDynamicProperties]
class Document extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Story extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * This object represents a video file.
 */
#[\AllowDynamicProperties]
class Video extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * This object represents a video message (available in Telegram apps as of v.4.0).
 */
#[\AllowDynamicProperties]
class VideoNote extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * This object represents a voice note.
 */
#[\AllowDynamicProperties]
class Voice extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class PaidMediaInfo extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Union type
 * This object describes paid media. Currently, it can be one of PaidMediaPreview | PaidMediaPhoto | PaidMediaVideo
 */
interface PaidMedia
{
}

/**
 * The paid media isn't available before the payment.
 */
class PaidMediaPreview extends CustomJsonSerialization implements PaidMedia
{
    /**
     * Type of the paid media, always “preview”
     */
    public string $type;

    /**
     * Optional. Media width as defined by the sender
     */
    public ?int $width;

    /**
     * Optional. Media height as defined by the sender
     */
    public ?int $height;

    /**
     * Optional. Duration of the media in seconds as defined by the sender
     */
    public ?int $duration;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * The paid media is a photo.
 */
class PaidMediaPhoto extends CustomJsonSerialization implements PaidMedia
{
    /**
     * Type of the paid media, always “photo”
     */
    public string $type;

    /**
     * The photo
     * @var array<PhotoSize>
     */
    public array $photo;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * The paid media is a video.
 */
class PaidMediaVideo extends CustomJsonSerialization implements PaidMedia
{
    /**
     * Type of the paid media, always “video”
     */
    public string $type;

    /**
     * The video
     */
    public Video $video;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'video')) {
            $this->video = new Video();
            $this->video->__FillPropsFromObject($init_data->video);
        }
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Contact extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Dice extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class PollOption extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputPollOption extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents an answer of a user in a non-anonymous poll.
 */
class PollAnswer extends CustomJsonSerialization
{
    /**
     * Unique poll identifier
     */
    public string $poll_id;

    /**
     * Optional. The chat that changed the answer to the poll, if the voter is anonymous
     */
    public ?Chat $voter_chat;

    /**
     * Optional. The user that changed the answer to the poll, if the voter isn't anonymous
     */
    public User $user;

    /**
     * 0-based identifiers of chosen answer options. May be empty if the vote was retracted.
     * @var array<int>
     */
    public array $option_ids;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'voter_chat')) {
            $this->voter_chat = new Chat();
            $this->voter_chat->__FillPropsFromObject($init_data->voter_chat);
        }

        if (property_exists_and_is_object($init_data, 'user')) {
            $this->user = new User();
            $this->user->__FillPropsFromObject($init_data->user);
        }
    }
}

/**
 * This object contains information about a poll.
 */
class Poll extends CustomJsonSerialization
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
     * Optional. Special entities that appear in the question. Currently, only custom emoji entities are allowed in poll questions
     * @var array<MessageEntity>
     */
    public ?array $question_entities = null;

    /**
     * List of poll options
     * @var array<PollOption>
     */
    public array $options;

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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Location extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Venue extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class WebAppData extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ProximityAlertTriggered extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class MessageAutoDeleteTimerChanged extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatBoostAdded extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundFill extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundFillSolid extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundFillGradient extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundFillFreeformGradient extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundType extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundTypeFill extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundTypeWallpaper extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundTypePattern extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BackgroundTypeChatTheme extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatBackground extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ForumTopicCreated extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ForumTopicClosed extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ForumTopicEdited extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ForumTopicReopened extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class GeneralForumTopicHidden extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class GeneralForumTopicUnhidden extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class SharedUser extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class UsersShared extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object contains information about a chat that was shared with the bot using a KeyboardButtonRequestChat button.
 */
class ChatShared extends CustomJsonSerialization
{
    /**
     * Identifier of the request
     */
    public int $request_id;

    /**
     * Identifier of the shared chat. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. The bot may not have access to the chat and could be unable to use this identifier, unless the chat is already known to the bot by some other means.
     */
    public int $chat_id;

    /**
     * Optional. Title of the chat, if the title was requested by the bot.
     */
    public ?string $title = null;

    /**
     * Optional. Username of the chat, if the username was requested by the bot and available.
     */
    public ?string $username = null;

    /**
     * Optional. Available sizes of the chat photo, if the photo was requested by the bot
     * @var array<PhotoSize>
     */
    public ?array $photo = null;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class WriteAccessAllowed extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class VideoChatScheduled extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class VideoChatStarted extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class VideoChatEnded extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class VideoChatParticipantsInvited extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class GiveawayCreated extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Giveaway extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class GiveawayWinners extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class GiveawayCompleted extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class LinkPreviewOptions extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class UserProfilePhotos extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class File extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Describes a Web App.
 */
class WebAppInfo extends CustomJsonSerialization
{
    /**
     * An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps
     */
    public string $url;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents a custom keyboard with reply options (see Introduction to bots for details and examples). Not supported in channels and for messages sent on behalf of a Telegram Business account.
 */
class ReplyKeyboardMarkup extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }

    /**
     * @param array<array<KeyboardButton>> $keyboard Array of button rows, each represented by an Array of KeyboardButton objects
     * @param ?bool $is_persistent Optional. Requests clients to always show the keyboard when the regular keyboard is hidden. Defaults to false, in which case the custom keyboard can be hidden and opened with a keyboard icon.
     * @param ?bool $resize_keyboard Optional. Requests clients to resize the keyboard vertically for optimal fit (e.g., make the keyboard smaller if there are just two rows of buttons). Defaults to false, in which case the custom keyboard is always of the same height as the app's standard keyboard.
     * @param ?bool $one_time_keyboard Optional. Requests clients to hide the keyboard as soon as it's been used. The keyboard will still be available, but clients will automatically display the usual letter-keyboard in the chat - the user can press a special button in the input field to see the custom keyboard again. Defaults to false.
     * @param ?string $input_field_placeholder Optional. The placeholder to be shown in the input field when the keyboard is active; 1-64 characters
     * @param ?bool $selective Optional. Use this parameter if you want to show the keyboard to specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply to a message in the same chat and forum topic, sender of the original message. Example: A user requests to change the bot's language, bot replies to the request with a keyboard to select the new language. Other users in the group don't see the keyboard.
     */
    public function __construct(
        array $keyboard,
        bool $is_persistent = null,
        bool $resize_keyboard = null,
        bool $one_time_keyboard = null,
        string $input_field_placeholder = null,
        bool $selective = null,
    ) {
        parent::__construct();

        $this->keyboard = $keyboard;
        $this->is_persistent = $is_persistent;
        $this->resize_keyboard = $resize_keyboard;
        $this->one_time_keyboard = $one_time_keyboard;
        $this->input_field_placeholder = $input_field_placeholder;
        $this->selective = $selective;
    }
}

/**
 * This object represents one button of the reply keyboard. At most one of the optional fields must be used to specify type of the button. For simple text buttons, String can be used instead of this object to specify the button text.
 */
class KeyboardButton extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }

    /**
     * @param string $text Text of the button. If none of the optional fields are used, it will be sent as a message when the button is pressed
     * @param ?KeyboardButtonRequestUsers $request_users Optional. If specified, pressing the button will open a list of suitable users. Identifiers of selected users will be sent to the bot in a “users_shared” service message. Available in private chats only.
     * @param ?KeyboardButtonRequestChat $request_chat Optional. If specified, pressing the button will open a list of suitable chats. Tapping on a chat will send its identifier to the bot in a “chat_shared” service message. Available in private chats only.
     * @param ?bool $request_contact Optional. If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only.
     * @param ?bool $request_location Optional. If True, the user's current location will be sent when the button is pressed. Available in private chats only.
     * @param ?KeyboardButtonPollType $request_poll Optional. If specified, the user will be asked to create a poll and send it to the bot when the button is pressed. Available in private chats only.
     * @param ?WebAppInfo $web_app Optional. If specified, the described Web App will be launched when the button is pressed. The Web App will be able to send a “web_app_data” service message. Available in private chats only.
     */
    public function __construct(
        string $text,
        KeyboardButtonRequestUsers $request_users = null,
        KeyboardButtonRequestChat $request_chat = null,
        bool $request_contact = null,
        bool $request_location = null,
        KeyboardButtonPollType $request_poll = null,
        WebAppInfo $web_app = null,
    ) {
        parent::__construct();

        $this->text = $text;
        $this->request_users = $request_users;
        $this->request_chat = $request_chat;
        $this->request_contact = $request_contact;
        $this->request_location = $request_location;
        $this->request_poll = $request_poll;
        $this->web_app = $web_app;
    }
}

/**
 * This object defines the criteria used to request suitable users. Information about the selected users will be shared with the bot when the corresponding button is pressed. More about requesting users »
 */
class KeyboardButtonRequestUsers extends CustomJsonSerialization
{
    /**
     * Signed 32-bit identifier of the request that will be received back in the UsersShared object. Must be unique within the message
     */
    public int $request_id;

    /**
     * Optional. Pass True to request bots, pass False to request regular users. If not specified, no additional restrictions are applied.
     */
    public ?bool $user_is_bot;

    /**
     * Optional. Pass True to request premium users, pass False to request non-premium users. If not specified, no additional restrictions are applied.
     */
    public ?bool $user_is_premium;

    /**
     * Optional. The maximum number of users to be selected; 1-10. Defaults to 1.
     */
    public ?int $max_quantity;

    /**
     * Optional. Pass True to request the users' first and last names
     */
    public ?bool $request_name;

    /**
     * Optional. Pass True to request the users' usernames
     */
    public ?bool $request_username;

    /**
     * Optional. Pass True to request the users' photos
     */
    public ?bool $request_photo;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object defines the criteria used to request a suitable chat. Information about the selected chat will be shared with the bot when the corresponding button is pressed. The bot will be granted requested rights in the chat if appropriate. More about requesting chats ».
 */
class KeyboardButtonRequestChat extends CustomJsonSerialization
{
    /**
     * Signed 32-bit identifier of the request, which will be received back in the ChatShared object. Must be unique within the message
     */
    public int $request_id;

    /**
     * Pass True to request a channel chat, pass False to request a group or a supergroup chat.
     */
    public ?bool $chat_is_channel = null;

    /**
     * Optional. Pass True to request a forum supergroup, pass False to request a non-forum chat. If not specified, no additional restrictions are applied.
     */
    public ?bool $chat_is_forum = null;

    /**
     * Optional. Pass True to request a supergroup or a channel with a username, pass False to request a chat without a username. If not specified, no additional restrictions are applied.
     */
    public ?bool $chat_has_username = null;

    /**
     * Optional. Pass True to request a chat owned by the user. Otherwise, no additional restrictions are applied.
     */
    public ?bool $chat_is_created = null;

    /**
     * Optional. A JSON-serialized object listing the required administrator rights of the user in the chat. The rights must be a superset of bot_administrator_rights. If not specified, no additional restrictions are applied.
     */
    public ?ChatAdministratorRights $user_administrator_rights = null;

    /**
     * Optional. A JSON-serialized object listing the required administrator rights of the bot in the chat. The rights must be a subset of user_administrator_rights. If not specified, no additional restrictions are applied.
     */
    public ?ChatAdministratorRights $bot_administrator_rights = null;

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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (
            property_exists_and_is_object(
                $init_data,
                'user_administrator_rights',
            )
        ) {
            $this->user_administrator_rights = new ChatAdministratorRights();
            $this->user_administrator_rights->__FillPropsFromObject(
                $init_data->user_administrator_rights,
            );
        }

        if (
            property_exists_and_is_object(
                $init_data,
                'bot_administrator_rights',
            )
        ) {
            $this->bot_administrator_rights = new ChatAdministratorRights();
            $this->bot_administrator_rights->__FillPropsFromObject(
                $init_data->bot_administrator_rights,
            );
        }
    }

    /**
     * TODO: Add Docs
     * @param int $request_id
     * @param ?bool $chat_is_channel
     * @param ?bool $chat_is_forum
     * @param ?bool $chat_has_username
     * @param ?bool $chat_is_created
     * @param ?ChatAdministratorRights $user_administrator_rights
     * @param ?ChatAdministratorRights $bot_administrator_rights
     * @param ?bool $bot_is_member
     * @param ?bool $request_title
     * @param ?bool $request_username
     * @param ?bool $request_photo
     */
    public function __construct(
        int $request_id,
        bool $chat_is_channel = null,
        bool $chat_is_forum = null,
        bool $chat_has_username = null,
        bool $chat_is_created = null,
        ChatAdministratorRights $user_administrator_rights = null,
        ChatAdministratorRights $bot_administrator_rights = null,
        bool $bot_is_member = null,
        bool $request_title = null,
        bool $request_username = null,
        bool $request_photo = null,
    ) {
        $this->request_id = $request_id;
        $this->chat_is_channel = $chat_is_channel;
        $this->chat_is_forum = $chat_is_forum;
        $this->chat_has_username = $chat_has_username;
        $this->chat_is_created = $chat_is_created;
        $this->user_administrator_rights = $user_administrator_rights;
        $this->bot_administrator_rights = $bot_administrator_rights;
        $this->bot_is_member = $bot_is_member;
        $this->request_title = $request_title;
        $this->request_username = $request_username;
        $this->request_photo = $request_photo;
    }
}

/**
 * This object represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
 */
class KeyboardButtonPollType extends CustomJsonSerialization
{
    /**
     * Optional. If quiz is passed, the user will be allowed to create only polls in the quiz mode. If regular is passed, only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type.
     */
    public string $type;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Upon receiving a message with this object, Telegram clients will remove the current custom keyboard and display the default letter-keyboard. By default, custom keyboards are displayed until a new keyboard is sent by a bot. An exception is made for one-time keyboards that are hidden immediately after the user presses a button (see ReplyKeyboardMarkup). Not supported in channels and for messages sent on behalf of a Telegram Business account.
 */
class ReplyKeyboardRemove extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }

    /**
     * @param true $remove_keyboard Requests clients to remove the custom keyboard (user will not be able to summon this keyboard; if you want to hide the keyboard from sight but keep it accessible, use one_time_keyboard in ReplyKeyboardMarkup)
     * @param ?bool $selective Optional. Use this parameter if you want to remove the keyboard for specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply to a message in the same chat and forum topic, sender of the original message. Example: A user votes in a poll, bot returns confirmation message in reply to the vote and removes the keyboard for that user, while still showing the keyboard with poll options to users who haven't voted yet.
     */
    public function __construct(true $remove_keyboard, bool $selective = null)
    {
        $this->remove_keyboard = $remove_keyboard;
        $this->selective = $selective;
    }
}

/**
 * This object represents an inline keyboard that appears right next to the message it belongs to.
 */
class InlineKeyboardMarkup extends CustomJsonSerialization
{
    /**
     * Array of button rows, each represented by an Array of InlineKeyboardButton objects
     * * @var array<array<InlineKeyboardButton>>
     */
    public array $inline_keyboard;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }

    /**
     * @param array<array<InlineKeyboardButton>> $inline_keyboard Array of button rows, each represented by an Array of InlineKeyboardButton objects
     */
    public function __construct(array $inline_keyboard)
    {
        $this->inline_keyboard = $inline_keyboard;
    }
}

/**
 * This object represents one button of an inline keyboard. Exactly one of the optional fields must be used to specify type of the button.
 */
class InlineKeyboardButton extends CustomJsonSerialization
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

    /**
     * Optional. Description of the Web App that will be launched when the user presses the button. The Web App will be able to send an arbitrary message on behalf of the user using the method answerWebAppQuery. Available only in private chats between a user and the bot. Not supported for messages sent on behalf of a Telegram Business account.
     */
    public ?WebAppInfo $web_app = null;

    /**
     * Optional. An HTTPS URL used to automatically authorize the user. Can be used as a replacement for the Telegram Login Widget.
     */
    public ?LoginUrl $login_url = null;

    /**
     * Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot's username and the specified inline query in the input field. May be empty, in which case just the bot's username will be inserted. Not supported for messages sent on behalf of a Telegram Business account.
     */
    public ?string $switch_inline_query = null;

    /**
     * Optional. If set, pressing the button will insert the bot's username and the specified inline query in the current chat's input field. May be empty, in which case only the bot's username will be inserted.
     * This offers a quick way for the user to open your bot in inline mode in the same chat - good for selecting something from multiple options. Not supported in channels and for messages sent on behalf of a Telegram Business account.
     */
    public ?string $switch_inline_query_current_chat = null;

    /**
     * Optional. If set, pressing the button will prompt the user to select one of their chats of the specified type, open that chat and insert the bot's username and the specified inline query in the input field. Not supported for messages sent on behalf of a Telegram Business account.
     */
    public ?SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat = null;

    /**
     * Optional. Description of the button that copies the specified text to the clipboard.
     */
    public ?CopyTextButton $copy_text = null;

    /**
     * Optional. Description of the game that will be launched when the user presses the button.
     * NOTE: This type of button must always be the first button in the first row.
     */
    public ?CallbackGame $callback_game = null;

    /**
     * Optional. Specify True, to send a Pay button. Substrings “⭐” and “XTR” in the buttons's text will be replaced with a Telegram Star icon.
     * NOTE: This type of button must always be the first button in the first row and can only be used in invoice messages.
     */
    public ?bool $pay = null;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'web_app')) {
            $this->web_app = new WebAppInfo();
            $this->web_app->__FillPropsFromObject($init_data->web_app);
        }

        if (property_exists_and_is_object($init_data, 'login_url')) {
            $this->login_url = new LoginUrl();
            $this->login_url->__FillPropsFromObject($init_data->login_url);
        }

        if (
            property_exists_and_is_object(
                $init_data,
                'switch_inline_query_chosen_chat',
            )
        ) {
            $this->switch_inline_query_chosen_chat = new SwitchInlineQueryChosenChat();
            $this->switch_inline_query_chosen_chat->__FillPropsFromObject(
                $init_data->switch_inline_query_chosen_chat,
            );
        }

        if (property_exists_and_is_object($init_data, 'copy_text')) {
            $this->copy_text = new CopyTextButton();
            $this->copy_text->__FillPropsFromObject($init_data->copy_text);
        }

        if (property_exists_and_is_object($init_data, 'callback_game')) {
            $this->callback_game = new CallbackGame();
            $this->callback_game->__FillPropsFromObject(
                $init_data->callback_game,
            );
        }
    }

    /**
     * TODO: Add Docs
     * @param string $text
     * @param ?string $url
     * @param ?string $callback_data
     * @param WebAppInfo $web_app
     * @param LoginUrl $login_url
     * @param ?string $switch_inline_query
     * @param ?string $switch_inline_query_current_chat
     * @param SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat
     * @param CopyTextButton $copy_text
     * @param CallbackGame $callback_game
     */
    public function __construct(
        string $text,
        string $url = null,
        string $callback_data = null,
        WebAppInfo $web_app = null,
        LoginUrl $login_url = null,
        string $switch_inline_query = null,
        string $switch_inline_query_current_chat = null,
        SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat = null,
        CopyTextButton $copy_text = null,
        CallbackGame $callback_game = null,
    ) {
        $this->text = $text;
        $this->url = $url;
        $this->callback_data = $callback_data;
        $this->web_app = $web_app;
        $this->login_url = $login_url;
        $this->switch_inline_query = $switch_inline_query;
        $this->switch_inline_query_current_chat = $switch_inline_query_current_chat;
        $this->switch_inline_query_chosen_chat = $switch_inline_query_chosen_chat;
        $this->copy_text = $copy_text;
        $this->callback_game = $callback_game;
    }
}

/**
 * This object represents a parameter of the inline keyboard button used to automatically authorize a user. Serves as a great replacement for the Telegram Login Widget when the user is coming from Telegram. All the user needs to do is tap/click a button and confirm that they want to log in:
 * Telegram apps support these buttons as of version 5.7.
 * Sample bot: @discussbot
 */
class LoginUrl extends CustomJsonSerialization
{
    /**
     * An HTTPS URL to be opened with user authorization data added to the query string when the button is pressed. If the user refuses to provide authorization data, the original URL without information about the user will be opened. The data added is the same as described in Receiving authorization data.
     * NOTE: You must always check the hash of the received data to verify the authentication and the integrity of the data as described in Checking authorization.
     */
    public string $url;

    /**
     * Optional. New text of the button in forwarded messages.
     */
    public ?string $forward_text;

    /**
     * Optional. Username of a bot, which will be used for user authorization. See Setting up a bot for more details. If not specified, the current bot's username will be assumed. The url's domain must be the same as the domain linked with the bot. See Linking your domain to the bot for more details.
     */
    public ?string $bot_username;

    /**
     * Optional. Pass True to request the permission for your bot to send messages to the user.
     */
    public ?bool $request_write_access;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents an inline button that switches the current user to inline mode in a chosen chat, with an optional default inline query.
 */
class SwitchInlineQueryChosenChat extends CustomJsonSerialization
{
    /**
     * Optional. The default inline query to be inserted in the input field. If left empty, only the bot's username will be inserted
     */
    public ?string $query;

    /**
     * Optional. True, if private chats with users can be chosen
     */
    public ?bool $allow_user_chats;

    /**
     * Optional. True, if private chats with bots can be chosen
     */
    public ?bool $allow_bot_chats;

    /**
     * Optional. True, if group and supergroup chats can be chosen
     */
    public ?bool $allow_group_chats;

    /**
     * Optional. True, if channel chats can be chosen
     */
    public ?bool $allow_channel_chats;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents an inline keyboard button that copies specified text to the clipboard.
 */
class CopyTextButton extends CustomJsonSerialization
{
    /**
     * The text to be copied to the clipboard; 1-256 characters
     */
    public string $text;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents an incoming callback query from a callback button in an inline keyboard. If the button that originated the query was attached to a message sent by the bot, the field message will be present. If the button was attached to a message sent via the bot (in inline mode), the field inline_message_id will be present. Exactly one of the fields data or game_short_name will be present.
 */
class CallbackQuery extends CustomJsonSerialization
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
     * (MaybeInaccessibleMessage) Optional. Message with the callback button that originated the query. Note that message content and message date will not be available if the message is too old
     */
    public Message|InaccessibleMessage|null $message = null;

    /**
     * Optional. Identifier of the message sent via the bot in inline mode, that originated the query.
     */
    public ?string $inline_message_id = null;

    /**
     * Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent. Useful for high scores in games.
     */
    public string $chat_instance;

    /**
     * Optional. Data associated with the callback button. Be aware that the message originated the query can contain no callback buttons with this data.
     */
    public ?string $data = null;

    /**
     * Optional. Short name of a Game to be returned, serves as the unique identifier for the game
     */
    public ?string $game_short_name = null;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }

        if (property_exists_and_is_object($init_data, 'message')) {
            if ($init_data->message->date == 0) {
                $this->message = new InaccessibleMessage();
            } else {
                $this->message = new Message();
            }
            $this->message->__FillPropsFromObject($init_data->message);
        }
    }
}

/**
 * Upon receiving a message with this object, Telegram clients will display a reply interface to the user (act as if the user has selected the bot's message and tapped 'Reply'). This can be extremely useful if you want to create user-friendly step-by-step interfaces without having to sacrifice privacy mode. Not supported in channels and for messages sent on behalf of a Telegram Business account.
 */
class ForceReply extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatPhoto extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatInviteLink extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatAdministratorRights extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents changes in the status of a chat member.
 */
class ChatMemberUpdated extends CustomJsonSerialization
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
    public ChatMemberOwner|ChatMemberAdministrator|ChatMemberMember|ChatMemberRestricted|ChatMemberLeft|ChatMemberBanned $old_chat_member;

    /**
     * New information about the chat member
     */
    public ChatMemberOwner|ChatMemberAdministrator|ChatMemberMember|ChatMemberRestricted|ChatMemberLeft|ChatMemberBanned $new_chat_member;

    /**
     * Optional. Chat invite link, which was used by the user to join the chat for joining by invite link events only.
     */
    public ?ChatInviteLink $invite_link = null;

    /**
     * Optional. True, if the user joined the chat after sending a direct join request without using an invite link and being approved by an administrator
     */
    public ?bool $via_join_request = null;

    /**
     * Optional. True, if the user joined the chat via a chat folder invite link
     */
    public ?bool $via_chat_folder_invite_link = null;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'chat')) {
            $this->chat = new Chat();
            $this->chat->__FillPropsFromObject($init_data->chat);
        }

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }

        if (property_exists_and_is_object($init_data, 'old_chat_member')) {
            $this->old_chat_member = choose_chat_member_subclass(
                $init_data->old_chat_member,
            );
            $this->old_chat_member->__FillPropsFromObject(
                $init_data->old_chat_member,
            );
        }

        if (property_exists_and_is_object($init_data, 'new_chat_member')) {
            $this->new_chat_member = choose_chat_member_subclass(
                $init_data->new_chat_member,
            );
            $this->new_chat_member->__FillPropsFromObject(
                $init_data->new_chat_member,
            );
        }

        if (property_exists_and_is_object($init_data, 'invite_link')) {
            $this->invite_link = new ChatInviteLink();
            $this->invite_link->__FillPropsFromObject($init_data->invite_link);
        }
    }
}

/**
 * Union type
 * This object contains information about one member of a chat. Currently, the following 6 types of chat members are supported: ChatMemberOwner | ChatMemberAdministrator | ChatMemberMember | ChatMemberRestricted | ChatMemberLeft | ChatMemberBanned
 */
interface ChatMember
{
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatMemberOwner extends CustomJsonSerialization implements ChatMember
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatMemberAdministrator extends CustomJsonSerialization implements
    ChatMember
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatMemberMember extends CustomJsonSerialization implements ChatMember
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatMemberRestricted extends CustomJsonSerialization implements ChatMember
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatMemberLeft extends CustomJsonSerialization implements ChatMember
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatMemberBanned extends CustomJsonSerialization implements ChatMember
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Represents a join request sent to a chat.
 */
class ChatJoinRequest extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'chat')) {
            $this->chat = new Chat();
            $this->chat->__FillPropsFromObject($init_data->chat);
        }

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }

        if (property_exists_and_is_object($init_data, 'invite_link')) {
            $this->invite_link = new ChatInviteLink();
            $this->invite_link->__FillPropsFromObject($init_data->invite_link);
        }
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatPermissions extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Birthdate extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BusinessIntro extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BusinessLocation extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BusinessOpeningHoursInterval extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class BusinessOpeningHours extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatLocation extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Union type
 * This object describes the type of a reaction. Currently, it can be one of ReactionTypeEmoji | ReactionTypeCustomEmoji | ReactionTypePaid
 */
interface ReactionType
{
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ReactionTypeEmoji extends CustomJsonSerialization implements ReactionType
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ReactionTypeCustomEmoji extends CustomJsonSerialization implements
    ReactionType
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ReactionTypePaid extends CustomJsonSerialization implements ReactionType
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ReactionCount extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class MessageReactionUpdated extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class MessageReactionCountUpdated extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ForumTopic extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents a bot command.
 */
class BotCommand extends CustomJsonSerialization
{
    /**
     * Text of the command; 1-32 characters. Can contain only lowercase English letters, digits and underscores.
     */
    public string $command;

    /**
     * Description of the command; 1-256 characters.
     */
    public string $description;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Union type
 * This object represents the scope to which bot commands are applied. Currently, the following 7 scopes are supported: BotCommandScopeDefault | BotCommandScopeAllPrivateChats | BotCommandScopeAllGroupChats | BotCommandScopeAllChatAdministrators | BotCommandScopeChat | BotCommandScopeChatAdministrators | BotCommandScopeChatMember
 */
interface BotCommandScope
{
}

/**
 * Represents the default scope of bot commands. Default commands are used if no commands with a narrower scope are specified for the user.
 */
class BotCommandScopeDefault extends CustomJsonSerialization implements
    BotCommandScope
{
    /**
     * Scope type, must be default
     */
    public string $type = 'default';
}

/**
 * Represents the scope of bot commands, covering all private chats.
 */
class BotCommandScopeAllPrivateChats extends CustomJsonSerialization implements
    BotCommandScope
{
    /**
     * Scope type, must be all_private_chats
     */
    public string $type = 'all_private_chats';
}

/**
 * Represents the scope of bot commands, covering all group and supergroup chats.
 */
class BotCommandScopeAllGroupChats extends CustomJsonSerialization implements
    BotCommandScope
{
    /**
     * Scope type, must be all_group_chats
     */
    public string $type = 'all_group_chats';
}

/**
 * Represents the scope of bot commands, covering all group and supergroup chat administrators.
 */
class BotCommandScopeAllChatAdministrators
    extends CustomJsonSerialization
    implements BotCommandScope
{
    /**
     * Scope type, must be all_chat_administrators
     */
    public string $type = 'all_chat_administrators';
}

/**
 * Represents the scope of bot commands, covering a specific chat.
 */
class BotCommandScopeChat extends CustomJsonSerialization implements
    BotCommandScope
{
    /**
     * Scope type, must be chat
     */
    public string $type = 'chat';

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     */
    public string|int $chat_id;
}

/**
 * Represents the scope of bot commands, covering all administrators of a specific group or supergroup chat.
 */
class BotCommandScopeChatAdministrators
    extends CustomJsonSerialization
    implements BotCommandScope
{
    /**
     * Scope type, must be chat_administrators
     */
    public string $type = 'chat_administrators';

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     */
    public string|int $chat_id;
}

/**
 * Represents the scope of bot commands, covering a specific member of a group or supergroup chat.
 */
class BotCommandScopeChatMember extends CustomJsonSerialization implements
    BotCommandScope
{
    /**
     * Scope type, must be chat_member
     */
    public string $type = 'chat_member';

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
class BotName extends CustomJsonSerialization
{
    /**
     * The bot's name
     */
    public string $name;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents the bot's description.
 */
class BotDescription extends CustomJsonSerialization
{
    /**
     * The bot's description
     */
    public string $description;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents the bot's short description.
 */
class BotShortDescription extends CustomJsonSerialization
{
    /**
     * The bot's short description
     */
    public ?string $short_description;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Union type
 * This object describes the bot's menu button in a private chat. It should be one of MenuButtonCommands | MenuButtonWebApp | MenuButtonDefault
 * If a menu button other than MenuButtonDefault is set for a private chat, then it is applied in the chat. Otherwise the default menu button is applied. By default, the menu button opens the list of bot commands.
 */
interface MenuButton
{
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class MenuButtonCommands extends CustomJsonSerialization implements MenuButton
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class MenuButtonWebApp extends CustomJsonSerialization implements MenuButton
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class MenuButtonDefault extends CustomJsonSerialization implements MenuButton
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Union type
 * This object describes the source of a chat boost. It can be one of ChatBoostSourcePremium | ChatBoostSourceGiftCode | ChatBoostSourceGiveaway
 */
interface ChatBoostSource
{
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatBoostSourcePremium extends CustomJsonSerialization implements
    ChatBoostSource
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatBoostSourceGiftCode extends CustomJsonSerialization implements
    ChatBoostSource
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatBoostSourceGiveaway extends CustomJsonSerialization implements
    ChatBoostSource
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatBoost extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatBoostUpdated extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ChatBoostRemoved extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class UserChatBoosts extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Describes the connection of the bot with a business account.
 */
class BusinessConnection extends CustomJsonSerialization
{
    /**
     * Unique identifier of the business connection
     */
    public string $id;

    /**
     * Business account user that created the business connection
     */
    public User $user;

    /**
     * Identifier of a private chat with the user who created the business connection. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public int $user_chat_id;

    /**
     * Date the connection was established in Unix time
     */
    public int $date;

    /**
     * True, if the bot can act on behalf of the business account in chats that were active in the last 24 hours
     */
    public bool $can_reply;

    /**
     * True, if the connection is active
     */
    public bool $is_enabled;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'user')) {
            $this->user = new User();
            $this->user->__FillPropsFromObject($init_data->user);
        }
    }
}

/**
 * This object is received when messages are deleted from a connected business account.
 */
class BusinessMessagesDeleted extends CustomJsonSerialization
{
    /**
     * Unique identifier of the business connection
     */
    public string $business_connection_id;

    /**
     * Information about a chat in the business account. The bot may not have access to the chat or the corresponding user.
     */
    public Chat $chat;

    /**
     * The list of identifiers of deleted messages in the chat of the business account
     * @var array<int>
     */
    public array $message_ids;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'chat')) {
            $this->chat = new Chat();
            $this->chat->__FillPropsFromObject($init_data->chat);
        }
    }
}

/**
 * Describes why a request was unsuccessful.
 */
#[\AllowDynamicProperties]
class ResponseParameters extends CustomJsonSerialization
{
    /**
     * Optional. The group has been migrated to a supergroup with the specified identifier. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public ?int $migrate_to_chat_id;

    /**
     * Optional. In case of exceeding flood control, the number of seconds left to wait before the request can be repeated
     */
    public ?int $retry_after;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Union type
 * This object represents the content of a media message to be sent. It should be one of InputMediaAnimation | InputMediaDocument | InputMediaAudio | InputMediaPhoto | InputMediaVideo
 */
interface InputMedia
{
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputMediaPhoto extends CustomJsonSerialization implements InputMedia
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputMediaVideo extends CustomJsonSerialization implements InputMedia
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputMediaAnimation extends CustomJsonSerialization implements InputMedia
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputMediaAudio extends CustomJsonSerialization implements InputMedia
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputMediaDocument extends CustomJsonSerialization implements InputMedia
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object represents the contents of a file to be uploaded. Must be posted using multipart/form-data in the usual way that files are uploaded via the browser.
 */
class InputFile extends CustomJsonSerialization
{
    // TODO: Check if file exists and is less than 10 MBs (for photos) / 50 MBs (for documents)

    public string $_path;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }

    /**
     * @param string $_path Path to the file
     */
    public function __construct(string $_path)
    {
        $this->_path = $_path;
    }
}

/**
 * Union type
 * This object describes the paid media to be sent. Currently, it can be one of InputPaidMediaPhoto | InputPaidMediaVideo
 */
interface InputPaidMedia
{
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputPaidMediaPhoto extends CustomJsonSerialization implements
    InputPaidMedia
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputPaidMediaVideo extends CustomJsonSerialization implements
    InputPaidMedia
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

// -------------------------------------------------------------------

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Sticker extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class StickerSet extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class MaskPosition extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputSticker extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

// -------------------------------------------------------------------

/**
 * This object represents an incoming inline query. When the user sends an empty query, your bot could return some default or trending results.
 */
class InlineQuery extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }

        if (property_exists_and_is_object($init_data, 'location')) {
            $this->location = new Location();
            $this->location->__FillPropsFromObject($init_data->location);
        }
    }
}

/**
 * This object represents a button to be shown above inline query results. You must use exactly one of the optional fields.
 */
class InlineQueryResultsButton extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'web_app')) {
            $this->web_app = new WebAppInfo();
            $this->web_app->__FillPropsFromObject($init_data->web_app);
        }
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultArticle extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultPhoto extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultGif extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultMpeg4Gif extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultVideo extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultAudio extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultVoice extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultDocument extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultLocation extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultVenue extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultContact extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultGame extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultCachedPhoto extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultCachedGif extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultCachedMpeg4Gif extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultCachedSticker extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultCachedDocument extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultCachedVideo extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultCachedVoice extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InlineQueryResultCachedAudio extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputTextMessageContent extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputLocationMessageContent extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputVenueMessageContent extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputContactMessageContent extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class InputInvoiceMessageContent extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * Represents a result of an inline query that was chosen by the user and sent to their chat partner.
 */
class ChosenInlineResult extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }

        if (property_exists_and_is_object($init_data, 'location')) {
            $this->location = new Location();
            $this->location->__FillPropsFromObject($init_data->location);
        }
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class SentWebAppMessage extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

// -------------------------------------------------------------------

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class LabeledPrice extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class Invoice extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ShippingAddress extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class OrderInfo extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class ShippingOption extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class SuccessfulPayment extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class RefundedPayment extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * This object contains information about an incoming shipping query.
 */
class ShippingQuery extends CustomJsonSerialization
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }

        if (property_exists_and_is_object($init_data, 'shipping_address')) {
            $this->shipping_address = new ShippingAddress();
            $this->shipping_address->__FillPropsFromObject(
                $init_data->shipping_address,
            );
        }
    }
}

/**
 * This object contains information about an incoming pre-checkout query.
 */
class PreCheckoutQuery extends CustomJsonSerialization
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
     * Three-letter ISO 4217 currency code, or “XTR” for payments in Telegram Stars
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

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }

        if (property_exists_and_is_object($init_data, 'order_info')) {
            $this->order_info = new OrderInfo();
            $this->order_info->__FillPropsFromObject($init_data->order_info);
        }
    }
}

/**
 * This object contains information about a paid media purchase.
 */
class PaidMediaPurchased extends CustomJsonSerialization
{
    /**
     * User who purchased the media
     */
    public User $from;

    /**
     * Bot-specified paid media payload
     */
    public string $paid_media_payload;

    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);

        if (property_exists_and_is_object($init_data, 'from')) {
            $this->from = new User();
            $this->from->__FillPropsFromObject($init_data->from);
        }
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class RevenueWithdrawalStatePending extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class RevenueWithdrawalStateSucceeded extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class RevenueWithdrawalStateFailed extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class TransactionPartnerUser extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class TransactionPartnerFragment extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class TransactionPartnerTelegramAds extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class TransactionPartnerTelegramApi extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class TransactionPartnerOther extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class StarTransaction extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 */
#[\AllowDynamicProperties]
class StarTransactions extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

// -------------------------------------------------------------------

/**
 * TODO: Implement
 * Describes Telegram Passport data shared with the bot by the user.
 */
#[\AllowDynamicProperties]
class PassportData extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * This object represents a file uploaded to Telegram Passport. Currently all Telegram Passport files are in JPEG format when decrypted and don't exceed 10MB.
 */
#[\AllowDynamicProperties]
class PassportFile extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Describes documents or other Telegram Passport elements shared with the bot by the user.
 */
#[\AllowDynamicProperties]
class EncryptedPassportElement extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Describes data required for decrypting and authenticating EncryptedPassportElement. See the Telegram Passport Documentation for a complete description of the data decryption and authentication processes.
 */
#[\AllowDynamicProperties]
class EncryptedCredentials extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue in one of the data fields that was provided by the user. The error is considered resolved when the field's value changes.
 */
#[\AllowDynamicProperties]
class PassportElementErrorDataField extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue with the front side of a document. The error is considered resolved when the file with the front side of the document changes.
 */
#[\AllowDynamicProperties]
class PassportElementErrorFrontSide extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue with the reverse side of a document. The error is considered resolved when the file with reverse side of the document changes.
 */
#[\AllowDynamicProperties]
class PassportElementErrorReverseSide extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue with the selfie with a document. The error is considered resolved when the file with the selfie changes.
 */
#[\AllowDynamicProperties]
class PassportElementErrorSelfie extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue with a document scan. The error is considered resolved when the file with the document scan changes.
 */
#[\AllowDynamicProperties]
class PassportElementErrorFile extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue with a list of scans. The error is considered resolved when the list of files containing the scans changes.
 */
#[\AllowDynamicProperties]
class PassportElementErrorFiles extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue with one of the files that constitute the translation of a document. The error is considered resolved when the file changes.
 */
#[\AllowDynamicProperties]
class PassportElementErrorTranslationFile extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue with the translated version of a document. The error is considered resolved when a file with the document translation change.
 */
#[\AllowDynamicProperties]
class PassportElementErrorTranslationFiles extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * Represents an issue in an unspecified place. The error is considered resolved when new data is added.
 */
#[\AllowDynamicProperties]
class PassportElementErrorUnspecified extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

// -------------------------------------------------------------------

/**
 * TODO: Implement
 * This object represents a game. Use BotFather to create and edit games, their short names will act as unique identifiers.
 */
#[\AllowDynamicProperties]
class Game extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * A placeholder, currently holds no information. Use BotFather to set up your game.
 */
#[\AllowDynamicProperties]
class CallbackGame extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}

/**
 * TODO: Implement
 * This object represents one row of the high scores table for a game.
 */
#[\AllowDynamicProperties]
class GameHighScore extends CustomJsonSerialization
{
    public function __FillPropsFromObject(object $init_data)
    {
        parent::__FillPropsFromObject($init_data);
    }
}
