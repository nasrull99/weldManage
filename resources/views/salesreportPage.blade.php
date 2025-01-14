@extends('layouts.admin')
@section('title', 'Quotations List')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Sales Report</h1>

        <!-- Summary Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="card-text">RM {{ number_format(50000, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text">120 Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Highest Sale</h5>
                        <p class="card-text">RM {{ number_format(1200, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="card">
            <div class="card-header">
                <h4>Monthly Sales</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total Amount (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dummy Data -->
                        <tr>
                            <td>1</td>
                            <td>User1</td>
                            <td>{{ number_format(8500, 2) }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>User3</td>
                            <td>{{ number_format(9200, 2) }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>User1</td>
                            <td>{{ number_format(11000, 2) }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>User4</td>
                            <td>{{ number_format(9800, 2) }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>User5</td>
                            <td>{{ number_format(11500, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
                <h4>TOTAL: RM30,000</h4>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

@endsection
