@extends('layouts.admin')
@section('title', 'Quotations List')
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
        <h2 class="header-title">QUOTATION MANAGEMENT</h2>
    </header>

    <!-- Show success or error message from session -->
    @if(session('error'))
    <div id="errorAlert" class="alert alert-danger d-flex align-items-center my-2" role="alert"
        style="font-size: 1rem; padding: 1rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ban" viewBox="0 0 16 16">
            <path d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0"/>
          </svg>
        <div>
            {{ session('error') }}
        </div>
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
                <i class="fa-solid fa-file-invoice-dollar"></i>
                List of Quotations
            </div>
            
            <div class="ms-auto">
                <a href="{{ route('showQuotation') }}" class="btn btn-success"><i class="fa-solid fa-plus fa-flip-vertical"></i></a>
            </div>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Quotation ID</th>
                        <th>Customer Name</th>
                        <th>Total Price (RM)</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $quotation->id }}</td>
                        <td>{{ $quotation->customer->name }}</td>
                        <td>{{ number_format($quotation->totalamount, 2) }}</td>
                        <td>{{ $quotation->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <button type="button"
                                    class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewQuotationModal" data-url="{{ route('viewForCustomer', ['customerId' => $quotation->customer->id, 'quotationId' => $quotation->id]) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <a href="{{ route('editQuotation', ['id' => $quotation->id]) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('pdfQuotation', $quotation->id) }}"  class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-download"></i>
                                </a>                                                             
                                <!-- Trigger the modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $quotation->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Quotation View Modal -->
                    <div class="modal fade" id="viewQuotationModal" tabindex="-1" aria-labelledby="viewQuotationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewQuotationModalLabel">Quotation Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                                </div>
                                <div class="modal-body" id="quotationModalBody">
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <div>Loading...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Deletion Confirmation -->
                    <div class="modal fade" id="deleteModal{{ $quotation->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $quotation->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $quotation->id }}">Delete Quotation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this quotation?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('deleteQuotation', ['id' => $quotation->id]) }}" method="POST">
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
$('#viewQuotationModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    var modal = $(this);
    modal.find('#quotationModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><div>Loading...</div></div>');
    $.get(url, function(data) {
        modal.find('#quotationModalBody').html(data);
    });
});
</script>
@endsection
