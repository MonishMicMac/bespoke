@include('layout.header')

<div class="container">
    <h2>Edit Super Saver Deals</h2>

    <!-- Display validation errors -->

    <!-- Display error message if any -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

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





    <!-- Banner Creation Form -->
    <form action="{{route('supersaverdeals.update',$supersaveredit->id)}}" method="POST" enctype="multipart/form-data" id="designerForm">
        @csrf
        @method('PUT')



        <div class="mb-3">
            <label for="img_path" class="form-label">Super Saver Deals Image</label>
            @if ($supersaveredit->super_save_deals_image)
                <div>
                    <img src="{{ asset('supersaverdealsimages/' . $supersaveredit->super_save_deals_image) }}" alt="Background Image"
                        width="100">
                </div>
            @endif
            <input type="file" class="form-control" id="img_path" name="img_path" accept="image/*">

            {{-- Display validation error for img_path field --}}
            @if ($errors->has('img_path'))
                <div class="text-danger">{{ $errors->first('img_path') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="super_save_deals_title">Super Saver Deals Title</label>
            <input type="text" class="form-control" name="super_save_deals_title" id="super_save_deals_title" value="{{$supersaveredit->super_save_deals_title}}">
        </div>

        <div class="form-group">
            <label class="form-label" for="super_save_deals_price">Super Saver Deals Price</label>
            <input type="text" class="form-control" name="super_save_deals_price" id="super_save_deals_price" value="{{$supersaveredit->super_save_deals_price}}">
        </div>

        <div class="form-group">
            <label class="form-label" for="super_save_deals_brand_name">Super Saver Deals Price</label>
            <input type="text" class="form-control" name="super_save_deals_brand_name" id="super_save_deals_brand_name" value="{{$supersaveredit->super_save_deals_brand_name}}">
        </div>

        <div class="form-group">
            <label for="type">Navigate</label>
            <select id="navigateType" name="navigate" class="form-control" required>
                <option value="">--Select--</option>
                <option value="1" {{ $supersaveredit->navigate == '1' ? 'selected' : '' }}>Navigate to Product</option>
                <option value="2" {{ $supersaveredit->navigate == '2' ? 'selected' : '' }}>Navigate to Shop or Designer</option>
            </select>
        </div>

        <div class="form-group">
            <label for="details">Search Field</label>
            <select id="searchfield_id" name="searchfield_id" class="form-control" required>
                <!-- Options will be dynamically updated based on selection -->
            </select>
        </div>

        <input type="hidden" id="searchfield_text" name="searchfield_text" />



        <!-- Image Preview Section -->
        <div id="imagePreviewContainer" class="mt-3" style="display:none;">
            <img id="imagePreview" src="" alt="Image Preview" style="width: 200px; cursor: pointer;"
                onclick="openModal()">
            <!-- Remove button next to preview -->
            <button type="button" id="removeBtn" class="btn btn-danger" onclick="removeImage()">Remove</button>
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn">Update Current Deals</button>
    </form>


    </div>


    @include('layout.footer')

    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

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

