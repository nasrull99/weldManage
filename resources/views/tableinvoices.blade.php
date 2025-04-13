@extends('layouts.admin')
@section('title', 'invoices List')
@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #f0f2f5, #ffffff);
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #007bff;
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
        background-color: #007bff;
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
        <h2 class="header-title">INVOICES MANAGEMENT</h2>
    </header>
    
    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-dollar-sign"></i>
                List of Invoices
            </div>
            
            <div class="ms-auto">
                <!-- This will push the button to the right -->
                <a href="{{ route('showInvoices') }}" class="btn btn-success"><i class="fa-solid fa-plus fa-flip-vertical"></i></a>
                <a href="#" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i>
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice ID</th>
                        <th>Customer Name</th>
                        <th>Total Price (RM)</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $invoice->id }}</td>
                        <td>{{ $invoice->customer->name }}</td>
                        <td>{{ number_format($invoice->totalamount, 2) }}</td>
                        <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <a href="{{ route('viewForCustomer', ['customerId' => $invoice->customer->id, 'invoiceId' => $invoice->id]) }}" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('editinvoice', ['id' => $invoice->id]) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('pdfinvoice', $invoice->id) }}"  class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-download"></i>
                                </a>                                                             
                                <!-- Trigger the modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $invoice->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal for Deletion Confirmation -->
                    <div class="modal fade" id="deleteModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $invoice->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $invoice->id }}">Delete invoice</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this invoice?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('deleteinvoice', ['id' => $invoice->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>


@endsection