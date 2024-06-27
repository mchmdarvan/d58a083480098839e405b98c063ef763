<?php
require '../vendor/autoload.php';

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\CryptKey;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use Oauth2\ClientRepository;
use Oauth2\AccessTokenRepository;
use Oauth2\ScopeRepository;

$privateKeyPath = 'file://C:/xampp/htdocs/levart-code-challenge/private.key';
$encryptionKey = 'base64encodedkey'; // Use a securely generated encryption key

$clientRepository = new ClientRepository();
$accessTokenRepository = new AccessTokenRepository();
$scopeRepository = new ScopeRepository();

$privateKey = new CryptKey($privateKeyPath, 'kurokos11'); // Include the passphrase if the private key is encrypted

$server = new AuthorizationServer(
    $clientRepository,
    $accessTokenRepository,
    $scopeRepository,
    $privateKey,
    $encryptionKey
);

$grant = new ClientCredentialsGrant();
$server->enableGrantType($grant, new \DateInterval('PT1H'));

return $server;
