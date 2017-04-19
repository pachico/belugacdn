<?php

namespace Pachico\BelugaCDN\Auth;

interface AuthenticationInterface
{
    /**
     * @return string
     */
    public function getToken();
}
