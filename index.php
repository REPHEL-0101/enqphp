<?php
include 'header1.php';
?>

<!-- Welcome Section -->
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <h1 class="display-4 mb-3">Welcome Back!</h1>
                    <p class="lead text-muted">
                        Access your tools and resources below
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Quick Actions</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="add_enquiry.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> New Enquiry
                        </a>
                        <a href="add_admission.php" class="btn btn-success btn-sm">
                            <i class="fas fa-user-plus"></i> New Admission
                        </a>
                        <a href="reports.php" class="btn btn-info btn-sm">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Routes Section -->
    <div class="row g-3">
        <?php
        $routes = [
            [
                'title' => 'Dashboard',
                'description' => 'View statistics and metrics',
                'icon' => 'fas fa-chart-line',
                'link' => 'dashboard.php',
                'color' => 'primary'
            ],
            [
                'title' => 'Enquiries',
                'description' => 'Manage student enquiries',
                'icon' => 'fas fa-question-circle',
                'link' => 'view_enquiries.php',
                'color' => 'success'
            ],
            [
                'title' => 'Admissions',
                'description' => 'Handle student admissions',
                'icon' => 'fas fa-user-graduate',
                'link' => 'view_admissions.php',
                'color' => 'info'
            ],
            [
                'title' => 'Reports',
                'description' => 'View reports and analytics',
                'icon' => 'fas fa-file-alt',
                'link' => 'reports.php',
                'color' => 'warning'
            ]
        ];

        foreach ($routes as $route) {
            ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body p-3 text-center">
                        <i class="<?php echo $route['icon']; ?> route-icon text-<?php echo $route['color']; ?>"></i>
                        <h6 class="card-title mb-2"><?php echo $route['title']; ?></h6>
                        <p class="card-text small text-muted d-none d-md-block"><?php echo $route['description']; ?></p>
                        <a href="<?php echo $route['link']; ?>" class="btn btn-<?php echo $route['color']; ?> btn-sm mt-2 w-100">
                            Access <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light mt-4 py-3">
    <div class="container text-center">
        <p class="text-muted mb-0 small">© <?php echo date('Y'); ?> Staff Portal. All rights reserved.</p>
    </div>
</footer>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Page loader script -->
<script>
    window.addEventListener('load', function() {
        const loader = document.querySelector('.page-loader');
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
        }, 500);
    });
</script>
</body>
</html>