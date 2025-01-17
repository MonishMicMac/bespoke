@include('layout.header')

<div class="container">
    <h2>Edit App Banner</h2>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Use PUT method for updating -->

        <div class="form-group">
            <label for="img_path">Banner Image</label>
            <input type="file" name="img_path" class="form-control">
            @if ($banner->img_path)
                <img src="{{ asset('storage/' . $banner->img_path) }}" alt="Banner Image" style="width: 200px; margin-top: 10px;">
            @endif
        </div>

        <div class="form-group">
            <label for="type">Banner Type</label>
            <select name="type" class="form-control" required>
                <option value="dashboard" {{ $banner->type == 'dashboard' ? 'selected' : '' }}>Dashboard</option>
                <option value="promo" {{ $banner->type == 'promo' ? 'selected' : '' }}>Promo</option>
                <option value="advertisement" {{ $banner->type == 'advertisement' ? 'selected' : '' }}>Advertisement</option>
            </select>
        </div>

        <div class="form-group">
            <label for="type">Navigate</label>
            <select id="navigateType" name="navigate" class="form-control" required>
                <option value="">--Select--</option>
                <option value="1" {{ $banner->navigate == '1' ? 'selected' : '' }}>Navigate to Product</option>
                <option value="2" {{ $banner->navigate == '2' ? 'selected' : '' }}>Navigate to Shop or Designer</option>
            </select>
        </div>

        <div class="form-group">
            <label for="details">Search Field</label>
            <select id="searchfield_id" name="searchfield_id" class="form-control" required>
                <!-- Options will be dynamically updated based on selection -->
            </select>
        </div>

        <input type="hidden" id="searchfield_text" name="searchfield_text" />

        <button type="submit" class="btn btn-primary">Update Banner</button>
    </form>
</div>

@include('layout.footer')
<script>
    // Initialize DataTable
    $(document).ready(function () {
        $('#DesignerTable').DataTable();
    });

    // Disable submit button after form submission to prevent multiple submissions
    document.getElementById('designerForm').onsubmit = function () {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerText = 'Submitting...';
    };

    // Preview image before uploading
    function previewImage(event) {
        const file = event.target.files[0];
        const errorContainer = document.getElementById('imgError');

        // Clear any previous error messages
        errorContainer.innerText = '';

        if (file) {
            // Check file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                errorContainer.innerText = 'Invalid file type. Please upload a JPEG or PNG image.';
                document.getElementById('imgInput').value = ''; // Clear the input
                return;
            }

            // Check file size (e.g., 2MB = 2 * 1024 * 1024 bytes)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                errorContainer.innerText = 'File size exceeds 2MB. Please upload a smaller image.';
                document.getElementById('imgInput').value = ''; // Clear the input
                return;
            }

            // Check image dimensions
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    const width = img.width;
                    const height = img.height;

                    if (width !== 960 || height !== 576) {
                        errorContainer.innerText = 'Invalid dimensions. Please upload an image with dimensions 960x576.';
                        document.getElementById('imgInput').value = ''; // Clear the input
                        return;
                    }

                    // If all checks pass, display the preview
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    document.getElementById('imagePreviewContainer').style.display = 'block';
                };
            };

            reader.readAsDataURL(file);
        }
    }



    // Open image in modal for a larger view
    function openModal() {
        const imagePreview = document.getElementById('imagePreview');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imagePreview.src;

        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    }

    // Remove image preview and reset file input
    function removeImage() {
        document.getElementById('imgInput').value = '';
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreviewContainer').style.display = 'none';
    }

    // SweetAlert confirmation for delete action
    $(document).on('click', '.delete-btn', function (event) {
        const form = $(this).closest('.delete-form');

        // Show SweetAlert confirmation dialog
        swal({
            title: "Are you sure?",
            text: "This banner will be deleted!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navigateType = document.getElementById('navigateType');
        const searchField_id = document.getElementById('searchfield_id');
        const searchFieldText = document.getElementById('searchfield_text');

        const productDetails = @json($productdetails);
        const vendorDetails = @json($vendordetails);

        // Function to update the search field options
        function updateSearchField() {
            // Clear existing options
            searchField_id.innerHTML = '';

            if (navigateType.value === '1') {
                // Populate with product details
                productDetails.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = product.product_name;
                    searchField_id.appendChild(option);
                });
            } else if (navigateType.value === '2') {
                // Populate with vendor details
                vendorDetails.forEach(vendor => {
                    const option = document.createElement('option');
                    option.value = vendor.id;
                    option.textContent = vendor.shop_name;
                    searchField_id.appendChild(option);
                });
            }

            // Trigger change to update the hidden input for the initial selection
            searchField_id.dispatchEvent(new Event('change'));
        }

        // Update hidden input when the selection changes
        searchField_id.addEventListener('change', function () {
            const selectedOption = searchField_id.options[searchField_id.selectedIndex];
            searchFieldText.value = selectedOption ? selectedOption.textContent : '';
        });

        // Add event listener for changes in the navigate type dropdown
        navigateType.addEventListener('change', updateSearchField);

        // Initialize with the default selection
        updateSearchField();
    });
</script>
