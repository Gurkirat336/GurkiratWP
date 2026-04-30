<?php
$pageTitle = "Add Pet";
$activePage = "add";
$basePath = "";
include 'includes/db_connect.inc';
include 'includes/header.inc';
?>

<h2 class="mb-4">
    <span class="material-icons icon-sm">add_circle</span>
    Add a New Pet for Adoption
</h2>

<?php if (isset($_GET['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($_GET['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="process_add.php" method="POST" enctype="multipart/form-data">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Pet Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Buddy" required>
                </div>
                <div class="col-md-6">
                    <label for="species" class="form-label">Species <span class="text-danger">*</span></label>
                    <select class="form-select" id="species" name="species" required>
                        <option value="" disabled selected>Select species</option>
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Bird">Bird</option>
                        <option value="Rabbit">Rabbit</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="breed" class="form-label">Breed</label>
                    <input type="text" class="form-control" id="breed" name="breed" placeholder="e.g. Golden Retriever">
                </div>
                <div class="col-md-3">
                    <label for="age_years" class="form-label">Age (Years)</label>
                    <input type="number" class="form-control" id="age_years" name="age_years" placeholder="0" min="0" max="30" value="0">
                </div>
                <div class="col-md-3">
                    <label for="age_months" class="form-label">Age (Months)</label>
                    <input type="number" class="form-control" id="age_months" name="age_months" placeholder="0" min="0" max="11" value="0">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="" disabled selected>Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                    <select class="form-select" id="size" name="size" required>
                        <option value="" disabled selected>Select size</option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                        <option value="Extra Large">Extra Large</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="adoption_fee" class="form-label">Adoption Fee ($) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="adoption_fee" name="adoption_fee" placeholder="e.g. 150.00" min="0" step="0.01" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe the pet's personality, habits, and what makes them special..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="health_info" class="form-label">Health Information</label>
                <textarea class="form-control" id="health_info" name="health_info" rows="3" placeholder="Vaccination status, medical history, special needs..."></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="status" name="status" required>
                    <option value="" disabled selected>Select status</option>
                    <option value="available">Available</option>
                    <option value="pending">Pending</option>
                    <option value="adopted">Adopted</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label">Pet Photo</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <div id="imageValidationMsg" class="validation-message"></div>
                <div id="imagePreview" class="image-preview-container"></div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-indigo d-flex align-items-center gap-1">
                    <span class="material-icons icon-sm">save</span> Add Pet
                </button>
                <a href="index.php" class="btn btn-pink d-flex align-items-center gap-1">
                    <span class="material-icons icon-sm">cancel</span> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>
