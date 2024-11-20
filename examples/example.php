<?php

require_once './vendor/autoload.php';

// Just in case you have not installed the awesome 'symfony/var-dumper' package for beautiful dump outputs:
if (!function_exists('dump')) {
    function dump(mixed ...$vars)
    {
        var_dump('dump:', ...$vars);
    }
}

// * IMPORTANT: Look for 'test_data.sample.php' in the same directory and fill it with required information, then rename to 'test_data.php'

require_once dirname(__FILE__) . '/test_data.php'; // Includes $token, $some_chat_id and $options

// --- --- --- --- --- --- ---

use Litegram\Update;
use Litegram\CopyMessageParams;
use Litegram\InlineKeyboardButton;
use Litegram\InlineKeyboardMarkup;
use Litegram\InputFile;
use Litegram\ReplyParameters;
use Litegram\TelegramMethods;
use Litegram\SendMessageParams;
use Litegram\SendPhotoParams;

try {
    // TODO: Add example for receiving updates manually (via getUpdates method)

    // runExampleForReceivingUpdatesFromWebhook();

    runExampleForGetMe();

    runExampleForSendMessage();

    runExampleForSendPhoto();

    runExampleFor_bulkCopyMessage();
} catch (\Throwable $th) {
    dump('Exception:', $th);
}

function runExampleForReceivingUpdatesFromWebhook()
{
    // * IMPORTANT: Make sure you have set up webhook
    $update_str = file_get_contents('php://input');

    if (!$update_str) {
        error_log('No update was received from webhook!');
        exit(0);
    }

    try {
        $update = new Update(init_data: json_decode($update_str));
        dump($update);
    } catch (\Throwable $th) {
        dump('Exception:', $th);
    }
}

function runExampleForGetMe()
{
    global $token, $guzzle_options;

    // If the request doesn't fail, an object of type Litegram\User will be returned
    $res = TelegramMethods::getMe(
        token: $token,
        guzzle_options: $guzzle_options,
    );
    dump('Result:', $res);
}

function runExampleForSendMessage()
{
    global $token, $some_chat_id, $guzzle_options;

    // If the request doesn't fail, an object of type Litegram\Message will be returned
    $res = TelegramMethods::sendMessage(
        token: $token,
        params: new SendMessageParams(
            chat_id: $some_chat_id,
            text: 'Test',
            reply_markup: new InlineKeyboardMarkup([
                [
                    new InlineKeyboardButton('Hi', callback_data: 'say_hi'),
                    new InlineKeyboardButton('Bye', callback_data: 'say_bye'),
                ],
                [new InlineKeyboardButton('Close', callback_data: 'close')],
            ]),
        ),
        guzzle_options: $guzzle_options,
    );
    dump('Result:', $res);
}

function runExampleForSendPhoto()
{
    global $token, $some_chat_id, $guzzle_options;

    // If the request doesn't fail, an object of type Litegram\Message will be returned
    $res = TelegramMethods::sendPhoto(
        token: $token,
        params: new SendPhotoParams(
            chat_id: $some_chat_id,
            photo: new InputFile('/home/amir/test.jpg'),
            caption: 'Look at this beautiful landscape!',
            show_caption_above_media: true,
        ),
        guzzle_options: $guzzle_options,
    );
    dump('Result:', $res);
}

function runExampleFor_bulkCopyMessage()
{
    global $token, $some_chat_id, $guzzle_options;

    // Returns a promise of type GuzzleHttp\Promise\PromiseInterface.
    // Make sure to use ->wait method to pause execution until the every promise is either resolved or rejected
    $promise = TelegramMethods::_bulkCopyMessage(
        token: $token,
        array_of_params: [
            new CopyMessageParams(
                chat_id: $some_chat_id,
                from_chat_id: $some_chat_id,
                message_id: 325,
                caption: 'Copied the message and changed the caption!',
                reply_parameters: new ReplyParameters(
                    message_id: 325,
                    chat_id: $some_chat_id,
                    allow_sending_without_reply: true,
                ),
            ),
            new CopyMessageParams(
                chat_id: $some_chat_id,
                from_chat_id: $some_chat_id,
                message_id: 326,
                caption: 'Copied the message and changed the caption!',
                reply_parameters: new ReplyParameters(
                    message_id: 326,
                    chat_id: $some_chat_id,
                    allow_sending_without_reply: true,
                ),
            ),
        ],
        guzzle_options: $guzzle_options,
    );
    dump('Result:', $promise->wait());
}
