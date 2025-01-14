@extends('layouts.admin')
@section('title', 'Quotation Receipt for Customer')

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
        <h2>Quotation Receipt</h2>
        <p>Name: User1</p>
        <p>Quotation ID: 1</p>
        <p>Date: 14/1/2025</p>
    </div>

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
                    <tr>
                        <td>1</td>
                        <td>abc</td>
                        <td>2000</td>
                        <td>5</td>
                        <td>10000</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>abcd</td>
                        <td>2000</td>
                        <td>5</td>
                        <td>10000</td>
                    </tr>
            </tbody>
        </table>

        <div class="total">
            <p>Total Amount: RM 20,000</p>
        </div>

    <div class="footer">
        <p>Thank you for choosing us! If you have any questions, feel free to contact us.</p>
    </div>
</div>

@endsection
