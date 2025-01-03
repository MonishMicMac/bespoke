@include('layout.header')

<div class="container">
    <h1>Create Promo Code</h1>
    <form action="{{ route('promocode.store') }}" method="POST">
        @csrf
    
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
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" class="form-control @error('from_date') is-invalid @enderror" id="from_date" name="from_date" value="{{ old('from_date') }}">
                @error('from_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="expire_date" class="form-label">Expire Date</label>
                <input type="date" class="form-control @error('expire_date') is-invalid @enderror" id="expire_date" name="expire_date" value="{{ old('expire_date') }}" required>
                @error('expire_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="action" class="form-label">Action (Active/Inactive)</label>
                <select class="form-select @error('action') is-invalid @enderror form-control" id="action" name="action" required>
                    <option value="0" @if(old('action') == 0) selected @endif>Inactive</option>
                    <option value="1" @if(old('action') == 1) selected @endif>Active</option>
                </select>

                
                @error('action')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="discount_type" class="form-label">Discount Type</label>
                <select class="form-select @error('discount_type') is-invalid @enderror form-control" id="discount_type" name="discount_type" required>
                    <option value="0" @if(old('discount_type') == 0) selected @endif>Flat</option>
                    <option value="1" @if(old('discount_type') == 1) selected @endif>Percentage</option>
                </select>
                @error('discount_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount') }}" required>
                @error('discount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">Create Promocode</button>
    </form>
    

    <button id="downloadExcelPromo" class="btn btn-success m-4">Download Excel</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>From Date</th>
                <th>Expire Date</th>
                <th>Action</th>
                <th>Discount Type</th>
                <th>Discount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promocodes as $promocode)
                <tr>
                    <td>{{ $promocode->code }}</td>
                    <td>{{ $promocode->from_date }}</td>
                    <td>{{ $promocode->expire_date }}</td>
                    <td>{{ $promocode->action == 1 ? 'Active' : 'Inactive' }}</td>
                    <td>{{ $promocode->discount_type == 0 ? 'Flat' : 'Percentage' }}</td>
                    <td>{{ $promocode->discount_type == 0 ?  $promocode->discount :  $promocode->discount.' %' }}</td>
                 
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('promocode.edit', $promocode->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete Button -->
                        <form action="{{ route('promocode.destroy', $promocode->id) }}" method="POST" style="display: inline;" class="delete-form">
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
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script>
    document.getElementById('downloadExcelPromo').addEventListener('click', async () => {
        // Create a new workbook
        const workbook = new ExcelJS.Workbook();

        // Add a worksheet
        const worksheet = workbook.addWorksheet('Promo Codes');

        // Define columns
        worksheet.columns = [
            { header: 'S.No', key: 'sno', width: 10 },
            { header: 'Code', key: 'code', width: 20 },
            { header: 'From Date', key: 'from_date', width: 15 },
            { header: 'Expire Date', key: 'expire_date', width: 15 },
            { header: 'Action', key: 'action', width: 10 },
            { header: 'Discount Type', key: 'discount_type', width: 15 },
            { header: 'Discount', key: 'discount', width: 10 },
        ];

        // Initialize serial number
        let sno1 = 1;

        // Add rows dynamically from Blade variables
        @foreach ($promocodes as $promocode)
            worksheet.addRow({
                sno: sno1,
                code: "{{ $promocode->code }}",
                from_date: "{{ $promocode->from_date }}",
                expire_date: "{{ $promocode->expire_date }}",
                action: "{{ $promocode->action == 1 ? 'Active' : 'Inactive' }}",
                discount_type: "{{ $promocode->discount_type == 0 ? 'Flat' : 'Percentage' }}",
                discount: "{{ $promocode->discount }}",
            });
            sno1++;
        @endforeach

        // Style the header row
        worksheet.getRow(1).font = { bold: true, color: { argb: 'FFFFFF' } };
        worksheet.getRow(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: '0078D4' },
        };

        // Generate Excel file
        const buffer = await workbook.xlsx.writeBuffer();

        // Trigger download
        const blob = new Blob([buffer], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'PromoCodes.xlsx';
        link.click();
    });

    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
});


</script>
