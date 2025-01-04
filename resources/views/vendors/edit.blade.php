@include('layout.header')

<div class="container mt-4">
    <h2 class="mb-4 text-center font-weight-bold">Edit Vendor</h2>

    <form method="POST" action="{{ route('vendor.update', $vendor->id) }}">
        @csrf
        <div class="form-group">
            <label for="username">Vendor Name</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $vendor->username }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $vendor->email }}" required>
        </div>
        <div class="form-group">
            <label for="mobile_no">Mobile</label>
            <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ $vendor->mobile_no }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Vendor</button>
    </form>
</div>

@include('layout.footer')
