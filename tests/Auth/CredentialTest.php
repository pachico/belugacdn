<?php

namespace Pachico\BelugaCDN\Auth;

class CredentialTest extends \PHPUnit\Framework\TestCase
{

    public function testGetTokenCreatesValidBasicAuthToken()
    {
        // Arrange
        $sut = new Credential('foo', 'bar');
        // Act
        $token = $sut->getToken();
        // Assert
        $this->assertSame('Zm9vOmJhcg==', $token);
    }
}
