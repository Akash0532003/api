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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Check if data is valid
if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON data received.']);
    exit;
}

$apitype = $_REQUEST['apiType'];


$user_id = isset($data['user_id']) ? $data['user_id'] : ''; // Get user ID from request


if($_REQUEST['apiKey']=='ALUMNIAPIKEY0512')
{

    if($apitype  == 'user_list'){

    $selects = db_select("SELECT * FROM al_users WHERE status = '1' AND user_type='consumer' ");
    if (!empty($selects)) {
    $response = ['code' => 200, 'users' => $selects];
    } else {
    $response = ['code' => 400, 'Data' => 'No users found.'];
    }
    
    }else if($apitype  == 'profile'){

        $selects = db_select("SELECT * FROM al_users WHERE id = '$user_id' ");
       
    if (!empty($selects)) {
    $response = ['code' => 200, 'profile' => $selects];
    } else {
    $response = ['code' => 400, 'Data' => 'No profile found.'];
    }

    }else if($apitype  == 'updateprofile'){
        $id = isset($data['id']) ? $data['id'] : '';
        $user_name = isset($data['name']) ? $data['name'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $mobile = isset($data['mobile']) ? $data['mobile'] : '';
        $dept = isset($data['dept']) ? $data['dept'] : '';
        $passedout = isset($data['passedout']) ? $data['passedout'] : '';
        $category = isset($data['category']) ? $data['category'] : '';
        $current = isset($data['current']) ? $data['current'] : '';
        $designation = isset($data['designation']) ? $data['designation'] : '';
        $skill = isset($data['Skills']) ? $data['Skills'] : '';
        $cgpa = isset($data['cgpa']) ? $data['cgpa'] : '';
        $certified = isset($data['certified']) ? $data['certified'] : '';

        if(!empty($id) && !empty($mobile)){

            $update =db_query("UPDATE al_users SET user_name = '$user_name', email = '$email', mobile = '$mobile', dept = '$dept', passedout = '$passedout', category = '$category', current = '$current', designation = '$designation', Skills = '$skill', cgpa = '$cgpa', Certified = '$certified' WHERE id = '$id'");
            if($update){
                $response = ['code' => 200, 'message' => 'Profile updated successfully.'];        
        }else{
                $response = ['code' => 400, 'error' => 'Failed to update profile.'];
            }
        }else{
            $response = ['code' => 400, 'error' => 'Invalid data provided.'];
        }

    } else if ($apitype  == 'corporate_list'){

        $selects = db_select("SELECT * FROM al_users WHERE user_type='Corporate' ");
        if (!empty($selects)) {
        $response = ['code' => 200, 'corporates' => $selects];
        } else {
        $response = ['code' => 400, 'Data' => 'No corporate users found.'];
        }

    }
else {
    $response = ['code' => 400, 'error' => 'Invalid API type.'];

}

}
} else {
    http_response_code(405);
    $response = ['message' => 'Method Not Allowed'];
}


// ✅ Send response at the end
echo json_encode($response);
exit;
?>



