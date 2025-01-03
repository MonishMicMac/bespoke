@include('layout.header')

<div class="container">
    <h1>Edit Promo Code</h1>
    <form action="{{ route('promocode.update', $promocode->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- This ensures the form uses PUT method for updates -->
    
        <!-- Display global error messages (optional) -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="code" class="form-label">Promocode Code</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $promocode->code) }}" required>
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" class="form-control @error('from_date') is-invalid @enderror" id="from_date" name="from_date" value="{{ old('from_date', $promocode->from_date) }}">
                @error('from_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="expire_date" class="form-label">Expire Date</label>
                <input type="date" class="form-control @error('expire_date') is-invalid @enderror" id="expire_date" name="expire_date" value="{{ old('expire_date', $promocode->expire_date) }}" required>
                @error('expire_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="action" class="form-label">Action (Active/Inactive)</label>
                <select class="form-select @error('action') is-invalid @enderror" id="action" name="action" required>
                    <option value="0" @if(old('action', $promocode->action) == 0) selected @endif>Inactive</option>
                    <option value="1" @if(old('action', $promocode->action) == 1) selected @endif>Active</option>
                </select>
                @error('action')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="discount_type" class="form-label">Discount Type</label>
                <select class="form-select @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type" required>
                    <option value="0" @if(old('discount_type', $promocode->discount_type) == 0) selected @endif>Flat</option>
                    <option value="1" @if(old('discount_type', $promocode->discount_type) == 1) selected @endif>Percentage</option>
                </select>
                @error('discount_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount', $promocode->discount) }}" required>
                @error('discount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">Update Promocode</button>
    </form>
</div>

@include('layout.footer')
