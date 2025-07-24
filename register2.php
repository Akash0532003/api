<?php
// Include database configuration
include '../db_config.php';

// Allow requests from any origin (for development only)
header("Access-Control-Allow-Origin: *");

// Allow the following methods
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Check if data is valid
if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON data received.']);
    exit;
}


    // Access values like:
    $name = $data['name'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $user_password = isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : '';
    $dept = isset($data['dept']) ? $data['dept'] : '';                      
    $category = isset($data['category']) ? $data['category'] : '';
    $passedout = isset($data['passedout']) ? $data['passedout'] : '';
    $current = isset($data['current']) ? $data['current'] : '';
    $designation = isset($data['Desgnation']) ? $data['Desgnation'] : '';
    $skills = isset($data['Skills']) ? $data['Skills'] : '';
    $certified = isset($data['Certified']) ? $data['Certified'] : '';
    $cgpa = isset($data['CGPA']) ? $data['CGPA'] : '';
    // etc...


echo "Name: $name\n";
echo "Email: $email\n";
echo "Mobile: $mobile\n";
echo "Password: $user_password\n";
echo "Department: $dept\n";
echo "Category: $category\n";
echo "Passed Out: $passedout\n";
echo "Current: $current\n";
echo "Designation: $designation\n";
echo "Skills: $skills\n";
echo "Certified: $certified\n";
echo "CGPA: $cgpa\n";
    
    $query = db_query("INSERT INTO al_users (user_name,email, mobile, password, dept,category,passedout,current,designation,Skills,Certified,cgpa  ) 
                       VALUES ('$name', '$email', '$mobile', '$user_password', '$dept', '$category', '$passedout', '$current', '$designation', '$skills', '$certified', '$cgpa')");

    // Check if the query was successful
if ($query) {
        $response = ['code' => 200, 'message' => 'User registered successfully.'];
} else {
        $response = ['code' => 400, 'message' => 'User not registered successfully.'];

}

} else {
    http_response_code(405);
     $response = ['code' => 500, 'message' => 'Method Not Allowed'];
}



// ✅ Send response at the end
ob_clean(); // clear any prior output
echo json_encode($response);
exit; 

?>
