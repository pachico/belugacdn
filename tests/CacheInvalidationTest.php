<?php

namespace Pachico\BelugaCDN;

class CacheInvalidationTest extends \PHPUnit\Framework\TestCase
{

    public function testInvalidateCacheCallsAPIAndReturnsArray()
    {
        // Arrange
        $authentication = new Auth\Token('mytoken');
        $httpClient = $this->getMockBuilder(\Curl\Curl::class)->getMock();
        $httpClient->expects($spy = $this->once())->method('post');
        $httpClient->response = '{
            "urls" : [
               {
                  "uuid" : "6a1ab3de-3e6d-4d92-a172-18b175ea202c",
                  "url" : "http://cdn.mysite.com/picture.jpg",
                  "message" : "",
                  "status" : "pending"
               }
            ]
         }';

        $sut = new CacheInvalidation($authentication, $httpClient);
        // Act
        $result = $sut->invalidateCache(['http://cdn.mysite.com/picture.jpg'], 5000);
        $invocations = $spy->getInvocations();
        // Assert
        $this->assertCount(1, $invocations);
        $this->assertSame(
            [
            'urls' => [
                [
                    'uuid' => '6a1ab3de-3e6d-4d92-a172-18b175ea202c',
                    'url' => 'http://cdn.mysite.com/picture.jpg',
                    'message' => '',
                    'status' => 'pending',
                ],
            ]],
            $result
        );

        $this->assertSame(
            [
            'https://api.belugacdn.com/api/cdn/v2/invalidations',
            [
                'urls' => [['url' => 'http://cdn.mysite.com/picture.jpg']],
                'limit-records' => 5000
            ],
            false],
            $invocations[0]->parameters
        );
    }

    public function testInvalidLimitRecordsThrowsException()
    {
        // Arrange
        $this->expectException(\InvalidArgumentException::class);
        $authentication = new Auth\Token('mytoken');
        $httpClient = $this->getMockBuilder(\Curl\Curl::class)->getMock();
        $sut = new CacheInvalidation($authentication, $httpClient);
        // Act
        $sut->invalidateCache(['http://cdn.mysite.com/picture.jpg'], 'not a valid int');
    }

    public function testEmptyArrayOfUrlsThrowsException()
    {
        // Arrange
        $this->expectException(\InvalidArgumentException::class);
        $authentication = new Auth\Token('mytoken');
        $httpClient = $this->getMockBuilder(\Curl\Curl::class)->getMock();
        $sut = new CacheInvalidation($authentication, $httpClient);
        // Act
        $sut->invalidateCache([]);
    }

    public function testIfHttpClientErrorReturnsException()
    {
        // Arrange
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Message');
        $authentication = new Auth\Token('mytoken');
        $httpClient = $this->getMockBuilder(\Curl\Curl::class)->getMock();
        $httpClient->error = true;
        $httpClient->errorMessage = 'Message';
        $httpClient->errorCode = 400;
        $sut = new CacheInvalidation($authentication, $httpClient);
        // Act
        $sut->invalidateCache(['http://cdn.mysite.com/picture.jpg']);
        // Assert
    }
}
