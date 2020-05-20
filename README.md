# Laravel Kiyoh Reviews
[![marshmallow-transparent-logo](https://cdn.marshmallow-office.com/media/images/logo/marshmallow.transparent.red.png)](https://marshmallow.dev)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/reviews/kiyoh.svg)](https://packagist.org/packages/marshmallow/reviews/kiyoh)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/reviews/kiyoh.svg)](https://packagist.org/packages/marshmallow/reviews/kiyoh)
[![License](https://img.shields.io/packagist/l/marshmallow/reviews/kiyoh.svg)](https://gitlab.com/marshmallowdev)
[![Stars](https://img.shields.io/badge/dynamic/json.svg?label=stars&url=https://gitlab.com/api/v4/projects/18898819&query=$.star_count&colorB=yellow)](https://gitlab.com/marshmallowdev)
[![Forks](https://img.shields.io/badge/dynamic/json.svg?label=forks&url=https://gitlab.com/api/v4/projects/18898819&query=$.forks_count&colorB=brightgreen)](https://gitlab.com/marshmallowdev)


## Setup
To start using Kiyoh you need to publish the config and update the config accordingly. You need to add `hash`, `location_id` and `feed_hash` to `config/kiyoh.php`.
```bash
php artisan vendor:publish --provider="Marshmallow\Reviews\Kiyoh\ServiceProvider"
```

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

                /**
                 * Always end with invite()
                 */
                ->invite();

} catch (KiyohException $e) {
    /**
     * You should always try-catch this. Kiyoh can
     * through an error if someone has already received
     * an invitation. If this is thrown, you don't want
     * you code to be killed!
     */
}
```

## Feed aggregate information
Using feed information is very easy. Use the `Kiyoh` facade to access feed data. Available methods are listed below. Please note that by default the XML feed of Kiyoh will be cached using your default `CACHE_DRIVER`. The feed will be cached for 1 hour. You can change this in `config/kiyoh.php`. If for some reason the feed is unavailable an exeption will be thrown. If you are using these methods in blade you can prefix the methods with `dontFail()`. If you use `dontFail()` all methods will return `0`.

```php
use Marshmallow\Reviews\Kiyoh\Facades\Kiyoh;

Kiyoh::average();
Kiyoh::dontFail()->average();
```

### Available methods
 - Kiyoh::average()
 - Kiyoh::count()
 - Kiyoh::average12months()
 - Kiyoh::count12months()
 - Kiyoh::recommendation()

- - -

Copyright (c) 2020 marshmallow.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
