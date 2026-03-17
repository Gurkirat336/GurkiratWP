function handleImageUpload(input) {
    const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    const preview = document.getElementById('imagePreview');
    const validationMsg = document.getElementById('imageValidationMsg');

    preview.style.display = 'none';
    preview.src = '';
    validationMsg.textContent = '';
    validationMsg.className = 'form-text';

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            validationMsg.textContent = 'Invalid file type. Please upload a JPG, JPEG, PNG, GIF, or WEBP image.';
            validationMsg.classList.add('text-danger');
            input.value = '';
            return;
        }

        const fileSizeKB = (file.size / 1024).toFixed(2);
        validationMsg.textContent = 'Valid image selected: ' + file.name + ' (' + fileSizeKB + ' KB)';
        validationMsg.classList.add('text-success');

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function filterGallery() {
    const filterValue = document.getElementById('statusFilter').value.toLowerCase();
    const galleryItems = document.querySelectorAll('.gallery-item');

    galleryItems.forEach(function (item) {
        const itemStatus = item.getAttribute('data-status').toLowerCase();

        if (filterValue === 'all' || itemStatus === filterValue) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function openPetModal(imageSrc, petName) {
    const modalImage = document.getElementById('modalPetImage');
    const modalTitle = document.getElementById('petModalLabel');

    modalImage.src = imageSrc;
    modalTitle.textContent = petName;

    const modalElement = document.getElementById('petModal');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('petImage');
    if (imageInput) {
        imageInput.addEventListener('change', function () {
            handleImageUpload(this);
        });
    }

    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', filterGallery);
    }

    const galleryImages = document.querySelectorAll('.gallery-img-btn');
    galleryImages.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const imageSrc = this.getAttribute('data-image');
            const petName = this.getAttribute('data-name');
            openPetModal(imageSrc, petName);
        });
    });

});