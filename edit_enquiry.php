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

// Initialize variables
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$name = $phone = $course = '';
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);
    
    // Validate inputs
    if (empty($name) || empty($phone) || empty($course)) {
        $error = "All fields are required.";
    } else {
        // Prepare and execute update query
       $stmt = $conn->prepare("UPDATE enquiries 
                           SET name = ?, phone = ?, course = ? 
                           WHERE id = ? AND deleted_at IS NULL");
    $stmt->bind_param("sssi", $name, $phone, $course, $id);
        
        if ($stmt->execute()) {
            $success = "Enquiry updated successfully!";
        } else {
            $error = "Error updating enquiry: " . $conn->error;
        }
        $stmt->close();
    }
} else {
    // Fetch existing enquiry data
   $stmt = $conn->prepare("SELECT name, phone, course 
                       FROM enquiries 
                       WHERE id = ? AND deleted_at IS NULL");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $phone = $row['phone'];
    $course = $row['course'];
} else {
    $error = "Enquiry not found or has been deleted.";
}
    $stmt->close();
}

// Include header
include 'header1.php';
?>

<!-- Main Content -->
<main class="flex-shrink-0">
    <div class="container py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Enquiry
                    </h2>
                    <a href="view_enquiries.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Edit Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="edit_enquiry.php?id=<?= $id ?>" class="needs-validation" novalidate>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= htmlspecialchars($name) ?>" required>
                        <div class="invalid-feedback">Please enter a name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?= htmlspecialchars($phone) ?>" required>
                        <div class="invalid-feedback">Please enter a phone number.</div>
                    </div>

                    <div class="mb-3">
                        <label for="course" class="form-label">Course</label>
                        <input type="text" class="form-control" id="course" name="course" 
                               value="<?= htmlspecialchars($course) ?>" required>
                        <div class="invalid-feedback">Please enter a course.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Required Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Form Validation Script -->
<script>
(function() {
    'use strict';
    
    // Fetch all forms that need validation
    var forms = document.querySelectorAll('.needs-validation');
    
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php
// Include footer
include 'footer.php';

// Close database connection
$conn->close();
?>