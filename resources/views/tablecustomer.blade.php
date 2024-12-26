@extends('layouts.admin')

@section('title', 'Customer Management')

@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url('{{ asset('images/welcomebg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        height: 100vh;
        margin: 0;
    }

    header {
        background-color: #f9fafb;
        padding: 1rem;
        text-align: center;
        border-radius: 5px;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        text-align: center;
    }

    .status-pending {
        color: red;
        /* Red for pending */
    }

    .status-in-progress {
        color: blue;
        /* Yellow for in progress */
    }

    .status-completed {
        color: green;
        /* Green for completed */
    }

    .status-uppercase {
        text-transform: uppercase;
        /* Change text to uppercase */
    }
</style>

<body>
    <header><h2 class="header-title">CUSTOMER MANAGEMENT</h2></header>

    @if(session('success'))
    <div id="successAlert" class="alert alert-success d-flex align-items-center my-2" role="alert"
        style="font-size: 1rem; padding: 1rem;">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" style="width: 1.5em; height: 1.5em;">
            <use xlink:href="#check-circle-fill" />
        </svg>
        <div>
            {{ session('success') }}
        </div>
    </div>
    @endif
    
    <!-- Table -->
    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                List of Customers
            </div>
            
            <div class="ms-auto">
                <!-- This will push the button to the right -->
                <a href="{{ route('customer') }}" class="btn btn-primary">+ Add Customer</a>
                <a href="{{ route('pdfcustomer') }}" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i>
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->location }}</td>
                        <td>
                            <span
                                class="status-uppercase {{ $customer->status === 'pending' ? 'status-pending' : ($customer->status === 'in_progress' ? 'status-in-progress' : 'status-completed') }}">
                                {{ $customer->status }}
                            </span>
                        </td>

                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <a href="{{ route('editcustomer', $customer->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $customer->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel{{ $customer->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $customer->id }}">Confirm Deletion
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this data?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('deletecustomer', $customer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
@endsection