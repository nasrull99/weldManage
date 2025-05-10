<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    .receipt-container {
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .receipt-logo {
        text-align: left;
        margin-bottom: 20px;
        border-bottom: 2px solid #333;
        padding-bottom: 15px;
    }

    .receipt-logo img {
        width: 150px;
    }

    .receipt-logo h1 {
        font-size: 10px;
        color: #555;
    }

    .receipt-header {
        text-align: left;
        margin-bottom: 20px;
        border-bottom: 2px solid #333;
        padding-bottom: 15px;
    }

    .receipt-header h2 {
        font-size: 28px;
        color: #333;
        margin: 5px 0;
    }

    .receipt-header p {
        font-size: 14px;
        color: #555;
        margin: 5px 0;
    }

    .table-container {
        width: 100%;
        margin-top: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .table th, .table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    .table th {
        background-color: #333;
        color: white;
        text-transform: uppercase;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table td {
        color: #555;
    }

    .total {
        font-size: 16px;
        font-weight: bold;
        text-align: right;
        margin-top: 20px;
    }

    .total p {
        margin: 5px 0;
    }

    .footer {
        text-align: center;
        font-size: 14px;
        color: #777;
        margin-top: 30px;
        border-top: 2px solid #ddd;
        padding-top: 15px;
    }

    .footer p {
        margin: 0;
    }

    /* Avoid shrinking content */
    .receipt-header,
    .footer {
        flex-shrink: 0;
    }

    .table-container {
        flex-grow: 1;
    }

</style>

<div class="receipt-container">
    <div class="receipt-logo">
        <img src="{{ public_path('images/logoAMD-no-bg.png') }}" alt="Company Logo">
        <h1>202003238678 (KT0475972-K)</h1>
        <h1>KAMPUNG GERTAK KECHUPU</h1>
        <h1>KUBANG KERIAN</h1>
        <h1>16150 KOTA BHARU</h1>
        <h1>KELANTAN</h1>
    </div>
    <div class="receipt-header">
        <h2>Invoice Receipt</h2>
        <p><strong>Bill To:</strong> {{ $customer->name }}</p>
        <p><strong>Invoice ID:</strong> {{ $invoice->id }}</p>
        <p><strong>Date:</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="table-container">
        @if ($invoice && $invoice->materials->count() > 0)
            <table class="table">
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
                        $subtotal = 0;
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
                            $subtotal += $material->price * $material->pivot->quantity;
                        @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                <p><strong>Subtotal:</strong> RM {{ number_format($subtotal, 2) }}</p>
                <p><strong>Deposit:</strong> RM {{ number_format($invoice->deposit, 2) }}</p>
                <p><strong>Total Amount:</strong> RM {{ number_format($invoice->totalamount, 2) }}</p>
            </div>
        @else
            <p>No materials found for this invoice.</p>
        @endif
    </div>

    <div class="footer">
        <p>Thank you for choosing us! If you have any questions, feel free to contact us.</p>
    </div>
</div>