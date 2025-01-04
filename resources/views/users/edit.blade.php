@include('layout.header')

<div class="container mt-4">
    <h2 class="mb-4 text-center font-weight-bold">Edit User</h2>

    <form method="POST" action="{{ route('user.update', $user->id) }}">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" class="form-control" id="mobile_no" name="mobile" value="{{ $user->mobile }}"
                required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>

@include('layout.footer')
