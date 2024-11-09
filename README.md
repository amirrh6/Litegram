# Litegram [Work in Progress]

Lightweight PHP wrapper library for Telegram Bot API

Bot API version: [v7.10 (September 6, 2024)](https://core.telegram.org/bots/api#september-6-2024) ([Snapshot Link](https://web.archive.org/web/20241009125109/https://core.telegram.org/bots/api))

* Minimal, Doesn't get in your way
* Fully documented, Employs identical names for methods and classes as those found in the official API
* Uses Guzzle as the HTTP client
* Provides type hints for IDE autocompletion
* TODO: Async / Concurrent requests
* TODO: Use [Constructor Property Promotion for every method-type class](https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion)
* TODO: Implement file uploads (Class: InputFile)

```php
require_once './vendor/autoload.php';

use Litegram\TelegramMethods;
use Litegram\SendMessageParams;

try {
    $token = '0123456789:...';
    $some_chat_id = '-100...';

    // TODO: Add examples for getUpdates and getMe after the methods are implemented.

    // Options for [Guzzle](https://docs.guzzlephp.org/en/stable/request-options.html)
    $options = [
        'timeout' => 5.0,
        // 'proxy' => 'http://localhost:8118',
    ];

    // If the request doesn't fail, an object of type Litegram\Message will be returned
    $res = TelegramMethods::sendMessage(
        token: $token,
        params: new SendMessageParams(chat_id: $some_chat_id, text: 'Test'),
        options: $options,
    );

    var_dump('Result:', $res);
} catch (\Throwable $th) {
    var_dump('Exception:', $th);
}
```

## Implemented classes and methods:

Getting updates:
- [X] [Update](https://core.telegram.org/bots/api#Update)
- [X] [getUpdates()](#)
- [X] [setWebhook()](#)
- [X] [deleteWebhook()](#)
- [X] [getWebhookInfo()](#)
- [X] [WebhookInfo](#)
---
Available types:
- [X] [User](#)
- [X] [Chat](#)
- [X] [ChatFullInfo](#)
- [X] [Message](#)
- [ ] [MessageId](#)
- [ ] [InaccessibleMessage](#)
- [X] [MaybeInaccessibleMessage](#) : InaccessibleMessage | Message
- [ ] [MessageEntity](#)
- [ ] [TextQuote](#)
- [ ] [ExternalReplyInfo](#)
- [X] [ReplyParameters](#)
- [X] [MessageOrigin](#) : MessageOriginUser | MessageOriginHiddenUser | MessageOriginChat | MessageOriginChannel
- [ ] [MessageOriginUser](#)
- [ ] [MessageOriginHiddenUser](#)
- [ ] [MessageOriginChat](#)
- [ ] [MessageOriginChannel](#)
- [ ] [PhotoSize](#)
- [ ] [Animation](#)
- [ ] [Audio](#)
- [ ] [Document](#)
- [ ] [Story](#)
- [ ] [Video](#)
- [ ] [VideoNote](#)
- [ ] [Voice](#)
- [ ] [PaidMediaInfo](#)
- [X] [PaidMedia](#) : PaidMediaPreview | PaidMediaPhoto | PaidMediaVideo
- [ ] [PaidMediaPreview](#)
- [ ] [PaidMediaPhoto](#)
- [ ] [PaidMediaVideo](#)
- [ ] [Contact](#)
- [ ] [Dice](#)
- [ ] [PollOption](#)
- [ ] [InputPollOption](#)
- [X] [PollAnswer](#)
- [X] [Poll](#)
- [ ] [Location](#)
- [ ] [Venue](#)
- [ ] [WebAppData](#)
- [ ] [ProximityAlertTriggered](#)
- [ ] [MessageAutoDeleteTimerChanged](#)
- [ ] [ChatBoostAdded](#)
- [ ] [BackgroundFill](#)
- [ ] [BackgroundFillSolid](#)
- [ ] [BackgroundFillGradient](#)
- [ ] [BackgroundFilFreeformGradient](#)
- [ ] [BackgroundType](#)
- [ ] [BackgroundTypeFill](#)
- [ ] [BackgroundTypeWallpaper](#)
- [ ] [BackgroundTypePattern](#)
- [ ] [BackgroundTypeChatTheme](#)
- [ ] [ChatBackground](#)
- [ ] [ForumTopicCreated](#)
- [ ] [ForumTopicClosed](#)
- [ ] [ForumTopicEdited](#)
- [ ] [ForumTopicReopened](#)
- [ ] [GeneralForumTopicHidden](#)
- [ ] [GeneralForumTopicUnhidden](#)
- [ ] [SharedUser](#)
- [ ] [UsersShared](#)
- [X] [ChatShared](#)
- [ ] [WriteAccessAllowed](#)
- [ ] [VideoChatScheduled](#)
- [ ] [VideoChatStarted](#)
- [ ] [VideoChatEnded](#)
- [ ] [VideoChatParticipantsInvited](#)
- [ ] [GiveawayCreated](#)
- [ ] [Giveaway](#)
- [ ] [GiveawayWinners](#)
- [ ] [GiveawayCompleted](#)
- [ ] [LinkPreviewOptions](#)
- [ ] [UserProfilePhotos](#)
- [ ] [File](#)
- [X] [WebAppInfo](#)
- [X] [ReplyKeyboardMarkup](#)
- [X] [KeyboardButton](#)
- [ ] [KeyboardButtonRequestUsers](#)
- [X] [KeyboardButtonRequestChat](#)
- [ ] [KeyboardButtonPollType](#)
- [X] [ReplyKeyboardRemove](#)
- [X] [InlineKeyboardMarkup](#)
- [X] [InlineKeyboardButton](#)
- [ ] [LoginUrl](#)
- [ ] [SwitchInlineQueryChosenChat](#)
- [X] [CallbackQuery](#)
- [X] [ForceReply](#)
- [ ] [ChatPhoto](#)
- [ ] [ChatInviteLink](#)
- [ ] [ChatAdministratorRights](#)
- [X] [ChatMemberUpdated](#)
- [X] [ChatMember](#) : ChatMemberOwner | ChatMemberAdministrator | ChatMemberMember | ChatMemberRestricted | ChatMemberLeft | ChatMemberBanned
- [ ] [ChatMemberOwner](#)
- [ ] [ChatMemberAdministrator](#)
- [ ] [ChatMemberMember](#)
- [ ] [ChatMemberRestricted](#)
- [ ] [ChatMemberLeft](#)
- [ ] [ChatMemberBanned](#)
- [X] [ChatJoinRequest](#)
- [ ] [ChatPermissions](#)
- [ ] [Birthdate](#)
- [ ] [BusinessIntro](#)
- [ ] [BusinessLocation](#)
- [ ] [BusinessOpeningHoursInterval](#)
- [ ] [BusinessOpeningHours](#)
- [ ] [ChatLocation](#)
- [X] [ReactionType](#) : ReactionTypeEmoji | ReactionTypeCustomEmoji | ReactionTypePaid
- [ ] [ReactionTypeEmoji](#)
- [ ] [ReactionTypeCustomEmoji](#)
- [ ] [ReactionTypePaid](#)
- [ ] [ReactionCount](#)
- [ ] [MessageReactionUpdated](#)
- [ ] [MessageReactionCountUpdated](#)
- [ ] [ForumTopic](#)
- [X] [BotCommand](#)
- [X] [BotCommandScope](#) : BotCommandScopeDefault | BotCommandScopeAllPrivateChats | BotCommandScopeAllGroupChats | BotCommandScopeAllChatAdministrators | BotCommandScopeChat | BotCommandScopeChatAdministrators | BotCommandScopeChatMember
- [X] [BotCommandScopeDefault](#)
- [X] [BotCommandScopeAllPrivateChats](#)
- [X] [BotCommandScopeAllGroupChats](#)
- [X] [BotCommandScopeAllChatAdministrators](#)
- [X] [BotCommandScopeChat](#)
- [X] [BotCommandScopeChatAdministrators](#)
- [X] [BotCommandScopeChatMember](#)
- [X] [BotName](#)
- [X] [BotDescription](#)
- [ ] [BotShortDescription](#)
- [X] [MenuButton](#) : MenuButtonCommands | MenuButtonWebApp | MenuButtonDefault
- [ ] [MenuButtonCommands](#)
- [ ] [MenuButtonWebApp](#)
- [ ] [MenuButtonDefault](#)
- [X] [ChatBoostSource](#) : ChatBoostSourcePremium | ChatBoostSourceGiftCode | ChatBoostSourceGiveaway
- [ ] [ChatBoostSourcePremium](#)
- [ ] [ChatBoostSourceGiftCode](#)
- [ ] [ChatBoostSourceGiveaway](#)
- [ ] [ChatBoost](#)
- [ ] [ChatBoostUpdated](#)
- [ ] [ChatBoostRemoved](#)
- [ ] [UserChatBoosts](#)
- [X] [BusinessConnection](#)
- [X] [BusinessMessagesDeleted](#)
- [ ] [ResponseParameters](#)
- [X] [InputMedia](#) : InputMediaAnimation | InputMediaDocument | InputMediaAudio | InputMediaPhoto | InputMediaVideo
- [ ] [InputMediaPhoto](#)
- [ ] [InputMediaVideo](#)
- [ ] [InputMediaAnimation](#)
- [ ] [InputMediaAudio](#)
- [ ] [InputMediaDocument](#)
- [ ] [InputFile](#)
- [X] [InputPaidMedia](#) : InputPaidMediaPhoto | InputPaidMediaVideo
- [ ] [InputPaidMediaPhoto](#)
- [ ] [InputPaidMediaVideo](#)
---
Available methods:
- [X] [getMe()](#)
- [X] [logOut()](#)
- [X] [close()](#)
- [X] [sendMessage()](#)
- [ ] [forwardMessage()](#)
- [X] [copyMessage()](#)
- [ ] ...
---
Updating messages:
- [ ] ...
---
Stickers:
- [ ] ...
---
Inline mode:
- [X] [InlineQuery](#)
- [ ] [answerInlineQuery](#)
- [X] [InlineQueryResultsButton](#)
- [X] [InlineQueryResult](#) : InlineQueryResultCachedAudio | InlineQueryResultCachedDocument | InlineQueryResultCachedGif | InlineQueryResultCachedMpeg4Gif | InlineQueryResultCachedPhoto | InlineQueryResultCachedSticker | InlineQueryResultCachedVideo | InlineQueryResultCachedVoice | InlineQueryResultArticle | InlineQueryResultAudio | InlineQueryResultContact | InlineQueryResultGame | InlineQueryResultDocument | InlineQueryResultGif | InlineQueryResultLocation | InlineQueryResultMpeg4Gif | InlineQueryResultPhoto | InlineQueryResultVenue | InlineQueryResultVideo | InlineQueryResultVoice
- [ ] [InlineQueryResultArticle](#)
- [ ] [InlineQueryResultPhoto](#)
- [ ] [InlineQueryResultGif](#)
- [ ] [InlineQueryResultMpeg4Gif](#)
- [ ] [InlineQueryResultVideo](#)
- [ ] [InlineQueryResultAudio](#)
- [ ] [InlineQueryResultVoice](#)
- [ ] [InlineQueryResultDocument](#)
- [ ] [InlineQueryResultLocation](#)
- [ ] [InlineQueryResultVenue](#)
- [ ] [InlineQueryResultContact](#)
- [ ] [InlineQueryResultGame](#)
- [ ] [InlineQueryResultCachedPhoto](#)
- [ ] [InlineQueryResultCachedGif](#)
- [ ] [InlineQueryResultCachedMpeg4Gif](#)
- [ ] [InlineQueryResultCachedSticker](#)
- [ ] [InlineQueryResultCachedDocument](#)
- [ ] [InlineQueryResultCachedVideo](#)
- [ ] [InlineQueryResultCachedVoice](#)
- [ ] [InlineQueryResultCachedAudio](#)
- [X] [InputMessageContent](#) : InputTextMessageContent | InputLocationMessageContent | InputVenueMessageContent | InputContactMessageContent | InputInvoiceMessageContent
- [ ] [InputTextMessageContent](#)
- [ ] [InputLocationMessageContent](#)
- [ ] [InputVenueMessageContent](#)
- [ ] [InputContactMessageContent](#)
- [ ] [InputInvoiceMessageContent](#)
- [X] [ChosenInlineResult](#)
- [ ] [answerWebAppQuery()](#)
- [ ] [SentWebAppMessage](#)
---
Payments:
- [ ] ...
- [X] [ShippingQuery](#)
- [X] [PreCheckoutQuery](#)
- [X] [PaidMediaPurchased](#)
- [ ] ...
---
Telegram Passport:
- [ ] ...
---
Games:
- [ ] ...