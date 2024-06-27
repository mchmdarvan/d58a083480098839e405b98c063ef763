<?php
require '../vendor/autoload.php';

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\CryptKey;
use Oauth2\ClientRepository;
use Oauth2\AccessTokenRepository;
use Oauth2\ScopeRepository;

$clientRepository = new ClientRepository();
$accessTokenRepository = new AccessTokenRepository();
$scopeRepository = new ScopeRepository();

$privateKeyPath = 'file:///C:/xampp/htdocs/levart-code-challenge/private.key';
$publicKeyPath = 'file:///C:/xampp/htdocs/levart-code-challenge/public.key';
$encryptionKey = 'base64encodedkey';
$passphrase = 'kurokos11';

try {
    // Create CryptKey instance for private key
    $privateKey = new CryptKey($privateKeyPath, $passphrase);

    // Create AuthorizationServer instance
    $server = new AuthorizationServer(
        $clientRepository,
        $accessTokenRepository,
        $scopeRepository,
        $privateKey,
        $encryptionKey
    );

    // Enable client credentials grant type
    $grant = new ClientCredentialsGrant();
    $server->enableGrantType($grant, new \DateInterval('PT1H'));

    // Create a PSR-7 request object
    $request = ServerRequestFactory::fromGlobals();

    // Create a response object
    $response = new Response();

    // Try to respond to the access token request
    $response = $server->respondToAccessTokenRequest($request, $response);

    // Emit the HTTP response
    (new Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
} catch (OAuthServerException $exception) {
    // Handle OAuth server exceptions
    $exception->generateHttpResponse($response);
} catch (Exception $exception) {
    // Handle other exceptions
    $response->getBody()->write($exception->getMessage());
    return $response->withStatus(500);
}
