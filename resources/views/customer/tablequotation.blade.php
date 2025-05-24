@extends('customer.layout.admin')
@section('title', 'Quotations List')
@section('content')

<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(120deg, #f0f2f5 0%, #e9ecef 100%);
        margin: 0;
        padding: 0;
    }

    .card {
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(44, 62, 80, 0.08);
        border: none;
        margin-bottom: 2rem;
    }

    .card-header {
        background: linear-gradient(90deg, #212529 60%, #343a40 100%);
        color: #fff;
        border-radius: 16px 16px 0 0;
        padding: 1.5rem 2rem;
        font-size: 1.3rem;
        font-weight: 600;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
    }

    .card-header i {
        margin-right: 10px;
        font-size: 1.5rem;
        color: #ffc107;
    }

    .card-body {
        padding: 2rem;
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        margin-bottom: 0;
    }

    .table th, .table td {
        padding: 1.1rem 1rem;
        vertical-align: middle;
        border: none;
    }

    .table th {
        background: #343a40;
        color: #fff;
        font-weight: 600;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    .table-striped tbody tr:hover {
        background-color: #e2e6ea;
        transition: background 0.2s;
    }

    .btn-group .btn {
        font-size: 1rem;
        padding: 0.45rem 0.9rem;
        border-radius: 6px;
        margin-right: 0.2rem;
        transition: background 0.2s, transform 0.2s;
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        color: #fff;
    }
    .btn-secondary:hover {
        background: #495057;
        color: #fff;
        transform: scale(1.08);
    }

    .modal-header {
        background: #212529;
        color: #fff;
        border-radius: 12px 12px 0 0;
        border-bottom: none;
        padding: 1.2rem 2rem;
    }

    .modal-title {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .btn-close {
        filter: invert(1);
        opacity: 0.8;
    }

    .modal-body {
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 0 0 12px 12px;
    }

    .spinner-border {
        width: 2.5rem;
        height: 2.5rem;
    }

    @media (max-width: 768px) {
        .card-body, .modal-body {
            padding: 1rem;
        }
        .card-header {
            padding: 1rem;
            font-size: 1rem;
        }
        .table th, .table td {
            padding: 0.7rem 0.5rem;
        }
    }
</style>

<div class="card my-4">
    <div class="card-header">
        <i class="fa-solid fa-file-invoice-dollar"></i>
        List of Quotations
    </div>

    <div class="card-body">
        <table id="datatablesSimple" class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quotation ID</th>
                    <th>Customer Name</th>
                    <th>Total Price (RM)</th>
                    <th>Date</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $quotation->id }}</td>
                        <td>{{ $quotation->customer?->name ?? 'N/A' }}</td>
                        <td>{{ number_format($quotation->totalamount, 2) }}</td>
                        <td>{{ $quotation->created_at->format('d/m/Y') }}</td>
                        <td style="text-align:center;">
                            <div class="btn-group" role="group" aria-label="Actions">
                                <button type="button"
                                    class="btn btn-secondary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewQuotationModal"
                                    data-url="{{ route('customer.quotations.view', ['customerId' => $quotation->customer_id, 'quotationId' => $quotation->id]) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal (only one, outside the loop) -->
<div class="modal fade" id="viewQuotationModal" tabindex="-1" aria-labelledby="viewQuotationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewQuotationModalLabel">Quotation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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