<?php
require_once dirname(dirname(__DIR__)) . '/config.php';
require_once CURRENT_DIR . '/vendor/autoload.php';

use \MixtendTest\Calendar;

try {
    $cal = new Calendar(LOG_PATH);
    $body = $cal->sendRequest(API_URI);
   
    $events = [];
    foreach($body->meetings as $day => $meetings) {
        foreach($meetings as $meeting) {
            $event = [
                'title' => $meeting->summary,
                'start' => sprintf('%sT%s:00+09:00', $day, $meeting->start),
                'end'   => sprintf('%sT%s:00+09:00', $day, $meeting->end),
            ];
            $events[] = $event;
        }
    }

    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($events);
} catch (Exception $ex) {
    http_response_code(500);
}


