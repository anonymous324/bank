<?php
header("Content-Type: application/json");

$data_file = __DIR__ . "/data/accounts.json";

// ----------------------------------------------------------
// 0. Default Response
// ----------------------------------------------------------
$response = [
    "status" => "error",
    "message" => "Something went wrong."
];

// ----------------------------------------------------------
// 1. Load accounts.json
// ----------------------------------------------------------
if (!file_exists($data_file)) {
    finish("error", "accounts.json not found!", null);
}

$json_data = json_decode(file_get_contents($data_file), true);

if (!$json_data) {
    finish("error", "JSON file unreadable or corrupted!", null);
}

// ----------------------------------------------------------
// 2. POST Required
// ----------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    finish("error", "Only POST method allowed", null);
}

// ----------------------------------------------------------
// 3. Inputs
// ----------------------------------------------------------
$account_id  = $_POST["account_id"] ?? null;
$type        = $_POST["type"] ?? null;
$amount      = $_POST["amount"] ?? null;
$description = $_POST["description"] ?? "Web Transaction";

$time_mode   = $_POST["time_mode"] ?? "auto";
$auto_time   = $_POST["auto_time"] ?? null;
$manual_time = $_POST["manual_time"] ?? null;

$redirect    = isset($_POST["redirect"]); // from form

// ----------------------------------------------------------
// 4. Validation
// ----------------------------------------------------------
if (!$account_id || !$type || !$amount) {
    finish("error", "Missing fields: account_id, type, amount required!", null);
}

if (!is_numeric($amount) || $amount <= 0) {
    finish("error", "Amount must be a positive number!", null);
}

$amount = (float)$amount;

// ----------------------------------------------------------
// 5. Determine Transaction Time
// ----------------------------------------------------------
if ($time_mode === "manual" && !empty($manual_time)) {
    $transaction_time = date("Y-m-d H:i:s", strtotime($manual_time));
} else {
    $transaction_time = $auto_time ?: date("Y-m-d H:i:s");
}

// ----------------------------------------------------------
// 6. Process Transaction
// ----------------------------------------------------------
$found = false;
$transaction = null;

foreach ($json_data["accounts"] as &$acc) {

    if ($acc["account_id"] === $account_id) {
        $found = true;

        $current_balance = $acc["balance"];

        if ($type === "debit") {
            if ($current_balance < $amount) {
                finish("error", "Insufficient balance!", null);
            }
            $new_balance = $current_balance - $amount;
        }
        elseif ($type === "credit") {
            $new_balance = $current_balance + $amount;
        }
        else {
            finish("error", "Invalid type! Use credit or debit", null);
        }

        // Create new transaction
        $transaction = [
            "id"            => "TXN-" . time() . "-" . rand(100, 999),
            "date"          => $transaction_time,
            "type"          => $type,
            "amount"        => $amount,
            "description"   => $description,
            "balance_after" => $new_balance
        ];

        // Save
        $acc["transactions"][] = $transaction;
        $acc["balance"] = $new_balance;

        break;
    }
}

if (!$found) {
    finish("error", "Account not found!", null);
}

// ----------------------------------------------------------
// 7. Save Updated JSON
// ----------------------------------------------------------
file_put_contents($data_file, json_encode($json_data, JSON_PRETTY_PRINT));

// ----------------------------------------------------------
// 8. Final Output
// ----------------------------------------------------------
finish("success", "Transaction added successfully!", $transaction);


// ----------------------------------------------------------
// Helper: Output & Redirect
// ----------------------------------------------------------
function finish($status, $msg, $data) {
    global $redirect;

    // If form submitted → redirect back to deposit.php
    if ($redirect) {
        $msg = urlencode($msg);
        header("Location: deposits.php?status=$status&msg=$msg");
        exit;
    }

    // Otherwise → return JSON for API calls
    echo json_encode([
        "status" => $status,
        "message" => $msg,
        "transaction" => $data
    ]);
    exit;
}
?>
