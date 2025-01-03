@include('layout.header')

<div class="container my-4">
    <h1 class="text-center mb-4">Edit Category</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Update Category</h5>
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" id="category_name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="category_image" class="form-label">Category Image</label>
                    
                    @if ($category->img_path)
                        <div class="mb-2">
                            <img src="{{ url('storage/' . $category->img_path) }}" alt="Category Image" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    @endif
                    
                    <input type="file" id="category_image" name="img_path" class="form-control">
                    @error('img_path')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            
                <button type="submit" class="btn btn-primary">Update Category</button>
            </form>
            
        </div>
    </div>
</div>

@include('layout.footer')
