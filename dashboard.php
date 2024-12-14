<?php include 'header1.php'; ?>

<?php
// Database connection
$host = 'localhost';
$db = 'u888578780_cscpvm2';
$user = 'u888578780_cscpvm2';
$pass = '3u[n4x?L[';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$monthQuery = "SELECT DATE_FORMAT(created_at, '%M %Y') AS month, COUNT(*) AS count 
               FROM enquiries GROUP BY month ORDER BY created_at DESC";
$monthResult = $conn->query($monthQuery);

$courseQuery = "SELECT course, COUNT(*) AS count FROM enquiries GROUP BY course ORDER BY count DESC";
$courseResult = $conn->query($courseQuery);

$sql = "SELECT id, name, phone, course, created_at FROM enquiries ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="container">
        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <h2 class="text-center mb-3 mt-3">Enquiries Dashboard</h2>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Month-wise Enquiries</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($monthResult->num_rows > 0): ?>
                            <ul class="list-group">
                                <?php while ($row = $monthResult->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= htmlspecialchars($row['month']) ?>
                                        <span class="badge bg-primary rounded-pill"><?= $row['count'] ?></span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <div class="alert alert-info text-center">No data available for month-wise enquiries.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Course-wise Enquiries</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($courseResult->num_rows > 0): ?>
                            <ul class="list-group">
                                <?php while ($row = $courseResult->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= htmlspecialchars($row['course']) ?>
                                        <span class="badge bg-success rounded-pill"><?= $row['count'] ?></span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <div class="alert alert-info text-center">No data available for course-wise enquiries.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        
        <?php include 'footer.php'; ?>