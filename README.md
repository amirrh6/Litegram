# Litegram

Lightweight PHP wrapper library for Telegram Bot API

Bot API version: [v7.10 (September 6, 2024)](https://core.telegram.org/bots/api#september-6-2024) <a href="https://web.archive.org/web/20241009125109/https://core.telegram.org/bots/api" target="_blank">(Snapshot Link)</a>

* Minimal, Doesn't get in your way
* Fully documented, Employs identical names for methods and classes as those found in the official API
* Uses Guzzle as the HTTP client
* Provides type hints for IDE autocompletion
* TODO: Async / Concurrent requests

Litegram is still in early development stages so expect bugs and non-backward compatible changes.

Use Github Issues for comments, bug reports and questions.

## Installation

`composer require amirrh6/litegram`

## Usage

```php
require_once './vendor/autoload.php';

// Just in case you have not installed the awesome 'symfony/var-dumper' package for beautiful dump outputs:
if (!function_exists('dump')) {
    function dump(mixed ...$vars)
    {
        var_dump('dump:', ...$vars);
    }
}

// --- --- --- --- --- --- ---

$token = '0123456789:...';
$some_chat_id = '-100...';

// Options for Guzzle (https://docs.guzzlephp.org/en/stable/request-options.html)
$options = [
    'timeout' => 5.0,
    // 'proxy' => 'http://localhost:8118',
];

// --- --- --- --- --- --- ---

use Litegram\InputFile;
use Litegram\TelegramMethods;
use Litegram\SendMessageParams;
use Litegram\SendPhotoParams;

try {
    // If the request doesn't fail, an object of type Litegram\User will be returned
    $res = TelegramMethods::getMe(token: $token, options: $options);
    dump('Result:', $res);

    // If the request doesn't fail, an object of type Litegram\Message will be returned
    $res = TelegramMethods::sendMessage(
        token: $token,
        params: new SendMessageParams(chat_id: $some_chat_id, text: 'Test'),
        options: $options,
    );
    dump('Result:', $res);

    // If the request doesn't fail, an object of type Litegram\Message will be returned
    $res = TelegramMethods::sendPhoto(
        token: $token,
        params: new SendPhotoParams(
            chat_id: $some_chat_id,
            photo: new InputFile('/home/amir/test.jpg'),
            caption: 'Look at this beautiful landscape!',
            show_caption_above_media: true,
        ),
        options: $options,
    );
    dump('Result:', $res);
} catch (\Throwable $th) {
    dump('Exception:', $th);
}
```

## History

Over a year ago, during my free time between university classes, I started working on another Telegram bot.
I wanted to challenge myself by creating my own wrapper library for it. Although the bot project was eventually abandoned, I decided to revive the wrapper library, and here we are today.

## License:

[GPL 2.0 only](https://spdx.org/licenses/GPL-2.0-only.html)

## Implemented classes and methods:

Getting updates:
- [X] [Update](https://core.telegram.org/bots/api#update)
- [X] [getUpdates](https://core.telegram.org/bots/api#getupdates)
- [X] [setWebhook](https://core.telegram.org/bots/api#setwebhook)
- [X] [deleteWebhook](https://core.telegram.org/bots/api#deletewebhook)
- [X] [getWebhookInfo](https://core.telegram.org/bots/api#getwebhookinfo)
- [X] [WebhookInfo](https://core.telegram.org/bots/api#webhookinfo)
---
Available types:
- [X] [User](https://core.telegram.org/bots/api#user)
- [X] [Chat](https://core.telegram.org/bots/api#chat)
- [X] [ChatFullInfo](https://core.telegram.org/bots/api#chatfullinfo)
- [X] [Message](https://core.telegram.org/bots/api#message)
- [ ] [MessageId](https://core.telegram.org/bots/api#messageid)
- [ ] [InaccessibleMessage](https://core.telegram.org/bots/api#inaccessiblemessage)
- [MaybeInaccessibleMessage](https://core.telegram.org/bots/api#maybeinaccessiblemessage) : InaccessibleMessage | Message
- [ ] [MessageEntity](https://core.telegram.org/bots/api#messageentity)
- [ ] [TextQuote](https://core.telegram.org/bots/api#textquote)
- [ ] [ExternalReplyInfo](https://core.telegram.org/bots/api#externalreplyinfo)
- [X] [ReplyParameters](https://core.telegram.org/bots/api#replyparameters)
- [MessageOrigin](https://core.telegram.org/bots/api##messageorigin) : MessageOriginUser | MessageOriginHiddenUser | MessageOriginChat | MessageOriginChannel
- [ ] [MessageOriginUser](https://core.telegram.org/bots/api#messageoriginuser)
- [ ] [MessageOriginHiddenUser](https://core.telegram.org/bots/api#messageoriginhiddenuser)
- [ ] [MessageOriginChat](https://core.telegram.org/bots/api#messageoriginchat)
- [ ] [MessageOriginChannel](https://core.telegram.org/bots/api#messageoriginchannel)
- [ ] [PhotoSize](https://core.telegram.org/bots/api#photosize)
- [ ] [Animation](https://core.telegram.org/bots/api#animation)
- [ ] [Audio](https://core.telegram.org/bots/api#audio)
- [ ] [Document](https://core.telegram.org/bots/api#document)
- [ ] [Story](https://core.telegram.org/bots/api#story)
- [ ] [Video](https://core.telegram.org/bots/api#video)
- [ ] [VideoNote](https://core.telegram.org/bots/api#videonote)
- [ ] [Voice](https://core.telegram.org/bots/api#voice)
- [ ] [PaidMediaInfo](https://core.telegram.org/bots/api#paidmediainfo)
- [PaidMedia](https://core.telegram.org/bots/api#paidmedia) : PaidMediaPreview | PaidMediaPhoto | PaidMediaVideo
- [ ] [PaidMediaPreview](https://core.telegram.org/bots/api#paidmediapreview)
- [ ] [PaidMediaPhoto](https://core.telegram.org/bots/api#paidmediaphoto)
- [ ] [PaidMediaVideo](https://core.telegram.org/bots/api#paidmediavideo)
- [ ] [Contact](https://core.telegram.org/bots/api#contact)
- [ ] [Dice](https://core.telegram.org/bots/api#dice)
- [ ] [PollOption](https://core.telegram.org/bots/api#polloption)
- [ ] [InputPollOption](https://core.telegram.org/bots/api#inputpolloption)
- [X] [PollAnswer](https://core.telegram.org/bots/api#pollanswer)
- [X] [Poll](https://core.telegram.org/bots/api#poll)
- [ ] [Location](https://core.telegram.org/bots/api#location)
- [ ] [Venue](https://core.telegram.org/bots/api#venue)
- [ ] [WebAppData](https://core.telegram.org/bots/api#webappdata)
- [ ] [ProximityAlertTriggered](https://core.telegram.org/bots/api#proximityalerttriggered)
- [ ] [MessageAutoDeleteTimerChanged](https://core.telegram.org/bots/api#messageautodeletetimerchanged)
- [ ] [ChatBoostAdded](https://core.telegram.org/bots/api#chatboostadded)
- [ ] [BackgroundFill](https://core.telegram.org/bots/api#backgroundfill)
- [ ] [BackgroundFillSolid](https://core.telegram.org/bots/api#backgroundfillsolid)
- [ ] [BackgroundFillGradient](https://core.telegram.org/bots/api#backgroundfillgradient)
- [ ] [BackgroundFilFreeformGradient](https://core.telegram.org/bots/api#backgroundfilfreeformgradient)
- [ ] [BackgroundType](https://core.telegram.org/bots/api#backgroundtype)
- [ ] [BackgroundTypeFill](https://core.telegram.org/bots/api#backgroundtypefill)
- [ ] [BackgroundTypeWallpaper](https://core.telegram.org/bots/api#backgroundtypewallpaper)
- [ ] [BackgroundTypePattern](https://core.telegram.org/bots/api#backgroundtypepattern)
- [ ] [BackgroundTypeChatTheme](https://core.telegram.org/bots/api#backgroundtypechattheme)
- [ ] [ChatBackground](https://core.telegram.org/bots/api#chatbackground)
- [ ] [ForumTopicCreated](https://core.telegram.org/bots/api#forumtopiccreated)
- [ ] [ForumTopicClosed](https://core.telegram.org/bots/api#forumtopicclosed)
- [ ] [ForumTopicEdited](https://core.telegram.org/bots/api#forumtopicedited)
- [ ] [ForumTopicReopened](https://core.telegram.org/bots/api#forumtopicreopened)
- [ ] [GeneralForumTopicHidden](https://core.telegram.org/bots/api#generalforumtopichidden)
- [ ] [GeneralForumTopicUnhidden](https://core.telegram.org/bots/api#generalforumtopicunhidden)
- [ ] [SharedUser](https://core.telegram.org/bots/api#shareduser)
- [ ] [UsersShared](https://core.telegram.org/bots/api#usersshared)
- [X] [ChatShared](https://core.telegram.org/bots/api#chatshared)
- [ ] [WriteAccessAllowed](https://core.telegram.org/bots/api#writeaccessallowed)
- [ ] [VideoChatScheduled](https://core.telegram.org/bots/api#videochatscheduled)
- [ ] [VideoChatStarted](https://core.telegram.org/bots/api#videochatstarted)
- [ ] [VideoChatEnded](https://core.telegram.org/bots/api#videochatended)
- [ ] [VideoChatParticipantsInvited](https://core.telegram.org/bots/api#videochatparticipantsinvited)
- [ ] [GiveawayCreated](https://core.telegram.org/bots/api#giveawaycreated)
- [ ] [Giveaway](https://core.telegram.org/bots/api#giveaway)
- [ ] [GiveawayWinners](https://core.telegram.org/bots/api#giveawaywinners)
- [ ] [GiveawayCompleted](https://core.telegram.org/bots/api#giveawaycompleted)
- [ ] [LinkPreviewOptions](https://core.telegram.org/bots/api#linkpreviewoptions)
- [ ] [UserProfilePhotos](https://core.telegram.org/bots/api#userprofilephotos)
- [ ] [File](https://core.telegram.org/bots/api#file)
- [X] [WebAppInfo](https://core.telegram.org/bots/api#webappinfo)
- [X] [ReplyKeyboardMarkup](https://core.telegram.org/bots/api#replykeyboardmarkup)
- [X] [KeyboardButton](https://core.telegram.org/bots/api#keyboardbutton)
- [ ] [KeyboardButtonRequestUsers](https://core.telegram.org/bots/api#keyboardbuttonrequestusers)
- [X] [KeyboardButtonRequestChat](https://core.telegram.org/bots/api#keyboardbuttonrequestchat)
- [ ] [KeyboardButtonPollType](https://core.telegram.org/bots/api#keyboardbuttonpolltype)
- [X] [ReplyKeyboardRemove](https://core.telegram.org/bots/api#replykeyboardremove)
- [X] [InlineKeyboardMarkup](https://core.telegram.org/bots/api#inlinekeyboardmarkup)
- [X] [InlineKeyboardButton](https://core.telegram.org/bots/api#inlinekeyboardbutton)
- [ ] [LoginUrl](https://core.telegram.org/bots/api#loginurl)
- [ ] [SwitchInlineQueryChosenChat](https://core.telegram.org/bots/api#switchinlinequerychosenchat)
- [X] [CallbackQuery](https://core.telegram.org/bots/api#callbackquery)
- [X] [ForceReply](https://core.telegram.org/bots/api#forcereply)
- [ ] [ChatPhoto](https://core.telegram.org/bots/api#chatphoto)
- [ ] [ChatInviteLink](https://core.telegram.org/bots/api#chatinvitelink)
- [ ] [ChatAdministratorRights](https://core.telegram.org/bots/api#chatadministratorrights)
- [X] [ChatMemberUpdated](https://core.telegram.org/bots/api#chatmemberupdated)
- [ChatMember](https://core.telegram.org/bots/api#chatmember) : ChatMemberOwner | ChatMemberAdministrator | ChatMemberMember | ChatMemberRestricted | ChatMemberLeft | ChatMemberBanned
- [ ] [ChatMemberOwner](https://core.telegram.org/bots/api#chatmemberowner)
- [ ] [ChatMemberAdministrator](https://core.telegram.org/bots/api#chatmemberadministrator)
- [ ] [ChatMemberMember](https://core.telegram.org/bots/api#chatmembermember)
- [ ] [ChatMemberRestricted](https://core.telegram.org/bots/api#chatmemberrestricted)
- [ ] [ChatMemberLeft](https://core.telegram.org/bots/api#chatmemberleft)
- [ ] [ChatMemberBanned](https://core.telegram.org/bots/api#chatmemberbanned)
- [X] [ChatJoinRequest](https://core.telegram.org/bots/api#chatjoinrequest)
- [ ] [ChatPermissions](https://core.telegram.org/bots/api#chatpermissions)
- [ ] [Birthdate](https://core.telegram.org/bots/api#birthdate)
- [ ] [BusinessIntro](https://core.telegram.org/bots/api#businessintro)
- [ ] [BusinessLocation](https://core.telegram.org/bots/api#businesslocation)
- [ ] [BusinessOpeningHoursInterval](https://core.telegram.org/bots/api#businessopeninghoursinterval)
- [ ] [BusinessOpeningHours](https://core.telegram.org/bots/api#businessopeninghours)
- [ ] [ChatLocation](https://core.telegram.org/bots/api#chatlocation)
- [ReactionType](https://core.telegram.org/bots/api#reactiontype) : ReactionTypeEmoji | ReactionTypeCustomEmoji | ReactionTypePaid
- [ ] [ReactionTypeEmoji](https://core.telegram.org/bots/api#reactiontypeemoji)
- [ ] [ReactionTypeCustomEmoji](https://core.telegram.org/bots/api#reactiontypecustomemoji)
- [ ] [ReactionTypePaid](https://core.telegram.org/bots/api#reactiontypepaid)
- [ ] [ReactionCount](https://core.telegram.org/bots/api#reactioncount)
- [ ] [MessageReactionUpdated](https://core.telegram.org/bots/api#messagereactionupdated)
- [ ] [MessageReactionCountUpdated](https://core.telegram.org/bots/api#messagereactioncountupdated)
- [ ] [ForumTopic](https://core.telegram.org/bots/api#forumtopic)
- [X] [BotCommand](https://core.telegram.org/bots/api#botcommand)
- [BotCommandScope](https://core.telegram.org/bots/api#botcommandscope) : BotCommandScopeDefault | BotCommandScopeAllPrivateChats | BotCommandScopeAllGroupChats | BotCommandScopeAllChatAdministrators | BotCommandScopeChat | BotCommandScopeChatAdministrators | BotCommandScopeChatMember
- [X] [BotCommandScopeDefault](https://core.telegram.org/bots/api#botcommandscopedefault)
- [X] [BotCommandScopeAllPrivateChats](https://core.telegram.org/bots/api#botcommandscopeallprivatechats)
- [X] [BotCommandScopeAllGroupChats](https://core.telegram.org/bots/api#botcommandscopeallgroupchats)
- [X] [BotCommandScopeAllChatAdministrators](https://core.telegram.org/bots/api#botcommandscopeallchatadministrators)
- [X] [BotCommandScopeChat](https://core.telegram.org/bots/api#botcommandscopechat)
- [X] [BotCommandScopeChatAdministrators](https://core.telegram.org/bots/api#botcommandscopechatadministrators)
- [X] [BotCommandScopeChatMember](https://core.telegram.org/bots/api#botcommandscopechatmember)
- [X] [BotName](https://core.telegram.org/bots/api#botname)
- [X] [BotDescription](https://core.telegram.org/bots/api#botdescription)
- [ ] [BotShortDescription](https://core.telegram.org/bots/api#botshortdescription)
- [MenuButton](https://core.telegram.org/bots/api#menubutton) : MenuButtonCommands | MenuButtonWebApp | MenuButtonDefault
- [ ] [MenuButtonCommands](https://core.telegram.org/bots/api#menubuttoncommands)
- [ ] [MenuButtonWebApp](https://core.telegram.org/bots/api#menubuttonwebapp)
- [ ] [MenuButtonDefault](https://core.telegram.org/bots/api#menubuttondefault)
- [ChatBoostSource](https://core.telegram.org/bots/api#chatboostsource) : ChatBoostSourcePremium | ChatBoostSourceGiftCode | ChatBoostSourceGiveaway
- [ ] [ChatBoostSourcePremium](https://core.telegram.org/bots/api#chatboostsourcepremium)
- [ ] [ChatBoostSourceGiftCode](https://core.telegram.org/bots/api#chatboostsourcegiftcode)
- [ ] [ChatBoostSourceGiveaway](https://core.telegram.org/bots/api#chatboostsourcegiveaway)
- [ ] [ChatBoost](https://core.telegram.org/bots/api#chatboost)
- [ ] [ChatBoostUpdated](https://core.telegram.org/bots/api#chatboostupdated)
- [ ] [ChatBoostRemoved](https://core.telegram.org/bots/api#chatboostremoved)
- [ ] [UserChatBoosts](https://core.telegram.org/bots/api#userchatboosts)
- [X] [BusinessConnection](https://core.telegram.org/bots/api#businessconnection)
- [X] [BusinessMessagesDeleted](https://core.telegram.org/bots/api#businessmessagesdeleted)
- [ ] [ResponseParameters](https://core.telegram.org/bots/api#responseparameters)
- [InputMedia](https://core.telegram.org/bots/api#inputmedia) : InputMediaAnimation | InputMediaDocument | InputMediaAudio | InputMediaPhoto | InputMediaVideo
- [ ] [InputMediaPhoto](https://core.telegram.org/bots/api#inputmediaphoto)
- [ ] [InputMediaVideo](https://core.telegram.org/bots/api#inputmediavideo)
- [ ] [InputMediaAnimation](https://core.telegram.org/bots/api#inputmediaanimation)
- [ ] [InputMediaAudio](https://core.telegram.org/bots/api#inputmediaaudio)
- [ ] [InputMediaDocument](https://core.telegram.org/bots/api#inputmediadocument)
- [X] [InputFile](https://core.telegram.org/bots/api#inputfile)
- [InputPaidMedia](https://core.telegram.org/bots/api#inputpaidmedia) : InputPaidMediaPhoto | InputPaidMediaVideo
- [ ] [InputPaidMediaPhoto](https://core.telegram.org/bots/api#inputpaidmediaphoto)
- [ ] [InputPaidMediaVideo](https://core.telegram.org/bots/api#inputpaidmediavideo)
---
Available methods:
- [X] [getMe](https://core.telegram.org/bots/api#getme)
- [X] [logOut](https://core.telegram.org/bots/api#logout)
- [X] [close](https://core.telegram.org/bots/api#close)
- [X] [sendMessage](https://core.telegram.org/bots/api#sendmessage)
- [ ] [forwardMessage](https://core.telegram.org/bots/api#forwardmessage)
- [ ] [forwardMessages](https://core.telegram.org/bots/api#forwardmessages)
- [X] [copyMessage](https://core.telegram.org/bots/api#copymessage)
- [ ] [copyMessages](https://core.telegram.org/bots/api#copymessages)
- [X] [sendPhoto](https://core.telegram.org/bots/api#sendphoto)
- [ ] ...
- [X] [answerCallbackQuery](https://core.telegram.org/bots/api#answercallbackquery)
- [ ] ...
---
Updating messages:
- [X] [editMessageText](https://core.telegram.org/bots/api#editmessagetext)
---
Stickers:
- [ ] ...
---
Inline mode:
- [X] [InlineQuery](https://core.telegram.org/bots/api#inlinequery)
- [ ] [answerInlineQuery](https://core.telegram.org/bots/api#answerinlinequery)
- [X] [InlineQueryResultsButton](https://core.telegram.org/bots/api#inlinequeryresultsbutton)
- [InlineQueryResult](https://core.telegram.org/bots/api#inlinequeryresult) : InlineQueryResultCachedAudio | InlineQueryResultCachedDocument | InlineQueryResultCachedGif | InlineQueryResultCachedMpeg4Gif | InlineQueryResultCachedPhoto | InlineQueryResultCachedSticker | InlineQueryResultCachedVideo | InlineQueryResultCachedVoice | InlineQueryResultArticle | InlineQueryResultAudio | InlineQueryResultContact | InlineQueryResultGame | InlineQueryResultDocument | InlineQueryResultGif | InlineQueryResultLocation | InlineQueryResultMpeg4Gif | InlineQueryResultPhoto | InlineQueryResultVenue | InlineQueryResultVideo | InlineQueryResultVoice
- [ ] [InlineQueryResultArticle](https://core.telegram.org/bots/api#inlinequeryresultarticle)
- [ ] [InlineQueryResultPhoto](https://core.telegram.org/bots/api#inlinequeryresultphoto)
- [ ] [InlineQueryResultGif](https://core.telegram.org/bots/api#inlinequeryresultgif)
- [ ] [InlineQueryResultMpeg4Gif](https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif)
- [ ] [InlineQueryResultVideo](https://core.telegram.org/bots/api#inlinequeryresultvideo)
- [ ] [InlineQueryResultAudio](https://core.telegram.org/bots/api#inlinequeryresultaudio)
- [ ] [InlineQueryResultVoice](https://core.telegram.org/bots/api#inlinequeryresultvoice)
- [ ] [InlineQueryResultDocument](https://core.telegram.org/bots/api#inlinequeryresultdocument)
- [ ] [InlineQueryResultLocation](https://core.telegram.org/bots/api#inlinequeryresultlocation)
- [ ] [InlineQueryResultVenue](https://core.telegram.org/bots/api#inlinequeryresultvenue)
- [ ] [InlineQueryResultContact](https://core.telegram.org/bots/api#inlinequeryresultcontact)
- [ ] [InlineQueryResultGame](https://core.telegram.org/bots/api#inlinequeryresultgame)
- [ ] [InlineQueryResultCachedPhoto](https://core.telegram.org/bots/api#inlinequeryresultcachedphoto)
- [ ] [InlineQueryResultCachedGif](https://core.telegram.org/bots/api#inlinequeryresultcachedgif)
- [ ] [InlineQueryResultCachedMpeg4Gif](https://core.telegram.org/bots/api#inlinequeryresultcachedmpeg4gif)
- [ ] [InlineQueryResultCachedSticker](https://core.telegram.org/bots/api#inlinequeryresultcachedsticker)
- [ ] [InlineQueryResultCachedDocument](https://core.telegram.org/bots/api#inlinequeryresultcacheddocument)
- [ ] [InlineQueryResultCachedVideo](https://core.telegram.org/bots/api#inlinequeryresultcachedvideo)
- [ ] [InlineQueryResultCachedVoice](https://core.telegram.org/bots/api#inlinequeryresultcachedvoice)
- [ ] [InlineQueryResultCachedAudio](https://core.telegram.org/bots/api#inlinequeryresultcachedaudio)
- [InputMessageContent](https://core.telegram.org/bots/api#inputmessagecontent) : InputTextMessageContent | InputLocationMessageContent | InputVenueMessageContent | InputContactMessageContent | InputInvoiceMessageContent
- [ ] [InputTextMessageContent](https://core.telegram.org/bots/api#inputtextmessagecontent)
- [ ] [InputLocationMessageContent](https://core.telegram.org/bots/api#inputlocationmessagecontent)
- [ ] [InputVenueMessageContent](https://core.telegram.org/bots/api#inputvenuemessagecontent)
- [ ] [InputContactMessageContent](https://core.telegram.org/bots/api#inputcontactmessagecontent)
- [ ] [InputInvoiceMessageContent](https://core.telegram.org/bots/api#inputinvoicemessagecontent)
- [X] [ChosenInlineResult](https://core.telegram.org/bots/api#choseninlineresult)
- [ ] [answerWebAppQuery](https://core.telegram.org/bots/api#answerwebappquery)
- [ ] [SentWebAppMessage](https://core.telegram.org/bots/api#sentwebappmessage)
---
Payments:
- [ ] ...
- [X] [ShippingQuery](https://core.telegram.org/bots/api#shippingquery)
- [X] [PreCheckoutQuery](https://core.telegram.org/bots/api#precheckoutquery)
- [X] [PaidMediaPurchased](https://core.telegram.org/bots/api#paidmediapurchased)
- [ ] ...
---
Telegram Passport:
- [ ] ...
---
Games:
- [ ] ...