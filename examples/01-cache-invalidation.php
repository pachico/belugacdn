<?php

require __DIR__.'/../vendor/autoload.php';

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
