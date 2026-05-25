function handleImageUpload(input) {
    var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    var preview = document.getElementById('imagePreview');
    var validationMsg = document.getElementById('imageValidationMsg');

    if (preview) {
        preview.style.display = 'none';
        preview.src = '';
    }
    if (validationMsg) {
        validationMsg.textContent = '';
        validationMsg.className = '';
    }

    if (input.files && input.files[0]) {
        var file = input.files[0];
        var fileExtension = file.name.split('.').pop().toLowerCase();

        if (allowedExtensions.indexOf(fileExtension) === -1) {
            if (validationMsg) {
                validationMsg.textContent = 'Invalid file type. Please upload a JPG, JPEG, PNG, GIF, or WEBP image.';
                validationMsg.classList.add('text-danger');
            }
            input.value = '';
            return;
        }

        var fileSizeKB = (file.size / 1024).toFixed(2);
        if (validationMsg) {
            validationMsg.textContent = 'Valid image selected: ' + file.name + ' (' + fileSizeKB + ' KB)';
            validationMsg.classList.add('text-success');
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }
}

function filterGallery() {
    var filterValue = document.getElementById('statusFilter').value;
    var galleryItems = document.querySelectorAll('.gallery-item');

    galleryItems.forEach(function (item) {
        var itemStatus = item.getAttribute('data-status');
        var colWrapper = item.parentElement;

        if (filterValue === 'all' || itemStatus === filterValue) {
            colWrapper.style.display = 'block';
        } else {
            colWrapper.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {

    var imageInput = document.getElementById('petImage');
    if (imageInput) {
        imageInput.addEventListener('change', function () {
            handleImageUpload(this);
        });
    }

    var statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', filterGallery);
    }

    var galleryImages = document.querySelectorAll('.gallery-img');
    galleryImages.forEach(function (img) {
        img.addEventListener('click', function () {
            var imageSrc = this.getAttribute('data-img');
            var petName = this.getAttribute('data-name');
            var modalImage = document.getElementById('modalPetImage');
            var modalTitle = document.getElementById('petModalLabel');
            if (modalImage) modalImage.src = imageSrc;
            if (modalTitle) modalTitle.textContent = petName;
            var modalEl = document.getElementById('petModal');
            if (modalEl) {
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    });

    var deleteBtn = document.getElementById('deleteBtn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            var deleteModalEl = document.getElementById('deleteModal');
            if (deleteModalEl) {
                var deleteModal = new bootstrap.Modal(deleteModalEl);
                deleteModal.show();
            }
        });
    }

    var detailsImg = document.querySelector('.details-pet-img');
    if (detailsImg) {
        detailsImg.addEventListener('click', function () {
            var imageSrc = this.src;
            var petName = this.alt;
            var modalImage = document.getElementById('modalPetImage');
            var modalTitle = document.getElementById('petModalLabel');
            if (modalImage) modalImage.src = imageSrc;
            if (modalTitle) modalTitle.textContent = petName;
            var modalEl = document.getElementById('petModal');
            if (modalEl) {
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    }

});
