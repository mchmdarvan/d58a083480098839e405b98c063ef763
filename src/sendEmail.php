<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Server\ResourceServer;
use Laminas\Diactoros\ServerRequestFactory;
use Oauth2\AccessTokenRepository;

$publicKeyPath = 'file://C:/xampp/htdocs/levart-code-challenge/public.key';
$accessTokenRepository = new AccessTokenRepository();

$server = new ResourceServer(
    $accessTokenRepository,
    $publicKeyPath
);

$request = ServerRequestFactory::fromGlobals();
$response = array();
try {
    $request = $server->validateAuthenticatedRequest($request);

    $recipient = $request->getParsedBody()['recipient'];
    $subject = $request->getParsedBody()['subject'];
    $body = $request->getParsedBody()['body'];
    // echo $recipient;
    // echo $subject;
    // echo $body;
    // die;

    $request = $server->validateAuthenticatedRequest($request);

    $recipient = $request->getParsedBody()['recipient'];
    $subject = $request->getParsedBody()['subject'];
    $body = $request->getParsedBody()['body'];

    // Send email using Gmail SMTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mafriendhello372@gmail.com'; // Your Gmail address
        $mail->Password = 'agrp szew ndya sxwx'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('mafriendhello372@gmail.com', 'Mailer'); // Your Gmail address
        $mail->addAddress($recipient);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        // Insert email data into the database
        $mysqli = new mysqli("localhost", "root", "", "email_api");
        $stmt = $mysqli->prepare("INSERT INTO emails (recipient, subject, body) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $recipient, $subject, $body);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Message has been stored'
        ];

        echo json_encode($response);
    } catch (Exception $e) {
        // Handle PHPMailer exceptions
        $response = [
            'status' => 'error',
            'message' => 'Mailer Error: ' . $mail->ErrorInfo
        ];

        echo json_encode($response);
    }

    // Send JSON response with success status
} catch (OAuthServerException $exception) {
    return $exception->generateHttpResponse($response);
} catch (Exception $exception) {
    $response = [
        'code' => 500,
        'status' => 'error',
        'message' => $exception->getMessage()
    ];


    echo json_encode($response);
}
