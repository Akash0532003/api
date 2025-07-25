<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include database configuration
include 'db_config.php';




$response = []; // ✅ Variable to store final response


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Check if data is valid
if (!$data) {
    http_response_code(400); // Bad Request
    $response = ['code' => 400, 'error' => 'Invalid JSON data received.'];
    exit;
}



    // Access values like:
    $email = $data['email'] ?? '';
    $user_password = $data['password'] ?? '';

        // $email = 'akash0532003@gmail.com';
        // $user_password = 'admin@123';

    // Step 1: Find user by email
    $users = db_select("SELECT * FROM al_users WHERE email = '$email'");

    if (count($users) === 0) {
        http_response_code(401);
        $response = ['code' => 401, 'error' => 'Invalid email or password'];
        exit;
    }

    $user = $users[0]; // The row returned
    $hashedPassword = $user['password'];
    // echo 'hashedPassword: ' . $hashedPassword . '<br>';
        // Step 2: Verify password
    if (password_verify($user_password, $hashedPassword)) {
        // http_response_code(200);
         $response = [
                    'message' => 'Login successful',
                    'code' => 200,
                    'status' => 'success',
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['user_name'],
                        'email' => $user['email'],
                        'mobile' => $user['mobile'],
                        'dept' => $user['dept'],
                        'category' => $user['category'],
                        'passedout' => $user['passedout'],
                        'current' => $user['current'],
                        'designation' => $user['designation'],
                        'skills' => $user['Skills'],
                        'certified' => $user['Certified'],
                        'cgpa' => $user['cgpa']
                    ]
                ];
    } else {
        http_response_code(401);
        $response = ['code' => 401, 'error' => 'Invalid email or password'];
    }


} else {
    http_response_code(405);
    $response = ['code' => 405, 'error' => 'Method Not Allowed'];
}

// ✅ Send response at the end
echo json_encode($response);
exit;

?>
