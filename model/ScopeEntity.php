<?php

namespace Oauth2\Entities;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

class ScopeEntity implements ScopeEntityInterface
{
    private $identifier;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function jsonSerialize()
    {
        return $this->identifier;
    }
}
