@include('layout.header')
<div class="container">
    <h2>Edit Subcategory</h2>
    <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $subcategory->name) }}" required>
            
            {{-- Display validation error for name field --}}
            @if ($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            {{-- Display validation error for category_id field --}}
            @if ($errors->has('category_id'))
                <div class="text-danger">{{ $errors->first('category_id') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="img_path" class="form-label">Image</label>
            @if ($subcategory->img_path)
                <div>
                    <img src="{{ asset('storage/' . $subcategory->img_path) }}" alt="Subcategory Image" width="100">
                </div>
            @endif
            <input type="file" class="form-control" id="img_path" name="img_path" accept="image/*">

            {{-- Display validation error for img_path field --}}
            @if ($errors->has('img_path'))
                <div class="text-danger">{{ $errors->first('img_path') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@include('layout.footer')
