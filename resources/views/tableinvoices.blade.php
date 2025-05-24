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
        background-color: #212529;
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
    
    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-dollar-sign"></i>
                List of Invoices
            </div>
            
            <div class="ms-auto">
                <!-- This will push the button to the right -->
                <a href="{{ route('showInvoices') }}" class="btn btn-success"><i class="fa-solid fa-plus fa-flip-vertical"></i></a>
            </div>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice ID</th>
                        <th>Customer Name</th>
                        <th>subtotal(RM)</th>
                        <th>deposit(RM)</th>
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
                        <td>{{ number_format($invoice->subtotal, 2) }}</td>
                        <td>{{ number_format($invoice->deposit, 2) }}</td>
                        <td>{{ number_format($invoice->totalamount, 2) }}</td>
                        <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <button type="button"
                                    class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewInvoiceModal" data-url="{{ route('invoices.viewForCustomer', ['customerId' => $invoice->customer->id, 'invoiceId' => $invoice->id]) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <a href="{{ route('editInvoice', ['id' => $invoice->id]) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('pdfInvoice', $invoice->id) }}"  class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-download"></i>
                                </a>                                                             
                                <!-- Trigger the modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $invoice->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Invoice View Modal -->
                    <div class="modal fade" id="viewInvoiceModal" tabindex="-1" aria-labelledby="viewInvoiceModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewInvoiceModalLabel">Invoice Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                                </div>
                                <div class="modal-body" id="invoiceModalBody">
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <div>Loading...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <form action="{{ route('invoices.destroy', ['id' => $invoice->id]) }}" method="POST">
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
<script>
$('#viewInvoiceModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    var modal = $(this);
    modal.find('#invoiceModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><div>Loading...</div></div>');
    $.get(url, function(data) {
        modal.find('#invoiceModalBody').html(data);
    });
});
</script>
@endsection