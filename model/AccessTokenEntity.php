<?php

namespace Oauth2\Entities;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use DateTimeImmutable;

class AccessTokenEntity implements AccessTokenEntityInterface
{
    use AccessTokenTrait, EntityTrait;

    protected $identifier;
    protected $expiryDateTime;
    protected $client;
    protected $scopes = [];
    protected $userIdentifier;

    public function setUserIdentifier($userIdentifier)
    {
        $this->userIdentifier = $userIdentifier;
    }

    public function getUserIdentifier()
    {
        return $this->userIdentifier;
    }

    public function __construct()
    {
        $this->identifier = bin2hex(random_bytes(40)); // Generate a random identifier
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function setExpiryDateTime(DateTimeImmutable $dateTime)
    {
        $this->expiryDateTime = $dateTime;
    }

    public function getExpiryDateTime()
    {
        return $this->expiryDateTime;
    }

    public function setClient(ClientEntityInterface $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function addScope(ScopeEntityInterface $scope)
    {
        $this->scopes[] = $scope;
    }

    public function getScopes()
    {
        return $this->scopes;
    }
}
