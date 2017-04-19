# BelugaCDN

Simple library to interact with BelugaCDN API.
Current version only includes **cache invalidation** functionality.

## Install

Via Composer

``` bash
$ composer require pachico/belugacdn
```

## Usage

``` php
use Pachico\BelugaCDN;

try {

    $auth = new BelugaCDN\Auth\Token('mytoken');
    $client = new BelugaCDN\CacheInvalidation($auth);

    $response = $client->invalidateCache([
        'http://cdn.mysite.com/picture.jpg',
        'http://cdn.mysite.com/html.html'
        ]);

    var_dump($response);

} catch (\Exception $exc) {
    echo $exc->getMessage();
}

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email pachicodev@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

