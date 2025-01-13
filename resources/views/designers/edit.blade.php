@include('layout.header')

<div class="container">
    <h2>Edit Top Designer</h2>

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
    <form action="{{route('designer.update' , $designeredits->id)}}" method="POST" enctype="multipart/form-data" id="designerForm">
        @csrf
        @method('PUT')


        <div class="form-group">
            <label class="form-label" for="designer_name">Designer Name</label>
            <input type="text" class="form-control" name="designer_name" id="designer_name" value="{{$designeredits->designer_name}}">
        </div>


        <div class="mb-3">
            <label for="img_path" class="form-label">Designer Image</label>
            @if ($designeredits->designer_image)
                <div>
                    <img src="{{ asset('designerimages/' . $designeredits->designer_image) }}" alt="Background Image"
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
            <label class="form-label" for="designer_title">Designer Title</label>
            <input type="text" class="form-control" name="designer_title" id="designer_title" value="{{$designeredits->designer_title}}">
        </div>



        <!-- Image Preview Section -->
        <div id="imagePreviewContainer" class="mt-3" style="display:none;">
            <img id="imagePreview" src="" alt="Image Preview" style="width: 200px; cursor: pointer;"
                onclick="openModal()">
            <!-- Remove button next to preview -->
            <button type="button" id="removeBtn" class="btn btn-danger" onclick="removeImage()">Remove</button>
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn">Update Designers</button>
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
