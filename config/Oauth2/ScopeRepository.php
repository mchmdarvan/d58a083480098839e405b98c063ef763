<?php

namespace Oauth2;

use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use Oauth2\Entities\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($identifier)
    {
        $scope = new ScopeEntity();
        $scope->setIdentifier($identifier);
        return $scope;
    }

    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        // Optionally, you can finalize scopes here based on your business logic
        return $scopes;
    }
}
