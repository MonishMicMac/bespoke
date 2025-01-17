@include('layout.header')
<div class="container">
    <h2>Edit Spotlight</h2>
    <form action="{{ route('spotlight.update', $spotlightedit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="shop_name">Shop Name</label>

            <!-- Dropdown for selecting shop name -->
            <select name="shop_name" id="shop_name" class="form-control">
                <option value="">--Select--</option>
                @foreach ($vendordetails as $vendor)
                    <option value="{{ $vendor->shop_name }}"
                        @if($vendor->shop_name == $spotlightedit->shop_name) selected @endif>
                        {{ $vendor->shop_name }}
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

        <div class="form-group">
            <label for="type">Navigate</label>
            <select id="navigateType" name="navigate" class="form-control" required>
                <option value="">--Select--</option>
                <option value="1" {{ $spotlightedit->navigate == '1' ? 'selected' : '' }}>Navigate to Product</option>
                <option value="2" {{ $spotlightedit->navigate == '2' ? 'selected' : '' }}>Navigate to Shop or Designer</option>
            </select>
        </div>

        <div class="form-group">
            <label for="details">Search Field</label>
            <select id="searchfield_id" name="searchfield_id" class="form-control" required>
                <!-- Options will be dynamically updated based on selection -->
            </select>
        </div>

        <input type="hidden" id="searchfield_text" name="searchfield_text" />


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


