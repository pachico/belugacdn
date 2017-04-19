<?php

namespace Pachico\BelugaCDN\Auth;

class Token implements AuthenticationInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return strings
     */
    public function getToken()
    {
        return $this->token;
    }
}
