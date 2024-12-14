<?php
// Database connection
$host = 'localhost'; // Change with your host
$db = 'u888578780_cscpvm2'; // Change with your DB name
$user = 'u888578780_cscpvm2'; // Change with your DB user
$pass = '3u[n4x?L['; // Change with your DB password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data securely
$name = $conn->real_escape_string($_POST['name']);
$phone = $conn->real_escape_string($_POST['phone']);
$course = $conn->real_escape_string($_POST['course']);
$startDate = "20th November 2024"; // Replace with your dynamic start date
$startDay = "Wednesday";

// Set PHP timezone to IST
date_default_timezone_set('Asia/Kolkata');

// Get current date and time in IST
$created_at = date('Y-m-d H:i:s A');

// Save to database with the manually set IST created_at
$sql = "INSERT INTO enquiries (name, phone, course, created_at) VALUES ('$name', '$phone', '$course', '$created_at')";

if ($conn->query($sql) === TRUE) {
    // Prepare SMS API data
    $apiUrl = 'http://139.99.131.165/api/v2/SendSMS';
    $senderId = 'CSCpml';  // Replace with your sender ID
    $apiKey = 'dc0600dd-26bf-4468-bfce-cd266c5972d8';      // Replace with your API key
    $clientId = 'bbbd2f48-b9c9-414a-84f7-b90bdbaa1fa5';  // Replace with your client ID
    
    $message = "Dear ". $name . ", Thank you for choosing CSC, Pammal. Hope you have got the required information about the ". $course." Course. Next Batch is scheduled to begin on ". $startDate." , ". $startDay .". For further assistance, please feel free to contact us - Ph: 9710636363";
    
    echo $message;
    
    // Prepare SMS data in JSON format
    $smsData = array(
        "senderId" => $senderId,
        "is_Unicode" => true,
        "is_Flash" => false,
        "schedTime" => "",
        "grouypid" => [],
        "message" => $message,
        "mobileNumbers" => $phone,
          "serviceId"=> "",
            "coRelator"=> "",
        "linkId"=> "",
            "principleEntityId"=> "",
            "templateId"=> "",
        "apiKey" => $apiKey,
        "clientId" => $clientId
    );
    
    echo "API1";
    // Convert the data to JSON format
    $jsonData = json_encode($smsData);
 echo "API2";
    // Initialize cURL to send SMS
    $ch = curl_init($apiUrl);
 echo "API3";
    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 echo "API4";
    // Execute cURL request and get the response
    $smsResponse = curl_exec($ch);
   echo "API5".$smsResponse ;  
    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'SMS Error: ' . curl_error($ch);
    } else {
        // Decode the response to check the status
        $responseDecoded = json_decode($smsResponse, true);
        
        if ($responseDecoded['ErrorCode'] == 0) {
            echo "<script>
                    alert('Your enquiry has been successfully submitted and an SMS has been sent.');
                    window.location.href = 'view_enquiries.php'; // Redirect to homepage
                  </script>";
        } else {
            echo "<script>
                    alert('Your enquiry has been submitted, but there was an issue sending the SMS.');
                    window.location.href = 'view_enquiries.php'; // Redirect to homepage
                  </script>";
        }
    }
    
    // Close cURL
    curl_close($ch);
    
} else {
    // In case of error, display an alert and redirect to the homepage
    echo "<script>
            alert('Error: " . $conn->error . "');
            window.location.href = 'view_enquiries.php'; // Redirect back to homepage or error page
          </script>";
}

// Close the database connection
$conn->close();
?>
