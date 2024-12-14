<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db = 'u888578780_cscpvm2';
$user = 'u888578780_cscpvm2';
$pass = '3u[n4x?L[';

$response = array(
    'success' => false,
    'message' => ''
);

try {
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception("No enquiry ID provided");
    }

    $id = (int)$_POST['id'];

    // Update the deleted_at timestamp instead of deleting the record
    $stmt = $conn->prepare("UPDATE enquiries SET deleted_at = CURRENT_TIMESTAMP WHERE id = ? AND deleted_at IS NULL");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = 'Enquiry deleted successfully';
        } else {
            throw new Exception("No active enquiry found with ID: " . $id);
        }
    } else {
        throw new Exception("Error executing soft delete: " . $stmt->error);
    }

    $stmt->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
    echo json_encode($response);
}
?>