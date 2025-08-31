<?php
// Helper function for response
function send_response($code, $message) {
    http_response_code($code);
    echo json_encode(["status" => $message]);
    exit;
}

// ====================
// 1. Content-Type Validation
// ====================
if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
    send_response(400, "Invalid Content-Type, must be application/json");
}

// ====================
// 2. Read and Decode JSON
// ====================
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    send_response(400, "Invalid JSON payload");
}

// ====================
// 3. Required Fields Validation
// ====================
$requiredFields = ['event', 'macro', 'conversation'];
foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        send_response(400, "Missing required field: $field");
    }
}

// ====================
// 4. Event Type Validation
// ====================
if ($data['event'] !== 'macro_executed') {
    send_response(400, "Unsupported event type");
}

// ====================
// 5. Labels Validation
// ====================
$labels = $data['conversation']['labels'] ?? [];
if (!is_array($labels)) {
    send_response(400, "Labels must be an array");
}

// ====================
// 6. Secret Token Validation
// ====================
$expectedToken = "MY_SECRET_KEY"; // Chatwoot Macro-এ সেট করা token
$receivedToken = $_SERVER['HTTP_X_WEBHOOK_TOKEN'] ?? null;

if ($receivedToken !== $expectedToken) {
    send_response(401, "Unauthorized request");
}

// ====================
// 7. Optional: IP Whitelist (Security Enhancement)
// ====================
// Uncomment and set allowed Chatwoot server IPs if known
// $allowedIps = ["123.45.67.89"];
// $clientIp = $_SERVER['REMOTE_ADDR'];
// if (!in_array($clientIp, $allowedIps)) {
//     send_response(403, "Forbidden");
// }

// ====================
// 8. Main Logic
// ====================
if (in_array("bug-report", $labels)) {
    // Example: log the bug report event
    error_log("✅ Bug Report Macro triggered for Conversation ID: " . $data['conversation']['id']);
    
    // TODO: আপনার কাস্টম logic এখানে লিখুন
    // যেমন: ইমেইল পাঠানো, DB update, API call ইত্যাদি
}

// ====================
// 9. Success Response
// ====================
send_response(200, "Webhook processed successfully");
?>
