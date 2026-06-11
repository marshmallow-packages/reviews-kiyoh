[![marshmallow-transparent-logo](https://cdn.marshmallow-office.com/media/images/logo/marshmallow.transparent.red.png)](https://marshmallow.dev)

# Laravel Kiyoh Reviews

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/reviews-kiyoh.svg)](https://packagist.org/packages/marshmallow/reviews-kiyoh)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/reviews-kiyoh.svg)](https://packagist.org/packages/marshmallow/reviews-kiyoh)
[![License](https://img.shields.io/packagist/l/marshmallow/reviews-kiyoh.svg)](https://github.com/marshmallow-packages/reviews-kiyoh/blob/main/LICENSE.md)

Connect your [Kiyoh](https://www.kiyoh.com/) account to your Laravel application. Send review invitations, pull your aggregated feed (average score, review count, recommendation), and optionally store reviews in your own database.

## Installation

You can install this package using composer.

```bash
composer require marshmallow/reviews-kiyoh
```

The service provider is auto-discovered. The `Kiyoh`, `KiyohInvite` and `KiyohProduct` facades are registered automatically.

## Setup

To start using Kiyoh you need to publish the config and update it accordingly. At a minimum you need to add `hash`, `location_id` and `feed_hash` to `config/kiyoh.php` (or set the matching environment variables).

```bash
php artisan vendor:publish --provider="Marshmallow\Reviews\Kiyoh\ServiceProvider"
```

### Configuration

All keys live in `config/kiyoh.php`. The most common values can be set through environment variables:

| Config key               | Env variable                | Default                                                                  | Description                                                |
| ------------------------ | --------------------------- | ------------------------------------------------------------------------ | ---------------------------------------------------------- |
| `hash`                   | `KIYOH_INVITE_HASH`         | `null`                                                                    | Hash used to authenticate review invitations.             |
| `location_id`            | `KIYOH_LOCATION_ID`         | `null`                                                                    | Your Kiyoh location id.                                    |
| `language`               | `KIYOH_LANGUAGE`            | `nl`                                                                      | Language used for invitations.                            |
| `delay`                  | `KIYOH_INVITE_DELAY_IN_DAYS`| `3`                                                                       | Default delay (in days) before an invitation is sent.     |
| `feed_hash`              | `KIYOH_FEED_HASH`           | `null`                                                                    | Hash used to read the public review feed.                 |
| `cache_feed_in_seconds`  | `KIYOH_FEED_CACHE_TTL`      | `3600`                                                                    | How long the feed is cached, in seconds.                  |
| `cache_name`             | `KIYOH_FEED_CACHE_NAME`     | `kiyoh_reviews_object`                                                    | Cache key under which the feed is stored.                 |
| `publication_api_token`  | `KIYOH_PUBLICATION_API_TOKEN`| `null`                                                                   | API token used for product publication endpoints.        |
| `models.product`         | —                           | `Marshmallow\Reviews\Kiyoh\Models\KiyohProduct`                          | Model used to represent a Kiyoh product.                  |

The `invite_path`, `review_path`, `product_path` and `product_review_path` keys hold the Kiyoh API endpoints and normally do not need to be changed.

## Invites

```php

use Marshmallow\Reviews\Kiyoh\Facades\KiyohInvite;
use Marshmallow\Reviews\Kiyoh\Exceptions\KiyohException;

try {

    KiyohInvite::email('stef@marshmallow.dev')
                /**
                 * Optional
                 */
                ->supplier('Marshmallow')
                ->firstName('Stef')
                ->lastName('van Esch')
                ->refCode('Order: #1001')
                ->city('Alphen aan den Rijn')

                ->delayIgnoreWeekend(3)

                /**
                 * Always end with invite()
                 */
                ->invite();

} catch (KiyohException $e) {
    /**
     * You should always try-catch this. Kiyoh can
     * throw an error if someone has already received
     * an invitation. If this is thrown, you don't want
     * your code to be killed!
     */
}
```

## Feed aggregate information

Using feed information is very easy. Use the `Kiyoh` facade to access feed data. Available methods are listed below. Please note that by default the XML feed of Kiyoh will be cached using your default `CACHE_DRIVER`. The feed will be cached for 1 hour. You can change this in `config/kiyoh.php`. If for some reason the feed is unavailable an exception will be thrown. If you are using these methods in blade you can prefix the methods with `dontFail()`. If you use `dontFail()` all methods will return `0`.

```php
use Marshmallow\Reviews\Kiyoh\Facades\Kiyoh;

Kiyoh::feed()->average()
Kiyoh::dontFail()->feed()->average();
```

### Available methods

-   Kiyoh::feed()->average()
-   Kiyoh::feed()->count()
-   Kiyoh::feed()->average12months()
-   Kiyoh::feed()->count12months()
-   Kiyoh::feed()->recommendation()

-   Kiyoh::feed()->getAttribute('average')

## Store the reviews in your own database

If you wish to get all the reviews and store them in your own database or do whatever with it, you can get them with the methods below:

```php
$reviews = Kiyoh::withoutCache()->feed();
foreach ($reviews as $review) {
    // Do your own magic here
}
```

The package also ships an artisan command that loads the uncached feed for you, ready to be extended with your own persistence logic:

```bash
php artisan kiyoh:store-reviews-in-database
```

## Products

```bash
php artisan marshmallow:resource KiyohProduct Reviews\\Kiyoh
```

## Tests during development

```bash
php artisan test packages/marshmallow/reviews/kiyoh
```

## Credits

-   [Stef van Esch](https://github.com/marshmallow-packages)
-   [All Contributors](https://github.com/marshmallow-packages/reviews-kiyoh/contributors)

## Security

If you discover any security related issues, please email stef@marshmallow.dev instead of using the issue tracker.

## License

The MIT License (MIT). Please see the [License File](LICENSE.md) for more information.

---

Copyright (c) 2020 marshmallow.
