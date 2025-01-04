@include('layout.header')

<div class="container mt-4">
    <h2 class="mb-4 text-center font-weight-bold">Vendor List</h2>

    <form method="GET" action="{{ route('vendor.view') }}">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" class="form-control" id="from_date" name="from_date" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-4">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-4">
                <label for="approve_status" class="form-label">Approval Status</label>
                <select class="form-select form-control" id="approve_status" name="approve_status">
                    <option value="">Select Status</option>
                    <option value="0" {{ request('approve_status') == '0' ? 'selected' : '' }}>Waiting for Approval</option>
                    <option value="1" {{ request('approve_status') == '1' ? 'selected' : '' }}>Approved</option>
                    <option value="2" {{ request('approve_status') == '2' ? 'selected' : '' }}>Declined</option>
                </select>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3 ms-auto">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (isset($vendors) && $vendors->isNotEmpty())
        <table id="bannersTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Vendor Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Approval Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->username }}</td>
                        <td>{{ $vendor->email }}</td>
                        <td>{{ $vendor->mobile_no }}</td>
                        <td>
                            @if ($vendor->approval_status == 0)
                            <button class="btn btn-success btn-sm update-status-btn" data-id="{{ $vendor->id }}" data-status="1">Approve</button>
                            <button class="btn btn-warning btn-sm update-status-btn" data-id="{{ $vendor->id }}" data-status="2">Decline</button>
                            @elseif ($vendor->approval_status == 1)
                                Approved
                            @else
                                Declined
                            @endif
                        </td>
                        <td>{{ $vendor->created_at }}</td>
                        <td>
                            <a href="{{ route('vendor.edit', $vendor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $vendor->id }}">Delete</button>
                            <form id="delete-form-{{ $vendor->id }}" action="{{ route('vendor.delete', $vendor->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center mt-4">No records found.</p>
    @endif
</div>

@include('layout.footer')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#bannersTable').DataTable();

        // SweetAlert confirmation for delete
        $('.delete-btn').on('click', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${id}`).submit();
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#bannersTable').DataTable();

        // Approve or Decline vendor
        $('.update-status-btn').on('click', function () {
            const vendorId = $(this).data('id');
            const status = $(this).data('status');
            const actionText = status == 1 ? 'approve' : 'decline';

            Swal.fire({
                title: `Are you sure you want to ${actionText} this vendor?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${actionText}!`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('vendor.updateStatus') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: vendorId,
                            approval_status: status,
                        },
                        success: function (response) {
                            Swal.fire('Success', response.message, 'success');
                            location.reload();
                        },
                        error: function (xhr) {
                            Swal.fire('Error', xhr.responseJSON.message, 'error');
                        },
                    });
                }
            });
        });

        // Delete vendor
        $('.delete-btn').on('click', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${id}`).submit();
                }
            });
        });
    });
</script>
