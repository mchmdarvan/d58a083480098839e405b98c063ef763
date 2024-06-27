<?php

namespace Oauth2;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Oauth2\Entities\ClientEntity;

class ClientRepository implements ClientRepositoryInterface
{
    public function getClientEntity($clientIdentifier)
    {
        $mysqli = new \mysqli("localhost", "root", "", "email_api");
        if ($mysqli->connect_error) {
            throw new \Exception('Database connection error');
        }

        $stmt = $mysqli->prepare("SELECT id, name, redirect_uri, is_confidential FROM oauth_clients WHERE id = ?");
        $stmt->bind_param("s", $clientIdentifier);
        $stmt->execute();
        $result = $stmt->get_result();
        $clientData = $result->fetch_assoc();
        $stmt->close();
        $mysqli->close();

        if ($clientData) {
            $client = new ClientEntity();
            $client->setIdentifier($clientData['id']);
            $client->setName($clientData['name']);
            $client->setRedirectUri($clientData['redirect_uri']);
            $client->setConfidential((bool)$clientData['is_confidential']);
            return $client;
        }

        return null;
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $mysqli = new \mysqli("localhost", "root", "", "email_api");
        if ($mysqli->connect_error) {
            throw new \Exception('Database connection error');
        }

        $stmt = $mysqli->prepare("SELECT secret FROM oauth_clients WHERE id = ?");
        $stmt->bind_param("s", $clientIdentifier);
        $stmt->execute();
        $result = $stmt->get_result();
        $clientData = $result->fetch_assoc();
        $stmt->close();
        $mysqli->close();

        if ($clientData && password_verify($clientSecret, $clientData['secret'])) {
            return true;
        }

        return false;
    }
}
