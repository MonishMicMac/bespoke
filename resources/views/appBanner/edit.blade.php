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

        <button type="submit" class="btn btn-primary">Update Banner</button>
    </form>
</div>

@include('layout.footer')
