$ws = new WebSocket("ws://localhost:8080/notifications");
$ws->send(json_encode(["message" => "Video overdue for user {$user_id}"]));
