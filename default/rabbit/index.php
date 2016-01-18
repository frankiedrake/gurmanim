<?php
//chdir(dirname(__DIR__));
error_reporting(E_ALL);
require_once('vendor/autoload.php');

use Acme\AmqpWrapper\SimpleSender;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$theName = filter_input(INPUT_POST, 'theName', FILTER_SANITIZE_STRING);
$simpleSender = new SimpleSender();
$simpleSender->execute($theName);
header("Location: orderReceived.html");