@include('layout.header')
<div class="container">
    <h2>Edit Spotlight</h2>
    <form action="{{ route('spotlight.update', $spotlightedit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="shop_name">Shop Name</label>
            <select name="shop_name" id="shop_name" class="form-control" required>
                <option value="">--Select--</option>
                @foreach($vendordetails as $vendor)
                    <option value="{{ $vendor->shop_name }}" data-shop-id="{{ $vendor->id }}" {{ $vendor->id == $spotlightedit->shop_name ? 'selected' : '' }}>{{ $vendor->shop_name }}
                    </option>
                @endforeach
            </select>
        </div>



        <input type="hidden" name="shop_id" id="shop_id" class="form-control" readonly
            value="{{ $spotlightedit->shop_id }}">


        <div class="mb-3">
            <label for="img_path" class="form-label">Background Image</label>
            @if ($spotlightedit->background_image)
                <div>
                    <img src="{{ asset('spotlightimages/' . $spotlightedit->background_image) }}" alt="Background Image"
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
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price" value="{{$spotlightedit->price}}">
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{$spotlightedit->title}}">
        </div>

        <div class="form-group">
            <label for="brand_name">Brand Name</label>
            <input type="text" class="form-control" name="brand_name" id="brand_name"
                value="{{$spotlightedit->brand_name}}">
        </div>


        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@include('layout.footer')
<script>
    document.getElementById('shop_name').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const vendorId = selectedOption.getAttribute('data-shop-id');

        // Update the shop_id text field
        document.getElementById('shop_id').value = vendorId || '';
    });
</script>