# MsgOwl Notification Channel For Laravel

[![Run PHP Unit Tests](https://github.com/boring-dragon/msgowl-laravel-notification-channel/actions/workflows/test.yml/badge.svg)](https://github.com/boring-dragon/msgowl-laravel-notification-channel/actions/workflows/test.yml)

## Installation

You can install the package via composer:

```bash
composer require boring-dragon/msgowl-laravel-notification-channel
```

## Setting up your MsgOwl Credentials

Add the environment variables to your `config/services.php`:

```php
// config/services.php
...
'msgowl' => [
    'sender_id' => env('MSGOWL_SENDER_ID'),
    'api_key' => env('MSGOWL_API_KEY'),
    'recipients' => env('MSGOWL_RECIPIENTS'),
],
...
```

Add your MsgOwl API Key, Default SenderID and default recipients to your `.env`:

```php
// .env
...
    MSGOWL_SENDER_ID=
    MSGOWL_API_KEY=
    MSGOWL_RECIPIENTS=
],
...
````

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlChannel;
use BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlMessage;
use Illuminate\Notifications\Notification;

class UserApproved extends Notification
{
    public function via($notifiable)
    {
        return [MsgOwlChannel::class];
    }

    public function toMsgOwl($notifiable)
    {
        return (new MsgOwlMessage("You are approved by the system"));
    }
}
```

you can add recipients (single value or array)

``` php
return (new MsgOwlMessage("You are approved by the system"))->setRecipients($recipients);
```

Or You can add  a `routeNotificationForMsgOwl` method to your Notifiable model to return the phone number(s):

```php
public function routeNotificationForMsgOwl() : string
{
    return $this->mobile;
}
```

## Reference 

- [ Msg Owl Api Docs ](https://msgowl.com/docs)

## Security

If you discover any security related issues, please email boringdragon98@gmail.com instead of using the issue tracker.

## Credits

- [boring-dragon](https://github.com/boring-dragon)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Disclaimer

This package is not in any way officially affiliated with MsgOwl.
