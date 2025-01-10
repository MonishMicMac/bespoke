@include('layout.header')

<div class="container">
    <h2 class="text-center ">Create Subcategory</h2>
    <!-- Subcategory creation form -->
    <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

           
        </div>
        <div class="mb-3">
            <label for="img_path" class="form-label">Image</label>
            <input type="file" class="form-control" id="img_path" name="img_path" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
    <h3 class="mt-4">Subcategories List</h3>
    <!-- List of subcategories -->
    <button class="btn btn-success" id="downloadExcelBtn">Download Excel</button>

    <table id="usersTable" class="table  table-bordered table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Subcategory Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
  $sno=1;
        ?>
            @foreach ($subcategories as $subcategory)
                <tr>
                    <td>{{  $sno++ }}</td>
                    <td>{{ $subcategory->category->name }}</td>
                    <td>{{ $subcategory->name }}</td>
                    <td><img src="{{ asset('storage/'.$subcategory->img_path) }}" alt="Subcategory Image" width="100">
                    </td>
                    <td>
                        <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST" class="delete-form" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('layout.footer')


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add click event listener to all delete buttons
        document.querySelectorAll('.delete-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const form = this.closest('form'); // Get the form associated with this button
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form
                        form.submit();
                    }
                });
            });
        });
    });
</script>