<style>
    .container {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #ffffff;
    }

    h1 {
        text-align: center;
        font-size: 2rem;
    }

    h3 {
        text-align: left;
        font-size: 1rem;
    }

    .summary {
        margin: 30px 0;
        display: block;
        text-align: center;
    }

    .summary .card {
        border-radius: 20px;
        color: white;
        font-size: 1rem;
        display: inline-block;
        width: 20%;
        text-align: center;
        box-sizing: border-box;
    }

    .summary .total-sales {
        background-color: #86da9a;
        color: rgb(0, 0, 0);
    }

    .summary .total-orders {
        background-color: #17a2b8;
        color: rgb(0, 0, 0);
    }

    .summary .highest-sale {
        background-color: #ffc107;
        color: black;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th, .table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .table th {
        background-color: #2c2c2c;
        color: rgb(255, 255, 255);
    }
</style>

<div class="container">
    <h1>Sales Report</h1>

    <!-- Summary Section -->
    <div class="summary">
        <div class="card total-sales">
            <h5>Total Sales</h5>
            <p>RM {{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="card total-orders">
            <h5>Total Orders</h5>
            <p>{{ $totalOrders }} Orders</p>
        </div>
        <div class="card highest-sale">
            <h5>Highest Sale</h5>
            <p>RM {{ number_format($highestSale, 2) }}</p>
        </div>
    </div>

    <h3>Showing results from <strong>{{ $start }}</strong> to <strong>{{ $end }}</strong></h3>

    <!-- Sales Data Table -->
    @if($salesData->count())
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Total Sales (RM)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesData as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->customer_name }}</td>
                        <td>RM {{ number_format($data->total, 2) }}</td>
                        <td>{{ Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No sales data available for the selected range.</p>
    @endif
</div>
