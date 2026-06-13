<?php
// Set headers to indicate JSON response
header('Content-Type: application/json');

// Define the path to the data file (must match your actual file path)
$json_file_path = 'data/accounts.json';

// 1. Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// 2. Read and decode the JSON payload from the request body
$input_json = file_get_contents('php://input');
$data = json_decode($input_json, true);

// Get the new name and the account ID from the decoded data
$new_name = $data['newName'] ?? null;
$account_id = $data['accountId'] ?? null; 

if (empty($new_name) || empty($account_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'New name or Account ID is missing.']);
    exit;
}

// 3. Read the existing accounts.json file
if (!file_exists($json_file_path)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Data file not found: ' . $json_file_path]);
    exit;
}

$current_json = file_get_contents($json_file_path);
$accounts_data = json_decode($current_json, true);

if ($accounts_data === null || !isset($accounts_data['accounts']) || !is_array($accounts_data['accounts'])) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error decoding or invalid structure in existing JSON data.']);
    exit;
}

$update_successful = false;

// 4. Loop through accounts to find the matching account_id and update the name
foreach ($accounts_data['accounts'] as &$account) {
    // Crucial check: use the correct field "account_id" from your file
    if (isset($account['account_id']) && $account['account_id'] == $account_id) {
        if (isset($account['account_holder']['full_name'])) {
            $account['account_holder']['full_name'] = $new_name;
            $update_successful = true;
            break; // Stop iterating once the account is found and updated
        }
    }
}
unset($account); // Break the reference to the last element

if (!$update_successful) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Account with ID ' . $account_id . ' not found or missing name field.']);
    exit;
}

// 5. Encode the modified data back to JSON format
$updated_json = json_encode($accounts_data, JSON_PRETTY_PRINT);

// 6. Write the updated JSON string back to the file
if (file_put_contents($json_file_path, $updated_json) === false) {
    // Check for write permission issues
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to write to file. Check file permissions on ' . $json_file_path]);
    exit;
}

// 7. Success response
echo json_encode(['success' => true, 'message' => 'Account name updated successfully.']);
?>