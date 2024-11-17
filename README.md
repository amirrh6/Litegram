# Litegram

Lightweight PHP wrapper library for Telegram Bot API

Bot API version: [v7.10 (September 6, 2024)](https://core.telegram.org/bots/api#september-6-2024) - [Snapshot Link](https://web.archive.org/web/20241009125109/https://core.telegram.org/bots/api)

* Minimal, Doesn't get in your way
* Fully documented, Employs identical names for methods and classes as those found in the official API
* Uses Guzzle as the HTTP client
* Provides type hints for IDE autocompletion
* TODO: Complete implementation of all methods and classes
* TODO: Concurrent (bulk) requests: Has been experimentally implemented for some methods
* TODO: Async requests
* TODO: Provide helper utilities (e.g. For formatting messages using HTML or Markdown) and builtin checks (e.g. Making sure the message text's length does not exceed 4096 chars)

Litegram is still in early development stages so expect bugs and non-backward compatible changes.

Use Github Issues for comments, bug reports and questions.

## Installation

`composer require amirrh6/litegram`

## Usage

```php
require_once './vendor/autoload.php';

// --- --- --- --- --- --- ---

$token = '0123456789:...';

// --- --- --- --- --- --- ---

use Litegram\TelegramMethods;

try {
    // If the request doesn't fail, an object of type Litegram\User will be returned
    $res = TelegramMethods::getMe(token: $token);
    var_dump('Result:', $res);
} catch (\Throwable $th) {
    var_dump('Exception:', $th);
}
```

## Examples

[This file](https://github.com/amirrh6/Litegram/blob/main/examples/example.php) provides usage example for some primary methods.

## History

Over a year ago, during my free time between university classes, I started working on another Telegram bot.
I wanted to challenge myself by creating my own wrapper library for it. Although the bot project was eventually abandoned, I decided to revive the wrapper library, and here we are today.

## License:

[GPL 2.0 only](https://spdx.org/licenses/GPL-2.0-only.html)

## Implemented classes and methods:

\* Make sure you view this section on [Github](https://github.com/amirrh6/Litegram?tab=readme-ov-file#implemented-classes-and-methods) rather than Packagist as it doesn't display checkmarks correctly.

Getting updates (4/4 methods implemented, 2/2 classes implemented):
- [X] [Update](https://core.telegram.org/bots/api#update)
- [X] [getUpdates](https://core.telegram.org/bots/api#getupdates)
- [X] [setWebhook](https://core.telegram.org/bots/api#setwebhook)
- [X] [deleteWebhook](https://core.telegram.org/bots/api#deletewebhook)
- [X] [getWebhookInfo](https://core.telegram.org/bots/api#getwebhookinfo)
- [X] [WebhookInfo](https://core.telegram.org/bots/api#webhookinfo)

--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

Available types (34/139 classes implemented + 10 union types):
- [X] [User](https://core.telegram.org/bots/api#user)
- [X] [Chat](https://core.telegram.org/bots/api#chat)
- [X] [ChatFullInfo](https://core.telegram.org/bots/api#chatfullinfo)
- [X] [Message](https://core.telegram.org/bots/api#message)
- [X] [MessageId](https://core.telegram.org/bots/api#messageid)
- [X] [InaccessibleMessage](https://core.telegram.org/bots/api#inaccessiblemessage)
- [MaybeInaccessibleMessage](https://core.telegram.org/bots/api#maybeinaccessiblemessage) : InaccessibleMessage | Message
- [ ] [MessageEntity](https://core.telegram.org/bots/api#messageentity)
- [ ] [TextQuote](https://core.telegram.org/bots/api#textquote)
- [ ] [ExternalReplyInfo](https://core.telegram.org/bots/api#externalreplyinfo)
- [X] [ReplyParameters](https://core.telegram.org/bots/api#replyparameters)
- [MessageOrigin](https://core.telegram.org/bots/api##messageorigin)
- - [ ] [MessageOriginUser](https://core.telegram.org/bots/api#messageoriginuser)
- - [ ] [MessageOriginHiddenUser](https://core.telegram.org/bots/api#messageoriginhiddenuser)
- - [ ] [MessageOriginChat](https://core.telegram.org/bots/api#messageoriginchat)
- - [ ] [MessageOriginChannel](https://core.telegram.org/bots/api#messageoriginchannel)
- [ ] [PhotoSize](https://core.telegram.org/bots/api#photosize)
- [ ] [Animation](https://core.telegram.org/bots/api#animation)
- [ ] [Audio](https://core.telegram.org/bots/api#audio)
- [ ] [Document](https://core.telegram.org/bots/api#document)
- [ ] [Story](https://core.telegram.org/bots/api#story)
- [ ] [Video](https://core.telegram.org/bots/api#video)
- [ ] [VideoNote](https://core.telegram.org/bots/api#videonote)
- [ ] [Voice](https://core.telegram.org/bots/api#voice)
- [ ] [PaidMediaInfo](https://core.telegram.org/bots/api#paidmediainfo)
- [PaidMedia](https://core.telegram.org/bots/api#paidmedia)
- - [ ] [PaidMediaPreview](https://core.telegram.org/bots/api#paidmediapreview)
- - [ ] [PaidMediaPhoto](https://core.telegram.org/bots/api#paidmediaphoto)
- - [ ] [PaidMediaVideo](https://core.telegram.org/bots/api#paidmediavideo)
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
- [ ] [BackgroundFillFreeformGradient](https://core.telegram.org/bots/api#backgroundfilfreeformgradient)
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
- [ChatMember](https://core.telegram.org/bots/api#chatmember)
- - [ ] [ChatMemberOwner](https://core.telegram.org/bots/api#chatmemberowner)
- - [ ] [ChatMemberAdministrator](https://core.telegram.org/bots/api#chatmemberadministrator)
- - [ ] [ChatMemberMember](https://core.telegram.org/bots/api#chatmembermember)
- - [ ] [ChatMemberRestricted](https://core.telegram.org/bots/api#chatmemberrestricted)
- - [ ] [ChatMemberLeft](https://core.telegram.org/bots/api#chatmemberleft)
- - [ ] [ChatMemberBanned](https://core.telegram.org/bots/api#chatmemberbanned)
- [X] [ChatJoinRequest](https://core.telegram.org/bots/api#chatjoinrequest)
- [ ] [ChatPermissions](https://core.telegram.org/bots/api#chatpermissions)
- [ ] [Birthdate](https://core.telegram.org/bots/api#birthdate)
- [ ] [BusinessIntro](https://core.telegram.org/bots/api#businessintro)
- [ ] [BusinessLocation](https://core.telegram.org/bots/api#businesslocation)
- [ ] [BusinessOpeningHoursInterval](https://core.telegram.org/bots/api#businessopeninghoursinterval)
- [ ] [BusinessOpeningHours](https://core.telegram.org/bots/api#businessopeninghours)
- [ ] [ChatLocation](https://core.telegram.org/bots/api#chatlocation)
- [ReactionType](https://core.telegram.org/bots/api#reactiontype)
- - [ ] [ReactionTypeEmoji](https://core.telegram.org/bots/api#reactiontypeemoji)
- - [ ] [ReactionTypeCustomEmoji](https://core.telegram.org/bots/api#reactiontypecustomemoji)
- - [ ] [ReactionTypePaid](https://core.telegram.org/bots/api#reactiontypepaid)
- [ ] [ReactionCount](https://core.telegram.org/bots/api#reactioncount)
- [ ] [MessageReactionUpdated](https://core.telegram.org/bots/api#messagereactionupdated)
- [ ] [MessageReactionCountUpdated](https://core.telegram.org/bots/api#messagereactioncountupdated)
- [ ] [ForumTopic](https://core.telegram.org/bots/api#forumtopic)
- [X] [BotCommand](https://core.telegram.org/bots/api#botcommand)
- [BotCommandScope](https://core.telegram.org/bots/api#botcommandscope)
- - [X] [BotCommandScopeDefault](https://core.telegram.org/bots/api#botcommandscopedefault)
- - [X] [BotCommandScopeAllPrivateChats](https://core.telegram.org/bots/api#botcommandscopeallprivatechats)
- - [X] [BotCommandScopeAllGroupChats](https://core.telegram.org/bots/api#botcommandscopeallgroupchats)
- - [X] [BotCommandScopeAllChatAdministrators](https://core.telegram.org/bots/api#botcommandscopeallchatadministrators)
- - [X] [BotCommandScopeChat](https://core.telegram.org/bots/api#botcommandscopechat)
- - [X] [BotCommandScopeChatAdministrators](https://core.telegram.org/bots/api#botcommandscopechatadministrators)
- - [X] [BotCommandScopeChatMember](https://core.telegram.org/bots/api#botcommandscopechatmember)
- - [X] [BotName](https://core.telegram.org/bots/api#botname)
- - [X] [BotDescription](https://core.telegram.org/bots/api#botdescription)
- [ ] [BotShortDescription](https://core.telegram.org/bots/api#botshortdescription)
- [MenuButton](https://core.telegram.org/bots/api#menubutton)
- - [ ] [MenuButtonCommands](https://core.telegram.org/bots/api#menubuttoncommands)
- - [ ] [MenuButtonWebApp](https://core.telegram.org/bots/api#menubuttonwebapp)
- - [ ] [MenuButtonDefault](https://core.telegram.org/bots/api#menubuttondefault)
- [ChatBoostSource](https://core.telegram.org/bots/api#chatboostsource)
- - [ ] [ChatBoostSourcePremium](https://core.telegram.org/bots/api#chatboostsourcepremium)
- - [ ] [ChatBoostSourceGiftCode](https://core.telegram.org/bots/api#chatboostsourcegiftcode)
- - [ ] [ChatBoostSourceGiveaway](https://core.telegram.org/bots/api#chatboostsourcegiveaway)
- [ ] [ChatBoost](https://core.telegram.org/bots/api#chatboost)
- [ ] [ChatBoostUpdated](https://core.telegram.org/bots/api#chatboostupdated)
- [ ] [ChatBoostRemoved](https://core.telegram.org/bots/api#chatboostremoved)
- [ ] [UserChatBoosts](https://core.telegram.org/bots/api#userchatboosts)
- [X] [BusinessConnection](https://core.telegram.org/bots/api#businessconnection)
- [X] [BusinessMessagesDeleted](https://core.telegram.org/bots/api#businessmessagesdeleted)
- [ ] [ResponseParameters](https://core.telegram.org/bots/api#responseparameters)
- [InputMedia](https://core.telegram.org/bots/api#inputmedia)
- - [ ] [InputMediaPhoto](https://core.telegram.org/bots/api#inputmediaphoto)
- - [ ] [InputMediaVideo](https://core.telegram.org/bots/api#inputmediavideo)
- - [ ] [InputMediaAnimation](https://core.telegram.org/bots/api#inputmediaanimation)
- - [ ] [InputMediaAudio](https://core.telegram.org/bots/api#inputmediaaudio)
- - [ ] [InputMediaDocument](https://core.telegram.org/bots/api#inputmediadocument)
- [X] [InputFile](https://core.telegram.org/bots/api#inputfile)
- [InputPaidMedia](https://core.telegram.org/bots/api#inputpaidmedia)
- - [ ] [InputPaidMediaPhoto](https://core.telegram.org/bots/api#inputpaidmediaphoto)
- - [ ] [InputPaidMediaVideo](https://core.telegram.org/bots/api#inputpaidmediavideo)

--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

Available methods (7/85 methods implemented):
- [X] [getMe](https://core.telegram.org/bots/api#getme)
- [X] [logOut](https://core.telegram.org/bots/api#logout)
- [X] [close](https://core.telegram.org/bots/api#close)
- [X] [sendMessage](https://core.telegram.org/bots/api#sendmessage)
- [ ] [forwardMessage](https://core.telegram.org/bots/api#forwardmessage)
- [ ] [forwardMessages](https://core.telegram.org/bots/api#forwardmessages)
- [X] [copyMessage](https://core.telegram.org/bots/api#copymessage) *
- [ ] [copyMessages](https://core.telegram.org/bots/api#copymessages)
- [X] [sendPhoto](https://core.telegram.org/bots/api#sendphoto)
- [ ] [sendAudio](https://core.telegram.org/bots/api#sendaudio)
- [ ] [sendDocument](https://core.telegram.org/bots/api#senddocument)
- [ ] [sendVideo](https://core.telegram.org/bots/api#sendvideo)
- [ ] [sendAnimation](https://core.telegram.org/bots/api#sendanimation)
- [ ] [sendVoice](https://core.telegram.org/bots/api#sendvoice)
- [ ] [sendVideoNote](https://core.telegram.org/bots/api#sendvideonote)
- [ ] [sendPaidMedia](https://core.telegram.org/bots/api#sendpaidmedia)
- [ ] [sendMediaGroup](https://core.telegram.org/bots/api#sendmediagroup)
- [ ] [sendLocation](https://core.telegram.org/bots/api#sendlocation)
- [ ] [sendVenue](https://core.telegram.org/bots/api#sendvenue)
- [ ] [sendContact](https://core.telegram.org/bots/api#sendcontact)
- [ ] [sendPoll](https://core.telegram.org/bots/api#sendpoll)
- [ ] [sendDice](https://core.telegram.org/bots/api#senddice)
- [ ] [sendChatAction](https://core.telegram.org/bots/api#sendchataction)
- [ ] [setMessageReaction](https://core.telegram.org/bots/api#setmessagereaction)
- [ ] [getUserProfilePhotos](https://core.telegram.org/bots/api#)
- [ ] [getFile](https://core.telegram.org/bots/api#)
- [ ] [banChatMember](https://core.telegram.org/bots/api#)
- [ ] [unbanChatMember](https://core.telegram.org/bots/api#)
- [ ] [restrictChatMember](https://core.telegram.org/bots/api#)
- [ ] [promoteChatMember](https://core.telegram.org/bots/api#)
- [ ] [setChatAdministratorCustomTitle](https://core.telegram.org/bots/api#)
- [ ] [banChatSenderChat](https://core.telegram.org/bots/api#)
- [ ] [unbanChatSenderChat](https://core.telegram.org/bots/api#)
- [ ] [setChatPermissions](https://core.telegram.org/bots/api#)
- [ ] [exportChatInviteLink](https://core.telegram.org/bots/api#)
- [ ] [createChatInviteLink](https://core.telegram.org/bots/api#)
- [ ] [editChatInviteLink](https://core.telegram.org/bots/api#)
- [ ] [createChatSubscriptionInviteLink](https://core.telegram.org/bots/api#)
- [ ] [editChatSubscriptionInviteLink](https://core.telegram.org/bots/api#)
- [ ] [revokeChatInviteLink](https://core.telegram.org/bots/api#)
- [ ] [approveChatJoinRequest](https://core.telegram.org/bots/api#)
- [ ] [declineChatJoinRequest](https://core.telegram.org/bots/api#)
- [ ] [setChatPhoto](https://core.telegram.org/bots/api#)
- [ ] [deleteChatPhoto](https://core.telegram.org/bots/api#)
- [ ] [setChatTitle](https://core.telegram.org/bots/api#)
- [ ] [setChatDescription](https://core.telegram.org/bots/api#)
- [ ] [pinChatMessage](https://core.telegram.org/bots/api#)
- [ ] [unpinChatMessage](https://core.telegram.org/bots/api#)
- [ ] [unpinAllChatMessages](https://core.telegram.org/bots/api#)
- [ ] [leaveChat](https://core.telegram.org/bots/api#)
- [ ] [getChat](https://core.telegram.org/bots/api#)
- [ ] [getChatAdministrators](https://core.telegram.org/bots/api#)
- [ ] [getChatMemberCount](https://core.telegram.org/bots/api#)
- [ ] [getChatMember](https://core.telegram.org/bots/api#)
- [ ] [setChatStickerSet](https://core.telegram.org/bots/api#)
- [ ] [deleteChatStickerSet](https://core.telegram.org/bots/api#)
- [ ] [getForumTopicIconStickers](https://core.telegram.org/bots/api#)
- [ ] [createForumTopic](https://core.telegram.org/bots/api#)
- [ ] [editForumTopic](https://core.telegram.org/bots/api#)
- [ ] [closeForumTopic](https://core.telegram.org/bots/api#)
- [ ] [reopenForumTopic](https://core.telegram.org/bots/api#)
- [ ] [deleteForumTopic](https://core.telegram.org/bots/api#)
- [ ] [unpinAllForumTopicMessages](https://core.telegram.org/bots/api#)
- [ ] [editGeneralForumTopic](https://core.telegram.org/bots/api#)
- [ ] [closeGeneralForumTopic](https://core.telegram.org/bots/api#)
- [ ] [reopenGeneralForumTopic](https://core.telegram.org/bots/api#)
- [ ] [hideGeneralForumTopic](https://core.telegram.org/bots/api#)
- [ ] [unhideGeneralForumTopic](https://core.telegram.org/bots/api#)
- [ ] [unpinAllGeneralForumTopicMessages](https://core.telegram.org/bots/api#)
- [X] [answerCallbackQuery](https://core.telegram.org/bots/api#answercallbackquery)
- [ ] [getUserChatBoosts](https://core.telegram.org/bots/api#)
- [ ] [getBusinessConnection](https://core.telegram.org/bots/api#)
- [ ] [setMyCommands](https://core.telegram.org/bots/api#)
- [ ] [deleteMyCommands](https://core.telegram.org/bots/api#)
- [ ] [getMyCommands](https://core.telegram.org/bots/api#)
- [ ] [setMyName](https://core.telegram.org/bots/api#)
- [ ] [getMyName](https://core.telegram.org/bots/api#)
- [ ] [setMyDescription](https://core.telegram.org/bots/api#)
- [ ] [getMyDescription](https://core.telegram.org/bots/api#)
- [ ] [setMyShortDescription](https://core.telegram.org/bots/api#)
- [ ] [getMyShortDescription](https://core.telegram.org/bots/api#)
- [ ] [setChatMenuButton](https://core.telegram.org/bots/api#)
- [ ] [getChatMenuButton](https://core.telegram.org/bots/api#)
- [ ] [setMyDefaultAdministratorRights](https://core.telegram.org/bots/api#)
- [ ] [getMyDefaultAdministratorRights](https://core.telegram.org/bots/api#)

\* Experimental bulk (concurrent) version is available. These methods are named like this: `copyMessage()` ---> `_bulkCopyMessage()`

--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

Updating messages (1/9 methods implemented):
- [X] [editMessageText](https://core.telegram.org/bots/api#editmessagetext)
- [ ] [editMessageCaption](https://core.telegram.org/bots/api#editmessagecaption)
- [ ] [editMessageMedia](https://core.telegram.org/bots/api#editmessagemedia)
- [ ] [editMessageLiveLocation](https://core.telegram.org/bots/api#editmessagelivelocation)
- [ ] [stopMessageLiveLocation](https://core.telegram.org/bots/api#stopmessagelivelocation)
- [ ] [editMessageReplyMarkup](https://core.telegram.org/bots/api#editmessagereplymarkup)
- [ ] [stopPoll](https://core.telegram.org/bots/api#stoppoll)
- [ ] [deleteMessage](https://core.telegram.org/bots/api#deletemessage)
- [ ] [deleteMessages](https://core.telegram.org/bots/api#deletemessages)

--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

Stickers (0/16 methods implemented, 0/4 classes implemented):
- [ ] [Sticker](https://core.telegram.org/bots/api#sticker)
- [ ] [StickerSet](https://core.telegram.org/bots/api#stickerset)
- [ ] [MaskPosition](https://core.telegram.org/bots/api#maskposition)
- [ ] [InputSticker](https://core.telegram.org/bots/api#inputsticker)
- [ ] ...

--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

Inline mode (0/2 methods implemented, 3/29 classes implemented + 2 union types):
- [X] [InlineQuery](https://core.telegram.org/bots/api#inlinequery)
- [ ] [answerInlineQuery](https://core.telegram.org/bots/api#answerinlinequery)
- [X] [InlineQueryResultsButton](https://core.telegram.org/bots/api#inlinequeryresultsbutton)
- [InlineQueryResult](https://core.telegram.org/bots/api#inlinequeryresult)
- - [ ] [InlineQueryResultArticle](https://core.telegram.org/bots/api#inlinequeryresultarticle)
- - [ ] [InlineQueryResultPhoto](https://core.telegram.org/bots/api#inlinequeryresultphoto)
- - [ ] [InlineQueryResultGif](https://core.telegram.org/bots/api#inlinequeryresultgif)
- - [ ] [InlineQueryResultMpeg4Gif](https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif)
- - [ ] [InlineQueryResultVideo](https://core.telegram.org/bots/api#inlinequeryresultvideo)
- - [ ] [InlineQueryResultAudio](https://core.telegram.org/bots/api#inlinequeryresultaudio)
- - [ ] [InlineQueryResultVoice](https://core.telegram.org/bots/api#inlinequeryresultvoice)
- - [ ] [InlineQueryResultDocument](https://core.telegram.org/bots/api#inlinequeryresultdocument)
- - [ ] [InlineQueryResultLocation](https://core.telegram.org/bots/api#inlinequeryresultlocation)
- - [ ] [InlineQueryResultVenue](https://core.telegram.org/bots/api#inlinequeryresultvenue)
- - [ ] [InlineQueryResultContact](https://core.telegram.org/bots/api#inlinequeryresultcontact)
- - [ ] [InlineQueryResultGame](https://core.telegram.org/bots/api#inlinequeryresultgame)
- - [ ] [InlineQueryResultCachedPhoto](https://core.telegram.org/bots/api#inlinequeryresultcachedphoto)
- - [ ] [InlineQueryResultCachedGif](https://core.telegram.org/bots/api#inlinequeryresultcachedgif)
- - [ ] [InlineQueryResultCachedMpeg4Gif](https://core.telegram.org/bots/api#inlinequeryresultcachedmpeg4gif)
- - [ ] [InlineQueryResultCachedSticker](https://core.telegram.org/bots/api#inlinequeryresultcachedsticker)
- - [ ] [InlineQueryResultCachedDocument](https://core.telegram.org/bots/api#inlinequeryresultcacheddocument)
- - [ ] [InlineQueryResultCachedVideo](https://core.telegram.org/bots/api#inlinequeryresultcachedvideo)
- - [ ] [InlineQueryResultCachedVoice](https://core.telegram.org/bots/api#inlinequeryresultcachedvoice)
- - [ ] [InlineQueryResultCachedAudio](https://core.telegram.org/bots/api#inlinequeryresultcachedaudio)
- [InputMessageContent](https://core.telegram.org/bots/api#inputmessagecontent)
- - [ ] [InputTextMessageContent](https://core.telegram.org/bots/api#inputtextmessagecontent)
- - [ ] [InputLocationMessageContent](https://core.telegram.org/bots/api#inputlocationmessagecontent)
- - [ ] [InputVenueMessageContent](https://core.telegram.org/bots/api#inputvenuemessagecontent)
- - [ ] [InputContactMessageContent](https://core.telegram.org/bots/api#inputcontactmessagecontent)
- - [ ] [InputInvoiceMessageContent](https://core.telegram.org/bots/api#inputinvoicemessagecontent)
- [X] [ChosenInlineResult](https://core.telegram.org/bots/api#choseninlineresult)
- [ ] [answerWebAppQuery](https://core.telegram.org/bots/api#answerwebappquery)
- [ ] [SentWebAppMessage](https://core.telegram.org/bots/api#sentwebappmessage)

--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

Payments (0/6 methods implemented, 3/19 classes implemented + 2 union types):
- [ ] [sendInvoice](https://core.telegram.org/bots/api#)
- [ ] [createInvoiceLink](https://core.telegram.org/bots/api#)
- [ ] [answerShippingQuery](https://core.telegram.org/bots/api#)
- [ ] [answerPreCheckoutQuery](https://core.telegram.org/bots/api#)
- [ ] [getStarTransactions](https://core.telegram.org/bots/api#)
- [ ] [refundStarPayment](https://core.telegram.org/bots/api#)
- [ ] [LabeledPrice](https://core.telegram.org/bots/api#)
- [ ] [Invoice](https://core.telegram.org/bots/api#invoice)
- [ ] [ShippingAddress](https://core.telegram.org/bots/api#shippingaddress)
- [ ] [OrderInfo](https://core.telegram.org/bots/api#orderinfo)
- [ ] [ShippingOption](https://core.telegram.org/bots/api#shippingoption)
- [ ] [SuccessfulPayment](https://core.telegram.org/bots/api#successfulpayment)
- [ ] [RefundedPayment](https://core.telegram.org/bots/api#refundedpayment)
- [X] [ShippingQuery](https://core.telegram.org/bots/api#shippingquery)
- [X] [PreCheckoutQuery](https://core.telegram.org/bots/api#precheckoutquery)
- [X] [PaidMediaPurchased](https://core.telegram.org/bots/api#paidmediapurchased)
- [RevenueWithdrawalState](https://core.telegram.org/bots/api#)
- - [ ] [RevenueWithdrawalStatePending](https://core.telegram.org/bots/api#)
- - [ ] [RevenueWithdrawalStateSucceeded](https://core.telegram.org/bots/api#)
- - [ ] [RevenueWithdrawalStateFailed](https://core.telegram.org/bots/api#)
- [TransactionPartner](https://core.telegram.org/bots/api#)
- - [ ] [TransactionPartnerUser](https://core.telegram.org/bots/api#)
- - [ ] [TransactionPartnerFragment](https://core.telegram.org/bots/api#)
- - [ ] [TransactionPartnerTelegramAds](https://core.telegram.org/bots/api#)
- - [ ] [TransactionPartnerOther](https://core.telegram.org/bots/api#)
- [ ] [StarTransaction](https://core.telegram.org/bots/api#)
- [ ] [StarTransactions](https://core.telegram.org/bots/api#)


--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

Telegram Passport (0/1 methods implemented, 0/13 classes implemented + 1 union type):
- [ ] [PassportData](https://core.telegram.org/bots/api#passportdata)
- [ ] [PassportFile](https://core.telegram.org/bots/api#)
- [ ] [EncryptedPassportElement](https://core.telegram.org/bots/api#)
- [ ] [EncryptedCredentials](https://core.telegram.org/bots/api#)
- [ ] [setPassportDataErrors](https://core.telegram.org/bots/api#)
- [PassportElementError](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorDataField](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorFrontSide](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorReverseSide](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorSelfie](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorFile](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorFiles](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorTranslationFile](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorTranslationFiles](https://core.telegram.org/bots/api#)
- - [ ] [PassportElementErrorUnspecified](https://core.telegram.org/bots/api#)

--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

Games (0/3 methods implemented, 0/3 classes implemented):
- [ ] [sendGame](https://core.telegram.org/bots/api#sendgame)
- [ ] [Game](https://core.telegram.org/bots/api#game)
- [ ] [CallbackGame](https://core.telegram.org/bots/api#callbackgame)
- [ ] [setGameScore](https://core.telegram.org/bots/api#setgamescore)
- [ ] [setGameHighScores](https://core.telegram.org/bots/api#setgamehighscores)
- [ ] [GameHighScore](https://core.telegram.org/bots/api#gamehighscore)