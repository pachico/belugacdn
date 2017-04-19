<?php

namespace Pachico\BelugaCDN\Auth;

class TokenTest extends \PHPUnit\Framework\TestCase
{

    public function testGetTokenReturnsWhatPassedByConstructor()
    {
        // Arrange
        $sut = new Token('mytoken');
        // Act
        $token = $sut->getToken();
        // Assert
        $this->assertSame('mytoken', $token);
    }
}
