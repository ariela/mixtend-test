<?php
require_once dirname(dirname(__DIR__)) . '/config.php';
require_once CURRENT_DIR . '/vendor/autoload.php';

use \MixtendTest\Calendar;

try {
    $cal = new Calendar(LOG_PATH);
    $body = $cal->sendRequest(API_URI);

    $response = [
        'working' => $body->working_hours,
        'start' => null,  
    ];
    foreach ($body->meetings as $day => $meetings) {
        $response['start'] = $day;
        break;
    }

    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
} catch (Exception $ex) {
    http_response_code(500);
}
