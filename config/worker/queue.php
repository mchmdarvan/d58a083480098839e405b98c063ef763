<?php
require 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('email_queue', false, false, false, false);

$emailTask = [
    'recipient' => 'aldifathurr@gmail.com',
    'subject' => 'Test Subject',
    'body' => 'Test Body'
];

$msg = new AMQPMessage(json_encode($emailTask));
$channel->basic_publish($msg, '', 'email_queue');

echo " [x] Sent email task\n";

$channel->close();
$connection->close();
