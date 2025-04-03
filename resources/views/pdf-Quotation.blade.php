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
        width: 100%;
        height: 100%;
        background-color: #fff;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        display: flex;
        flex-direction: column;
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .receipt-header h2 {
        font-size: 2.5rem;
        color: #333;
        margin: 0;
    }

    .receipt-header p {
        font-size: 1.1rem;
        color: #666;
        margin-top: 5px;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #000000;
    }

    .table th {
        background-color: #333;
        color: #ffffff;
    }

    .table tr:hover {
        background-color: #eaeaea;
    }

    .total {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: right;
        margin-top: 20px;
        color: #333;
    }

    .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 1rem;
        color: #666;
    }

    .footer p {
        margin: 0;
    }

    .receipt-header,
    .footer {
        flex-shrink: 0;
    }

    .table-container {
        overflow-y: auto;
        flex-grow: 1;
    }
</style>

<div class="receipt-container">
    <div class="receipt-header">
        <img src="{{ public_path('images/logoAMD-no-bg.png') }}" alt="Company Logo" style="width: 150px; margin-bottom: 20px;">
        <h2>Quotation Receipt</h2>
        <p>Name: {{ $customer->name }}</p>
        <p>Quotation ID: {{ $quotation->id }}</p>
        <p>Date: {{ $quotation->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="table-container">
        @if ($quotation && $quotation->materials->count() > 0)
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
                    @foreach ($quotation->materials as $index => $material)
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
                <p>Total Amount: RM {{ number_format($totalAmount, 2) }}</p>
            </div>
        @else
            <p>No materials found for this quotation.</p>
        @endif
    </div>

    <div class="footer">
        <p>Thank you for choosing us! If you have any questions, feel free to contact us.</p>
    </div>
</div>
