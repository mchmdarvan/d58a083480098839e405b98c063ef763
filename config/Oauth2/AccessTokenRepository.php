<?php

namespace Oauth2;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use Oauth2\Entities\AccessTokenEntity;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $mysqli = new \mysqli("localhost", "root", "", "email_api");
        $stmt = $mysqli->prepare("INSERT INTO oauth_access_tokens (id, client_id, user_id, expiry, scopes) VALUES (?, ?, ?, ?, ?)");

        // Check if prepare() failed
        if (!$stmt) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        // Retrieve necessary data
        $identifier = $accessTokenEntity->getIdentifier();
        $clientId = $accessTokenEntity->getClient()->getIdentifier();
        $userIdentifier = $accessTokenEntity->getUserIdentifier();
        $expiryDateTime = $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s');

        // Debug: Print scopes
        $accessTokenScopes = $accessTokenEntity->getScopes(); // Debugging

        // Handle scopes
        $scopes = '';
        if (!empty($accessTokenScopes)) {
            $scopes = implode(' ', array_map(function (ScopeEntityInterface $scope) {
                return $scope->getIdentifier();
            }, $accessTokenScopes));
        }

        // Bind parameters
        $stmt->bind_param("sssss", $identifier, $clientId, $userIdentifier, $expiryDateTime, $scopes);

        // Execute the statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            exit;
        }

        // Close statement and connection
        $stmt->close();
        $mysqli->close();
    }

    public function revokeAccessToken($tokenId)
    {
        $mysqli = new \mysqli("localhost", "root", "", "email_api");
        $stmt = $mysqli->prepare("UPDATE oauth_access_tokens SET revoked = 1 WHERE id = ?");
        $stmt->bind_param("s", $tokenId);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }

    public function isAccessTokenRevoked($tokenId)
    {
        $mysqli = new \mysqli("localhost", "root", "", "email_api");
        $stmt = $mysqli->prepare("SELECT revoked FROM oauth_access_tokens WHERE id = ?");
        $stmt->bind_param("s", $tokenId);
        $stmt->execute();
        $result = $stmt->get_result();
        $tokenData = $result->fetch_assoc();
        $stmt->close();
        $mysqli->close();

        return $tokenData['revoked'] == 1;
    }

    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        return $accessToken;
    }
}
