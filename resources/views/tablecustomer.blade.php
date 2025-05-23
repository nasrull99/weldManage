@extends('layouts.admin')

@section('title', 'Customer Management')

@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #f0f2f5, #ffffff);
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #212529;
        padding: 1rem;
        margin: 1rem;
        text-align: center;
        border-radius: 10px;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ffffff;
        text-align: center;
    }

    .status-pending {
        color: red;
        font-weight: bold;
    }

    .status-in-progress {
        color: blue;
        font-weight: bold;
    }

    .status-completed {
        color: green;
        font-weight: bold;
    }

    .status-uppercase {
        text-transform: uppercase;
    }

    /* Table styling */
    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th, .table td {
        padding: 1rem;
        text-align: left;
    }

    .table th {
        background-color: #212529;
        color: white;
        font-weight: bold;
    }

    .table td {
        background-color: #f9f9f9;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    .btn-group button {
        border-radius: 50%;
    }

    .btn {
        font-size: 1rem;
        padding: 0.5rem 1rem;
        margin: 0.25rem;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    /* Success alert */
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        font-size: 1rem;
        padding: 1rem;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-radius: 5px 5px 0 0;
    }

    .modal-footer {
        text-align: right;
    }
</style>

<body>
    <header>
        <h2 class="header-title">CUSTOMER MANAGEMENT</h2>
    </header>

    <!-- Show success or error message from session -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
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
                <i class="fas fa-users me-1"></i>
                List of Customers
            </div>
            
            <div class="ms-auto">
                <a href="{{ route('customer') }}" class="btn btn-success">
                    <i class="fa-solid fa-plus fa-flip-vertical"></i>
                </a>
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
                        <th>name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Adress</th>
                        <th>Status</th>
                        <th>view</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->location }}</td>
                        <td>
                            <span class="status-uppercase 
                                {{ $customer->status === 'pending' ? 'status-pending' : 
                                   ($customer->status === 'in_progress' ? 'status-in-progress' : 'status-completed') }}">
                                {{ $customer->status }}
                            </span>
                        </td>
                        <td>
                            @if($customer->quotations->count())
                                @foreach ($customer->quotations as $quotation)
                                    <div class="d-grid gap-1 mb-1">
                                        <a href="{{ route('viewForCustomer', ['customerId' => $quotation->customer->id, 'quotationId' => $quotation->id]) }}"
                                        class="btn btn-outline-primary btn-xs py-1 px-2 shadow-sm"
                                        style="font-size: 0.85rem; border-radius: 20px; min-width: 90px;">
                                            <i class="fa-solid fa-file-invoice-dollar me-1"></i> Quotation
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <span class="text-muted d-grid gap-1 mb-1" style="font-size: 0.9rem;">quotation not exist</span>
                            @endif
                            @if($customer->invoices->count())
                            @foreach ($customer->invoices as $invoice)
                                <div class="d-grid gap-1 mb-1">
                                    <a href="{{ route('invoices.viewForCustomer', ['customerId' => $invoice->customer->id, 'invoiceId' => $invoice->id]) }}"
                                    class="btn btn-outline-success btn-xs py-1 px-2 shadow-sm"
                                    style="font-size: 0.85rem; border-radius: 20px; min-width: 90px;">
                                        <i class="fa-solid fa-file-invoice me-1"></i> Invoice
                                    </a>
                                </div>
                            @endforeach
                            @else
                                <span class="text-muted d-grid gap-1 mb-1" style="font-size: 0.9rem;">invoice not exist</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <a href="{{ route('customer.tracker', $customer->id) }}" class="btn btn-success btn-sm" title="Job Progress">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                                <a href="{{ route('editcustomer', $customer->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $customer->id }}" title="Delete">
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
                                    <h5 class="modal-title" id="deleteModalLabel{{ $customer->id }}">Confirm Deletion</h5>
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
                    <tr>
                        <td colspan="8" class="text-center">No customers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
@endsection
