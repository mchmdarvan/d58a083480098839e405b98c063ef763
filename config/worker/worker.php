<?php
require 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('email_queue', false, false, false, false);

echo ' [*] Waiting for messages. To exit, press CTRL+C', "\n";

$callback = function ($msg) {
    echo " [x] Received ", $msg->body, "\n";
    $emailTask = json_decode($msg->body, true);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mafriendhello372@gmail.com'; // Your Gmail address
        $mail->Password = 'agrp szew ndya sxwx'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('mafriendhello372@gmail.com', 'Mailer');
        $mail->addAddress($emailTask['recipient']);
        $mail->isHTML(true);
        $mail->Subject = $emailTask['subject'];
        $mail->Body    = $emailTask['body'];

        $mail->send();
        // Insert email data into the database
        $mysqli = new mysqli("localhost", "root", "", "email_api");
        $stmt = $mysqli->prepare("INSERT INTO emails (recipient, subject, body) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $emailTask['recipient'], $emailTask['subject'], $emailTask['body']);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();

        echo " [x] Email sent to {$emailTask['recipient']}\n";
    } catch (Exception $e) {
        echo " [x] Email could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
    }
};

$channel->basic_consume('email_queue', '', false, true, false, false, $callback);

while (true) {
    try {
        $channel->wait(null, false, 5); // Wait for messages, timeout after 5 seconds
    } catch (PhpAmqpLib\Exception\AMQPTimeoutException $e) {
        // Timeout exception, handle as needed (e.g., log, retry, exit loop)
        continue;
    } catch (Exception $e) {
        echo " [x] Error: {$e->getMessage()}\n";
        break; // Exit loop on other exceptions
    }
}

$channel->close();
$connection->close();
