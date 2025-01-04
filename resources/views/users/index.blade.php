@include('layout.header')

<div class="container mt-4">
    <h2 class="mb-4 text-center font-weight-bold">Users List</h2>

    <form method="GET" action="{{ route('user.view') }}">
        <div class="row g-3">
            <!-- From Date -->
            <div class="col-md-4">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" class="form-control" id="from_date" name="from_date"
                    value="{{ request('from_date') }}">
            </div>

            <!-- To Date -->
            <div class="col-md-4">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" class="form-control" id="to_date" name="to_date"
                    value="{{ request('to_date') }}">
            </div>

            <!-- Approval Status -->
            <div class="col-md-4">
                <label for="approve_status" class="form-label">Approval Status</label>
                <select class="form-select form-control" id="approve_status" name="approve_status">
                    <option value="">Select Status</option>
                    <option value="0" {{ request('approve_status') == '0' ? 'selected' : '' }}>Waiting for Approval
                    </option>
                    <option value="1" {{ request('approve_status') == '1' ? 'selected' : '' }}>Approved</option>
                    <option value="2" {{ request('approve_status') == '2' ? 'selected' : '' }}>Declined</option>
                </select>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Submit Button -->
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

    @if (isset($users) && $users->isNotEmpty())
        <table id="bannersTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Vendor Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Approval Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile_no }}</td>
                        <td>
                            @if ($user->approval_status == 0)
                                Waiting for Approval
                            @elseif ($user->approval_status == 1)
                                Approved
                            @else
                                Declined
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center mt-4">No records found.</p>
    @endif

</div>
@include('layout.footer')

<script>
    $(document).ready(function() {
        $('#bannersTable').DataTable();
    });
</script>
