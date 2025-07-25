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
$apiKey = $_REQUEST['apiKey'];




if($_REQUEST['apiKey']=='ALUMNIAPIKEY0512')
{

    // Check the API type
 if($apitype === 'addevent'){

    $current_date = date('Y-m-d H:i:s'); // Get current date and time

    // Access values like:
    $event_name = isset($data['event_name']) ? $data['event_name'] : ''; 
    $event_date = isset($data['event_date']) ? $data['event_date'] : ''; 
    $event_time = isset($data['event_time']) ? $data['event_time'] : ''; 
    $location = isset($data['location']) ? $data['location'] : '';                      
    $description = isset($data['description']) ? $data['description'] : '';
    $image	 = isset($data['image']) ? $data['image'] : '';
    $imagePath = 'D:/app images/' . $image;
    $Status = isset($data['Status']) ? $data['Status'] : '1'; 
    $apitype = isset($data['apitype']) ? $data['apitype'] : ''; 


    // echo 'event_name: ' . $event_name . '<br>';
    // echo 'event_date: ' . $event_date . '<br>';
    // echo 'event_time: ' . $event_time . '<br>';
    // echo 'location: ' . $location . '<br>';
    // echo 'description: ' . $description . '<br>';
    // echo 'image: ' . $image . '<br>';
    // echo 'imagePath: ' . $imagePath. '<br>';
    // echo 'Status: ' . $Status . '<br>';

    
    $insert = db_query("INSERT INTO al_events (event_name,event_date, event_time, location, description, image, created_date,status) 
                       VALUES ('$event_name', '$event_date', '$event_time', '$location', '$description', '$imagePath', '$current_date', '$Status')");

if ($insert) {
    $response = [ 'Code' => '200', 'message' => 'event added successfully.'];
} else {
    $response = ['error' => 'Failed to add new events.'];
}
  
}elseif($apitype  == 'event_list'){


$selects = db_select("SELECT * FROM al_events WHERE status = '1' ORDER BY id DESC");
    if (!empty($selects)) {
    $response = ['code' => 200, 'events' => $selects];
    } else {
    $response = ['code' => 400, 'Data' => 'No events found.'];
    }
    
} else {
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
