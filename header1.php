<!-- header.php -->

<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check if the current page matches a menu item
function isActive($pageName) {
    return (basename($_SERVER['PHP_SELF']) === $pageName) ? 'active' : '';
}

// Function to check if the current page is in a specific section
function isSectionActive($section) {
    return (strpos($_SERVER['PHP_SELF'], $section) !== false) ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSC PVM</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">

    <!-- Bootstrap JS and Popper.js (required for dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <style>
        :root {
            --gradient-start: #007bff;
            --gradient-end: #6f42c1;
        }

        body {
            background-color: #f8f9fa;
            bottom: 0;
            top:0;
        }

        .gradient-custom {
            background: linear-gradient(90deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        }

        .mobile-card {
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 12px;
            background-color: white;
        }

        .mobile-action-btn {
            padding: 8px;
            border-radius: 8px;
            min-width: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
        }

        .mobile-header {
            padding: 15px;
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .mobile-search {
            border-radius: 25px;
            padding: 12px 20px;
            border: 1px solid #dee2e6;
            margin-bottom: 10px;
            width: 100%;
            background-color: white;
        }

        .mobile-select {
            border-radius: 25px;
            padding: 12px 20px;
            border: 1px solid #dee2e6;
            background-color: white;
            margin-bottom: 10px;
            width: 100%;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
        }

        .mobile-fab {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 56px;
            height: 56px;
            border-radius: 28px;
            background: var(--gradient-start);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            border: none;
            z-index: 1000;
            transition: transform 0.2s;
        }

        .mobile-fab:hover {
            transform: scale(1.05);
            color: white;
        }

        .mobile-fab:active {
            transform: scale(0.95);
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #dee2e6;
            padding: 8px 0;
            display: flex;
            justify-content: space-around;
            z-index: 1000;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }

        .nav-item-mobile {
            text-align: center;
            color: #6c757d;
            text-decoration: none;
            padding: 4px 8px;
            transition: color 0.2s;
        }

        .nav-item-mobile.active {
            color: var(--gradient-start);
        }

        .nav-item-mobile i {
            font-size: 20px;
            display: block;
            margin-bottom: 4px;
        }

        .nav-item-mobile span {
            font-size: 12px;
            display: block;
        }

        .offcanvas {
            border-radius: 15px 0 0 15px;
        }

        .list-group-item {
            border: none;
            padding: 12px 16px;
            margin: 2px 0;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .list-group-item.active {
            background-color: #e7f1ff;
            color: var(--gradient-start);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark gradient-custom sticky-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="fas fa-building me-2"></i>
                <span class="d-none d-sm-inline">Staff Portal</span>
                <span class="d-inline d-sm-none">Portal</span>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link <?= isActive('index.php') ?>" href="index.php">
                            <i class="fas fa-home"></i>
                            <span class="ms-2">Home</span>
                        </a>
                    </li>
                    
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link <?= isActive('dashboard.php') ?>" href="dashboard.php">
                            <i class="fas fa-chart-line"></i>
                            <span class="ms-2">Dashboard</span>
                        </a>
                    </li>

                    <!-- Enquiry Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= isSectionActive('enquiry') ?>" 
                           href="#" id="enquiryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-question-circle"></i>
                            <span class="ms-2">Enquiry</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="enquiryDropdown">
                            <li>
                                <a class="dropdown-item <?= isActive('add_enquiry.php') ?>" href="add_enquiry.php">
                                    <i class="fas fa-plus"></i>
                                    <span class="ms-2">Add New Enquiry</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= isActive('view_enquiries.php') ?>" href="view_enquiries.php">
                                    <i class="fas fa-list"></i>
                                    <span class="ms-2">View All Enquiries</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Admission Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= isSectionActive('admission') ?>" 
                           href="#" id="admissionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-graduate"></i>
                            <span class="ms-2">Admission</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="admissionDropdown">
                            <li>
                                <a class="dropdown-item <?= isActive('add_admission.php') ?>" href="add_admission.php">
                                    <i class="fas fa-plus"></i>
                                    <span class="ms-2">Add New Admission</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= isActive('view_admissions.php') ?>" href="view_admissions.php">
                                    <i class="fas fa-list"></i>
                                    <span class="ms-2">View All Admissions</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Right-aligned menu items -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= isActive('profile.php') ?>" href="profile.php">
                            <i class="fas fa-user"></i>
                            <span class="ms-2">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="ms-2">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- JavaScript for hover effect (optional) -->
    <script>
        document.querySelectorAll('.nav-item.dropdown').forEach(function (dropdown) {
            dropdown.addEventListener('mouseenter', function () {
                let menu = this.querySelector('.dropdown-menu');
                if (menu) menu.classList.add('show');
            });
            dropdown.addEventListener('mouseleave', function () {
                let menu = this.querySelector('.dropdown-menu');
                if (menu) menu.classList.remove('show');
            });
        });
    </script>