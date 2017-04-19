<?php

namespace Pachico\BelugaCDN;

use Curl\Curl;
use Webmozart\Assert\Assert;

class CacheInvalidation
{
    const URL_INVALIDATE_CACHE = 'https://api.belugacdn.com/api/cdn/v2/invalidations';

    /**
     * @var Curl
     */
    private $httpClient;

    /**
     * @var Auth\AuthenticationInterface
     */
    private $authentication;

    /**
     * @param Auth\AuthenticationInterface $authentication
     * @param Curl $httpClient
     */
    public function __construct(Auth\AuthenticationInterface $authentication, Curl $httpClient = null)
    {
        $this->authentication = $authentication;
        $this->httpClient = $httpClient ?: new Curl();

        $this->httpClient->setHeaders(
            [
            'authorization' => 'Basic '.$this->authentication->getToken(),
            'content-type' => 'application/json',
            'accept' => 'application/json',
            'accept-encoding'=> 'gzip, deflate'
            ]
        );
    }

    /**
     * @param array $urls
     * @param int $limitRecords
     *
     * @return array
     *
     * @throws \Exception
     */
    public function invalidateCache(array $urls, $limitRecords = null)
    {
        Assert::notEmpty($urls, 'Array of urls to invalidate is empty');

        $curl = clone $this->httpClient;
        $data = ['urls' => []];

        foreach ($urls as $url) {
            $data['urls'][] = ['url' => $url];
        }

        if (null !== $limitRecords) {
            Assert::greaterThan($limitRecords, 0, 'Limit records value must be integer > 0');
            $data['limit-records'] = $limitRecords;
        }

        $curl->post(static::URL_INVALIDATE_CACHE, $data);

        if ($curl->error) {
            throw new \Exception($curl->errorMessage, $curl->errorCode);
        }

        $response = $curl->response;

        unset($curl);

        return json_decode($response, true);
    }
}
