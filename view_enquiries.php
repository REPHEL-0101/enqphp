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

// Modified queries to exclude soft-deleted records
$monthQuery = "SELECT DATE_FORMAT(created_at, '%M %Y') AS month, COUNT(*) AS count 
               FROM enquiries 
               WHERE deleted_at IS NULL 
               GROUP BY month 
               ORDER BY created_at DESC";
$monthResult = $conn->query($monthQuery);

$courseQuery = "SELECT course, COUNT(*) AS count 
                FROM enquiries 
                WHERE deleted_at IS NULL 
                GROUP BY course 
                ORDER BY count DESC";
$courseResult = $conn->query($courseQuery);

$sql = "SELECT id, name, phone, course, created_at 
        FROM enquiries 
        WHERE deleted_at IS NULL 
        ORDER BY created_at DESC";
$result = $conn->query($sql);

// Include header
include 'header1.php';
?>

<!-- Main Content -->
<main class="flex-shrink-0">
    <div class="container-fluid py-3">
        <!-- Page Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <h2 class="h3 mb-0">
                        <i class="fas fa-list-alt me-2"></i>Enquiries List
                    </h2>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtersSidebar">
                            <i class="fas fa-filter me-2"></i>Filters
                        </button>
                        <a href="add_enquiry.php" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i><span class="d-none d-sm-inline">New</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Filters Sidebar - Shows as offcanvas on mobile -->
            <div class="col-md-3 mb-3 d-md-none">
                <div class="offcanvas-md offcanvas-start" tabindex="-1" id="filtersSidebar">
                    <div class="offcanvas-header d-md-none">
                        <h5 class="offcanvas-title">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filtersSidebar"></button>
                    </div>
                    <div class="offcanvas-body p-md-0">
                        <!-- Month-wise Stats -->
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calendar me-2"></i>Monthly Stats
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($monthResult && $monthResult->num_rows > 0): ?>
                                    <div class="list-group list-group-flush">
                                        <?php while ($row = $monthResult->fetch_assoc()): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><?= htmlspecialchars($row['month']) ?></span>
                                                <span class="badge bg-primary rounded-pill">
                                                    <?= htmlspecialchars($row['count']) ?>
                                                </span>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted mb-0">No data available</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Course-wise Stats -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-book me-2"></i>Course Stats
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($courseResult && $courseResult->num_rows > 0): ?>
                                    <div class="list-group list-group-flush">
                                        <?php while ($row = $courseResult->fetch_assoc()): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><?= htmlspecialchars($row['course']) ?></span>
                                                <span class="badge bg-primary rounded-pill">
                                                    <?= htmlspecialchars($row['count']) ?>
                                                </span>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted mb-0">No data available</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-12">
                <?php if ($result && $result->num_rows > 0): ?>
                    <!-- Search and Filter Bar -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12 col-sm-6">
                                    <input type="search" class="form-control" id="searchInput" 
                                           placeholder="Search enquiries...">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <select class="form-select" id="courseFilter">
                                        <option value="">All Courses</option>
                                        <?php 
                                        $courseResult->data_seek(0);
                                        while ($row = $courseResult->fetch_assoc()): 
                                        ?>
                                            <option value="<?= htmlspecialchars($row['course']) ?>">
                                                <?= htmlspecialchars($row['course']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enquiries List -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="enquiriesTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="d-none d-md-table-cell">#</th>
                                            <th scope="col">Name/Phone</th>
                                            <th scope="col" class="d-none d-md-table-cell">Course</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Date</th>
                                            <th scope="col" class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr class="align-middle">
                                                <td class="d-none d-md-table-cell">
                                                    <?= htmlspecialchars($row['id']) ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-medium">
                                                            <?= htmlspecialchars($row['name']) ?>
                                                        </span>
                                                        <a href="tel:<?= htmlspecialchars($row['phone']) ?>" 
                                                           class="text-decoration-none small text-muted d-md-none">
                                                            <?= htmlspecialchars($row['phone']) ?>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    <span class="badge bg-light text-dark">
                                                        <?= htmlspecialchars($row['course']) ?>
                                                    </span>
                                                </td>
                                                <td class="d-none d-lg-table-cell small">
                                                    <?= htmlspecialchars(date('d-M-Y h:i A', strtotime($row['created_at']))) ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <a href="tel:<?= htmlspecialchars($row['phone']) ?>" 
                                                           class="btn btn-sm btn-outline-primary d-none d-md-inline-flex">
                                                            <i class="fas fa-phone"></i>
                                                        </a>
                                                        <a href="edit_enquiry.php?id=<?= $row['id'] ?>" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="deleteEnquiry(<?= $row['id'] ?>)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>No enquiries found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Required Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Custom Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    const searchInput = document.getElementById('searchInput');
    const courseFilter = document.getElementById('courseFilter');
    const table = document.getElementById('enquiriesTable');
    const rows = table.getElementsByTagName('tr');

    // Function to filter table rows
    function filterTable() {
        const searchText = searchInput.value.toLowerCase();
        const selectedCourse = courseFilter.value.toLowerCase();

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const name = row.cells[1].textContent.toLowerCase();
            const course = row.cells[2].textContent.toLowerCase();
            const matchesSearch = name.includes(searchText);
            const matchesCourse = !selectedCourse || course.includes(selectedCourse);

            row.style.display = (matchesSearch && matchesCourse) ? '' : 'none';
        }
    }

    // Add event listeners
    searchInput.addEventListener('input', filterTable);
    courseFilter.addEventListener('change', filterTable);

    // Delete enquiry function
    window.deleteEnquiry = function(id) {
        if (confirm('Are you sure you want to delete this enquiry?')) {
            fetch('delete_enquiry.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error deleting enquiry: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the enquiry');
            });
        }
    };

    // Handle offcanvas behavior on window resize
    const offcanvas = document.querySelector('#filtersSidebar');
    if (offcanvas) {
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) { // md breakpoint
                offcanvas.classList.remove('show');
                const backdrop = document.querySelector('.offcanvas-backdrop');
                if (backdrop) backdrop.remove();
            }
        });
    }
});
</script>

<?php
// Include footer
include 'footer.php';

// Close database connection
$conn->close();
?>