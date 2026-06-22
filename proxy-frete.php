<?php
// proxy-frete.php - Contorna o CORS do Google Apps Script
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// URL DO SEU APPS SCRIPT
$APP_SCRIPT_URL = 'https://script.google.com/macros/s/AKfycbws9xIqXQDfSJ70VC8b2xYOmd3FwR2JBBh3Pf4cRZwOqJrtuyAXkvTGAIxHr97X1rlvtg/exec';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents('php://input');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $APP_SCRIPT_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
} else {
    // GET
    $query = $_SERVER['QUERY_STRING'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $APP_SCRIPT_URL . '?' . $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
}
