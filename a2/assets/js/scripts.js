document.addEventListener('DOMContentLoaded', function () {

    var imageInput = document.querySelector('input[name="image"]');
    if (imageInput) {
        imageInput.addEventListener('change', function () {
            var validationMsg = document.getElementById('imageValidationMsg');
            var previewContainer = document.getElementById('imagePreview');
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!this.files || this.files.length === 0) {
                validationMsg.textContent = '';
                validationMsg.className = 'validation-message';
                previewContainer.innerHTML = '';
                return;
            }

            var file = this.files[0];
            var fileName = file.name;
            var ext = fileName.split('.').pop().toLowerCase();

            if (allowedExtensions.indexOf(ext) === -1) {
                validationMsg.textContent = 'Invalid file type. Only jpg, jpeg, png, gif, webp are allowed.';
                validationMsg.className = 'validation-message invalid';
                previewContainer.innerHTML = '';
                this.value = '';
                return;
            }

            var sizeKB = (file.size / 1024).toFixed(1);
            validationMsg.textContent = 'Valid image selected: ' + fileName + ' (' + sizeKB + ' KB)';
            validationMsg.className = 'validation-message valid';

            var reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
            };
            reader.readAsDataURL(file);
        });
    }

    var statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function () {
            var selected = this.value;
            var items = document.querySelectorAll('.gallery-item');
            items.forEach(function (item) {
                if (selected === 'all' || item.getAttribute('data-status') === selected) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    var galleryImages = document.querySelectorAll('.gallery-img');
    if (galleryImages.length > 0) {
        galleryImages.forEach(function (img) {
            img.addEventListener('click', function () {
                var parentItem = this.closest('.gallery-item');
                var imgSrc = parentItem.getAttribute('data-img');
                var petName = parentItem.getAttribute('data-name');

                var modalImage = document.getElementById('modalImage');
                var modalLabel = document.getElementById('modalLabel');

                if (modalImage) {
                    modalImage.src = imgSrc;
                    modalImage.alt = petName;
                }
                if (modalLabel) {
                    modalLabel.textContent = petName;
                }

                var petModal = document.getElementById('petModal');
                if (petModal) {
                    bootstrap.Modal.getOrCreateInstance(petModal).show();
                }
            });
        });
    }

});
