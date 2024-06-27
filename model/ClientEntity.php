<?php

namespace Oauth2\Entities;

use League\OAuth2\Server\Entities\ClientEntityInterface;

class ClientEntity implements ClientEntityInterface
{
    private $identifier;
    private $name;
    private $redirectUri;
    private $isConfidential;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function isConfidential()
    {
        return $this->isConfidential;
    }

    public function setConfidential($isConfidential)
    {
        $this->isConfidential = $isConfidential;
    }
}
