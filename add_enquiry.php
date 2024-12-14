<?php include 'header1.php'; ?>

<!-- add_enquiry.php -->

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card enquiry-form-card">
                <div class="card-header bg-primary text-white">
                    <h2 class="card-title h5 mb-0">
                        <i class="fas fa-user-plus me-2"></i>New Student Enquiry
                    </h2>
                </div>
                <div class="card-body">
                    <form action="submit_enquiry.php" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Student Name</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" id="name" name="name" 
                                       required pattern="[A-Za-z\s]+" minlength="2">
                                <div class="invalid-feedback">
                                    Please enter a valid name (minimum 2 characters, letters only)
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       required pattern="[0-9]{10}" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter a valid 10-digit phone number
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="course" class="form-label">Course Interested</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-book"></i>
                                </span>
                                <select class="form-select" id="course" name="course" required>
                                    <option value="">Select a course</option>
                                    <option value="HDCA">HDCA</option>
                                    <option value="DCA">DCA</option>
                                    <option value="DMO">DMO</option>
                                    <option value="CCAE">CCAE</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a course
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Submit Enquiry
                            </button>
                            <a href="view_enquiries.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Enquiries
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation script
(function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>


<?php include 'footer.php'; ?>