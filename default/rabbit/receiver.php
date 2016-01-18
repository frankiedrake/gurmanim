<?php
//echo get_include_path();
//chdir("/var");
//echo get_include_path(). PHP_EOL. PHP_EOL;

require_once('vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPConnection;

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('email_queue', false, false, false, false);

echo ' * Waiting for messages. To exit press CTRL+C', "\n";

$callback = function ($msg) {

    echo " * Message received", "\n";
    $data = json_decode($msg->body, true);

    $from = $data['from'];
    $from_email = $data['from_email'];
    $to_email = $data['to_email'];
    $subject = $data['subject'];
    $message = $data['message'];

    $transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
        ->setUsername('odarochk@gmail.com')
        ->setPassword('Vsebudedobre717');

    $mailer = Swift_Mailer::newInstance($transporter);

    $message = Swift_Message::newInstance($transporter)
        ->setSubject($subject)
        ->setFrom(array($from_email => $from))
        ->setTo(array($to_email))
        ->setBody($message);

    $mailer->send($message);

    echo " * Message was sent", "\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('email_queue', '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}