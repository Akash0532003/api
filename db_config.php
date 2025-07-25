<?php
$servername = "bq97ovvt1aqjvnt044hk-mysql.services.clever-cloud.com";  // Replace with your actual database server name
$username = "uokzch8m6envigph";  // Replace with your actual database username
$password = "zEcJUwisj6725uMHyGSb";  // Leave empty if there's no password
$dbname = "bq97ovvt1aqjvnt044hk";  // Replace with your actual database name

// Function to establish database connection
function db_connect() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }else{
        // echo "Database connection established successfully.\n";
    }
    return $conn;
        // echo "Database connection established successfully.\n";

}
    echo "Database connection established successfully.\n";

// Function to execute INSERT, UPDATE, DELETE queries
function db_query($sql) {
    $conn = db_connect();
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $conn->close();
    return $result;
}

// Function to execute SELECT queries and return results
function db_select($sql) {
    $conn = db_connect();
    $result = $conn->query($sql);
    $data = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        die("Query failed: " . $conn->error);
    }

    $conn->close();
    return $data;
}
?>
 
