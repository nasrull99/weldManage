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

    .total {
        font-size: 1.2rem;
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
</style>

<div class="receipt-container">
    <div class="receipt-header">
        <h2>Invoice Receipt</h2>
        <p>Name: {{ $customer->name }}</p>
        <p>Invoice ID: {{ $invoice->id }}</p>
        <p>Date: {{ $invoice->created_at->format('d/m/Y') }}</p>
    </div>

    @if ($invoice)
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
