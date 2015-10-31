<?php

error_reporting(E_ALL);

function ElasticPut($index, $type, $id, $postfields) {
    $url = "http://localhost:9200/$index/$type/$id";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function ElasticPost($index, $type, $postfields) {
    $url = "http://localhost:9200/$index/$type";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postfields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function ElasticGet($index, $type, $id, $source = null) {
    $url = "http://localhost:9200/$index/$type/$id"; //?pretty
    if ($source) $url .= "_source";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function ElasticSearch($index = null, $type = null) {
    $url = "http://localhost:9200/";
    if ($index) $url .= "$index/";
    if ($type) $url .= $type;
    $url .= "_search";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

$index = 'logs';
$type = 'paystopies';
$id = date("Ymdhis");
$postfields = array(
    "ip" => '10.1.96.150',
    "mode" => 'post',
    "request" => "some request data...",
    "response" => 'Ok',
    "time" => date("Y-m-d H:i:s")
);

if (isset($_REQUEST['act'])) {
    $act = $_REQUEST['act'];
    switch ($act) {
        case 'put' :
            $result = ElasticPut($index, $type, $id, $postfields);
            break;
        case 'post' :
            $result = ElasticPost($index, $type, $postfields);
            break;
        case 'get' :
            $result = ElasticGet($index, $type, $_REQUEST['id'], true);
            break;
        case 'search' :
            $result = ElasticSearch($index, $type, $id, $postfields);
            break;
    }
    print_r($result);
}

