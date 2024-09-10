<?php

// TODO: Replace bool type declaration with true if needed
// TODO: Replace ?array type declaration with ...

define('LITEGRAM_BOT_API_VERSION', '7.10');
define('LITEGRAM_VERSION', '0.2.1');

require_once 'litegram.php';

/**
 * This object represents an incoming update.
 * At most one of the optional parameters can be present in any given update.
 */
class Update
{
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
    public ?BusinessMessageDeleted $deleted_business_message = null;

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

    public function __construct($init_data)
    {
        if (is_object($init_data)) {
            if (property_exists($init_data, 'update_id')) {
                $this->update_id = $init_data->update_id;
            }

            if (property_exists($init_data, 'message')) {
                $this->message = new Message($init_data->message);
            }

            if (property_exists($init_data, 'edited_message')) {
                $this->edited_message = new Message($init_data->edited_message);
            }

            if (property_exists($init_data, 'channel_post')) {
                $this->channel_post = new Message($init_data->channel_post);
            }

            if (property_exists($init_data, 'edited_channel_post')) {
                $this->edited_channel_post = new Message(
                    $init_data->edited_channel_post,
                );
            }

            if (property_exists($init_data, 'business_connection')) {
                $this->business_connection = new BusinessConnection(
                    $init_data->business_connection,
                );
            }

            if (property_exists($init_data, 'business_message')) {
                $this->business_message = new Message(
                    $init_data->business_message,
                );
            }

            if (property_exists($init_data, 'edited_business_message')) {
                $this->edited_business_message = new Message(
                    $init_data->edited_business_message,
                );
            }

            if (property_exists($init_data, 'deleted_business_message')) {
                $this->deleted_business_message = new BusinessMessageDeleted(
                    $init_data->deleted_business_message,
                );
            }

            if (property_exists($init_data, 'message_reaction')) {
                $this->message_reaction = new MessageReactionUpdated(
                    $init_data->message_reaction,
                );
            }

            if (property_exists($init_data, 'message_reaction_count')) {
                $this->message_reaction_count = new MessageReactionCountUpdated(
                    $init_data->message_reaction_count,
                );
            }

            if (property_exists($init_data, 'inline_query')) {
                $this->inline_query = new InlineQuery($init_data->inline_query);
            }

            if (property_exists($init_data, 'chosen_inline_result')) {
                $this->chosen_inline_result = new ChosenInlineResult(
                    $init_data->chosen_inline_result,
                );
            }

            if (property_exists($init_data, 'callback_query')) {
                $this->callback_query = new CallbackQuery(
                    $init_data->callback_query,
                );
            }

            if (property_exists($init_data, 'shipping_query')) {
                $this->shipping_query = new ShippingQuery(
                    $init_data->shipping_query,
                );
            }

            if (property_exists($init_data, 'pre_checkout_query')) {
                $this->pre_checkout_query = new PreCheckoutQuery(
                    $init_data->pre_checkout_query,
                );
            }

            if (property_exists($init_data, 'purchased_paid_media')) {
                $this->purchased_paid_media = new PaidMediaPurchased(
                    $init_data->purchased_paid_media,
                );
            }

            if (property_exists($init_data, 'poll')) {
                $this->poll = new Poll($init_data->poll);
            }

            if (property_exists($init_data, 'poll_answer')) {
                $this->poll_answer = new PollAnswer($init_data->poll_answer);
            }

            if (property_exists($init_data, 'my_chat_member')) {
                $this->my_chat_member = new ChatMemberUpdated(
                    $init_data->my_chat_member,
                );
            }

            if (property_exists($init_data, 'chat_member')) {
                $this->chat_member = new ChatMemberUpdated(
                    $init_data->chat_member,
                );
            }

            if (property_exists($init_data, 'chat_join_request')) {
                $this->chat_join_request = new ChatJoinRequest(
                    $init_data->chat_join_request,
                );
            }

            if (property_exists($init_data, 'chat_boost')) {
                $this->chat_boost = new ChatBoostUpdated(
                    $init_data->chat_boost,
                );
            }

            if (property_exists($init_data, 'removed_chat_boost')) {
                $this->removed_chat_boost = new ChatBoostRemoved(
                    $init_data->removed_chat_boost,
                );
            }
        }
    }
}

/**
 * This object represents a message.
 */
class Message
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
     * Optional. Information about the original message for forwarded messages
     */
    public ?MessageOrigin $forward_origin = null;

    /**
     * Optional. True, if the message is sent to a forum topic
     */
    public ?bool $is_topic_message = null;

    /**
     * Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion group
     */
    public ?bool $is_automatic_forward = null;

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
    public ?bool $has_protected_content = null;

    /**
     * Optional. True, if the message was sent by an implicit action, for example, as an away or a greeting business message, or as a scheduled message
     */
    public ?bool $is_from_offline = null;

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
    public ?bool $show_caption_above_media = null;

    /**
     * Optional. True, if the message media is covered by a spoiler animation
     */
    public ?bool $has_media_spoiler = null;

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
    public ?bool $delete_chat_photo = null;

    /**
     * Optional. Service message: the group has been created
     */
    public ?bool $group_chat_created = null;

    /**
     * Optional. Service message: the supergroup has been created. This field can't be received in a message coming through updates, because bot can't be a member of a supergroup when it is created. It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup.
     */
    public ?bool $supergroup_chat_created = null;

    /**
     * Optional. Service message: the channel has been created. This field can't be received in a message coming through updates, because bot can't be a member of a channel when it is created. It can only be found in reply_to_message if someone replies to a very first message in a channel.
     */
    public ?bool $channel_chat_created = null;

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
     * Optional. Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
     */
    public ?Message $pinned_message = null;

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

        if (property_exists($init_data, 'sender_chat')) {
            $this->sender_chat = new Chat($init_data->sender_chat);
        }

        if (property_exists($init_data, 'sender_business_bot')) {
            $this->sender_business_bot = new User(
                $init_data->sender_business_bot,
            );
        }

        if (property_exists($init_data, 'chat')) {
            $this->chat = new Chat($init_data->chat);
        }

        if (property_exists($init_data, 'forward_origin')) {
            $this->forward_origin = new MessageOrigin(
                $init_data->forward_origin,
            );
        }

        if (property_exists($init_data, 'reply_to_message')) {
            $this->reply_to_message = new Message($init_data->reply_to_message);
        }

        if (property_exists($init_data, 'external_reply')) {
            $this->external_reply = new ExternalReplyInfo(
                $init_data->external_reply,
            );
        }

        if (property_exists($init_data, 'quote')) {
            $this->quote = new TextQuote($init_data->quote);
        }

        if (property_exists($init_data, 'reply_to_story')) {
            $this->reply_to_story = new Story($init_data->reply_to_story);
        }

        if (property_exists($init_data, 'via_bot')) {
            $this->via_bot = new User($init_data->via_bot);
        }

        if (property_exists($init_data, 'animation')) {
            $this->animation = new Animation($init_data->animation);
        }

        if (property_exists($init_data, 'audio')) {
            $this->audio = new Audio($init_data->audio);
        }

        if (property_exists($init_data, 'document')) {
            $this->document = new Document($init_data->document);
        }

        if (property_exists($init_data, 'paid_media')) {
            $this->paid_media = new PaidMediaInfo($init_data->paid_media);
        }

        if (property_exists($init_data, 'sticker')) {
            $this->sticker = new Sticker($init_data->sticker);
        }

        if (property_exists($init_data, 'story')) {
            $this->story = new Story($init_data->story);
        }

        if (property_exists($init_data, 'video')) {
            $this->video = new Video($init_data->video);
        }

        if (property_exists($init_data, 'video_note')) {
            $this->video_note = new VideoNote($init_data->video_note);
        }

        if (property_exists($init_data, 'voice')) {
            $this->voice = new Voice($init_data->voice);
        }

        if (property_exists($init_data, 'contact')) {
            $this->contact = new Contact($init_data->contact);
        }

        if (property_exists($init_data, 'dice')) {
            $this->dice = new Dice($init_data->dice);
        }

        if (property_exists($init_data, 'game')) {
            $this->game = new Game($init_data->game);
        }

        if (property_exists($init_data, 'poll')) {
            $this->poll = new Poll($init_data->poll);
        }

        if (property_exists($init_data, 'venue')) {
            $this->venue = new Venue($init_data->venue);
        }

        if (property_exists($init_data, 'location')) {
            $this->location = new Location($init_data->location);
        }

        if (property_exists($init_data, 'left_chat_member')) {
            $this->left_chat_member = new User($init_data->left_chat_member);
        }

        if (property_exists($init_data, 'message_auto_delete_timer_changed')) {
            $this->message_auto_delete_timer_changed = new MessageAutoDeleteTimerChanged(
                $init_data->message_auto_delete_timer_changed,
            );
        }

        if (property_exists($init_data, 'pinned_message')) {
            $this->pinned_message = new Message($init_data->pinned_message);
        }

        if (property_exists($init_data, 'invoice')) {
            $this->invoice = new Invoice($init_data->invoice);
        }

        if (property_exists($init_data, 'successful_payment')) {
            $this->successful_payment = new SuccessfulPayment(
                $init_data->successful_payment,
            );
        }

        if (property_exists($init_data, 'refunded_payment')) {
            $this->refunded_payment = new RefundedPayment(
                $init_data->refunded_payment,
            );
        }

        if (property_exists($init_data, 'users_shared')) {
            $this->users_shared = new UsersShared($init_data->users_shared);
        }

        if (property_exists($init_data, 'chat_shared')) {
            $this->chat_shared = new ChatShared($init_data->chat_shared);
        }

        if (property_exists($init_data, 'write_access_allowed')) {
            $this->write_access_allowed = new WriteAccessAllowed(
                $init_data->write_access_allowed,
            );
        }

        if (property_exists($init_data, 'passport_data')) {
            $this->passport_data = new PassportData($init_data->passport_data);
        }

        if (property_exists($init_data, 'proximity_alert_triggered')) {
            $this->proximity_alert_triggered = new ProximityAlertTriggered(
                $init_data->proximity_alert_triggered,
            );
        }

        if (property_exists($init_data, 'boost_added')) {
            $this->boost_added = new ChatBoostAdded($init_data->boost_added);
        }

        if (property_exists($init_data, 'chat_background_set')) {
            $this->chat_background_set = new ChatBackground(
                $init_data->chat_background_set,
            );
        }

        if (property_exists($init_data, 'forum_topic_created')) {
            $this->forum_topic_created = new ForumTopicCreated(
                $init_data->forum_topic_created,
            );
        }

        if (property_exists($init_data, 'forum_topic_edited')) {
            $this->forum_topic_edited = new ForumTopicEdited(
                $init_data->forum_topic_edited,
            );
        }

        if (property_exists($init_data, 'forum_topic_closed')) {
            $this->forum_topic_closed = new ForumTopicClosed(
                $init_data->forum_topic_closed,
            );
        }

        if (property_exists($init_data, 'forum_topic_reopened')) {
            $this->forum_topic_reopened = new ForumTopicReopened(
                $init_data->forum_topic_reopened,
            );
        }

        if (property_exists($init_data, 'general_forum_topic_hidden')) {
            $this->general_forum_topic_hidden = new GeneralForumTopicHidden(
                $init_data->general_forum_topic_hidden,
            );
        }

        if (property_exists($init_data, 'general_forum_topic_unhidden')) {
            $this->general_forum_topic_unhidden = new GeneralForumTopicUnhidden(
                $init_data->general_forum_topic_unhidden,
            );
        }

        if (property_exists($init_data, 'giveaway_created')) {
            $this->giveaway_created = new GiveawayCreated($init_data->giveaway);
        }

        if (property_exists($init_data, 'giveaway')) {
            $this->giveaway = new Giveaway($init_data->giveaway);
        }

        if (property_exists($init_data, 'giveaway_winners')) {
            $this->giveaway_winners = new GiveawayWinners($init_data->giveaway);
        }

        if (property_exists($init_data, 'giveaway_completed')) {
            $this->giveaway_completed = new GiveawayCompleted(
                $init_data->giveaway,
            );
        }

        if (property_exists($init_data, 'video_chat_scheduled')) {
            $this->video_chat_scheduled = new VideoChatScheduled(
                $init_data->video_chat_scheduled,
            );
        }

        if (property_exists($init_data, 'video_chat_started')) {
            $this->video_chat_started = new VideoChatStarted(
                $init_data->video_chat_started,
            );
        }

        if (property_exists($init_data, 'video_chat_ended')) {
            $this->video_chat_ended = new VideoChatEnded(
                $init_data->video_chat_ended,
            );
        }

        if (property_exists($init_data, 'video_chat_participants_invited')) {
            $this->video_chat_participants_invited = new VideoChatParticipantsInvited(
                $init_data->video_chat_participants_invited,
            );
        }

        if (property_exists($init_data, 'web_app_data')) {
            $this->web_app_data = new WebAppData($init_data->web_app_data);
        }

        if (property_exists($init_data, 'reply_markup')) {
            $this->reply_markup = new InlineKeyboardMarkup(
                $init_data->reply_markup,
            );
        }
    }
}

/**
 * This object represents an incoming callback query from a callback button in an inline keyboard. If the button that originated the query was attached to a message sent by the bot, the field message will be present. If the button was attached to a message sent via the bot (in inline mode), the field inline_message_id will be present. Exactly one of the fields data or game_short_name will be present.
 */
class CallbackQuery
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
     * Optional. Message with the callback button that originated the query. Note that message content and message date will not be available if the message is too old
     */
    public Message|InaccessibleMessage|null $message = null; // Actually of type MaybeInaccessibleMessage

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

        if (property_exists($init_data, 'message')) {
            if ($init_data->message->date == 0) {
                $this->message = new InaccessibleMessage($init_data->message);
            } else {
                $this->message = new Message($init_data->message);
            }
        }
    }
}

// -------------------------------------------------------------------

/**
 * This object contains information about a chat that was shared with the bot using a KeyboardButtonRequestChat button.
 */
class ChatShared
{
    public int $request_id;

    public int $chat_id;

    public ?string $title;

    public ?string $username;

    /**
     * Optional. Available sizes of the chat photo, if the photo was requested by the bot
     * @var array<PhotoSize>
     */
    public ?array $photo;

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

// -------------------------------------------------------------------

#[\AllowDynamicProperties]
class UsersShared
{
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

#[\AllowDynamicProperties]
class PaidMediaInfo
{
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

#[\AllowDynamicProperties]
class RefundedPayment
{
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

#[\AllowDynamicProperties]
class ChatBoostAdded
{
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

#[\AllowDynamicProperties]
class ChatBackground
{
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

#[\AllowDynamicProperties]
class Giveaway
{
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

#[\AllowDynamicProperties]
class GiveawayCreated
{
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

#[\AllowDynamicProperties]
class GiveawayCompleted
{
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

#[\AllowDynamicProperties]
class GiveawayWinners
{
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

#[\AllowDynamicProperties]
class Story
{
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

#[\AllowDynamicProperties]
class ExternalReplyInfo
{
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

#[\AllowDynamicProperties]
class TextQuote
{
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

#[\AllowDynamicProperties]
class LinkPreviewOptions
{
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

#[\AllowDynamicProperties]
class MessageOrigin
{
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

#[\AllowDynamicProperties]
class InaccessibleMessage
{
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

#[\AllowDynamicProperties]
class BusinessConnection
{
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

#[\AllowDynamicProperties]
class BusinessMessageDeleted
{
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

#[\AllowDynamicProperties]
class MessageReactionUpdated
{
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

#[\AllowDynamicProperties]
class MessageReactionCountUpdated
{
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

#[\AllowDynamicProperties]
class PaidMediaPurchased
{
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

#[\AllowDynamicProperties]
class ChatBoostUpdated
{
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

#[\AllowDynamicProperties]
class ChatBoostRemoved
{
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
