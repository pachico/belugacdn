<?php

namespace Pachico\BelugaCDN\Auth;

class Credential implements AuthenticationInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $username
     * @param string $password
     */
    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return base64_encode($this->username.':'.$this->password);
    }
}
