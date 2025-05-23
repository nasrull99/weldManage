@extends('layouts.admin')
@section('title', 'Invoice Receipt for Customer')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        height: 100vh;
        margin: 0;
    }

    .receipt-container {
        width: 90%;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .receipt-header h2 {
        font-size: 1.8rem;
        color: #333;
        margin: 0;
    }

    .receipt-header p {
        font-size: 1rem;
        color: #666;
        margin-top: 5px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        margin-bottom: 1rem;
        border-radius: 5px;
    }

    .table {
        width: 100%;
        min-width: 600px;
        background: #fff;
        border-radius: 5px;
    }

    .table th, .table td {
        vertical-align: middle !important;
        text-align: center;
    }

    .total {
        font-size: 1.1rem;
        font-weight: bold;
        text-align: right;
        margin-top: 20px;
    }

    .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 0.9rem;
        color: #666;
    }

    @media (max-width: 600px) {
        .receipt-container {
            width: 99%;
            padding: 8px;
        }
        .receipt-header h2 {
            font-size: 1.2rem;
        }
        .table {
            min-width: 400px;
            font-size: 0.95rem;
        }
        .total {
            font-size: 1rem;
        }
    }
</style>

<div class="receipt-container">

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

    <div class="receipt-header">
        <h2>Invoice Receipt</h2>
        <p>Name: {{ $customer->username }}</p>
        <p>Invoice ID: {{ $invoice->id }}</p>
        <p>Date: {{ $invoice->created_at->format('d/m/Y') }}</p>
    </div>

    @if ($invoice)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Material Name</th>
                        <th>Unit Price (RM)</th>
                        <th>Quantity</th>
                        <th>Amount (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                    @endphp
                    @foreach ($invoice->materials as $index => $material)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $material->material }}</td>
                            <td>{{ number_format($material->price, 2) }}</td>
                            <td>{{ $material->pivot->quantity }}</td>
                            <td>{{ number_format($material->price * $material->pivot->quantity, 2) }}</td>
                        </tr>
                        @php
                            $totalAmount += $material->price * $material->pivot->quantity;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span>Sub Total (RM):</span>
                <span><strong>{{ number_format($invoice->subtotal, 2) }}</strong></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span>Deposit (RM):</span>
                <span><strong>-{{ number_format($invoice->deposit, 2) }}</strong></span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px; border-top: 2px solid #ccc; border-bottom: 2px solid #ccc; margin-top: 15px; background-color: #f8f9fa;">
                <span style="font-weight: bold; font-size: 1.1rem;">Total Amount:</span>
                <span style="font-weight: bold; font-size: 1.1rem;">RM {{ number_format($invoice->totalamount, 2) }}</span>
            </div>
        </div>
        
    @else
        <p>No materials found for this invoice.</p>
    @endif

    <div class="footer">
        <p>Thank you for choosing us! If you have any questions, feel free to contact us.</p>
    </div>
</div>

@endsection