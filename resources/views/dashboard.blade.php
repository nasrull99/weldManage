@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f8fc;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh;
        margin: 0;
    }

    .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #007bff;
    color: white;
    border-radius: 8px;
    flex-wrap: wrap; /* Allow wrapping for smaller screens */
}

.header-title {
    font-size: 2rem;
    font-weight: bold;
    margin: 0;
    flex: 1 1 auto;
}

.logo {
    width: 120px;
    height: auto;
    margin-left: 20px;
    flex: 0 0 auto;
}

    .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background-color: #f8f9fc;
        border-top: 1px solid #000000;
        color: black;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        width: 100%; /* Ensures the card takes full width on smaller screens */
    }

    .card-header {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .card-header i {
        margin-right: 10px;
    }

    .card-body canvas {
        display: block;
        width: 100%;
        height: auto;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }

    @media (max-width: 1200px) {
        .col-xl-3 {
            width: 100%; /* Stacks the cards on smaller screens */
            margin-bottom: 20px;
        }
    }

    @media (max-width: 768px) {
        .col-xl-3 {
            width: 100%; /* Stacks the cards on smaller screens */
        }

        .header-container {
            flex-direction: column;
            align-items: flex-start;
            padding: 1rem;
        }

        .header-title {
            font-size: 1.5rem; /* Reduce font size for mobile */
            margin-bottom: 10px;
        }

        .logo {
            margin-top: 10px;
            margin-left: 10px;
        }

        .card-body {
            padding: 1rem;
        }

        .card-footer {
            padding: 0.5rem;
        }

        .table th, .table td {
            padding: 0.5rem;
        }
    }
</style>

<body>
    <header class="header-container">
        <h1 class="header-title">Dashboard</h1>
        <img src="images/logoAMD-no-bg.png" alt="AMD Synergy Logo" class="logo" />
    </header>

    <div class="container my-4">
        <div class="row">
            <!-- Customer Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <i class="fas fa-users me-1"></i>
                            Customer
                            <a href="{{ route('showname') }}" class="text-white small stretched-link"></a>
                        </h5>
                        <h3>{{ $customerCount }}</h3>
                    </div>
                </div>
            </div>

            <!-- Materials Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <i class="fa-solid fa-wrench"></i>
                            Materials
                            <a href="{{ route('tablematerial') }}" class="text-white small stretched-link"></a>
                        </h5>
                        <h3>{{ $materialCount }}</h3>
                    </div>
                </div>
            </div>

            <!-- Quotation Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            Quotation
                            <a href="{{ route('tablequotation') }}" class="text-white small stretched-link"></a>
                        </h5>
                        <h3>{{ $quotationCount }}</h3>
                    </div>
                </div>
            </div>

            <!-- Invoices Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <i class="fa-solid fa-dollar-sign"></i>
                            Invoices
                            <a href="{{ route('tableinvoice') }}" class="text-white small stretched-link"></a>
                        </h5>
                        <h3>{{ $invoiceCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users me-1"></i>
                    Recent Customers
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newCustomers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->status}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Monthly Income Chart -->
        <div class="col-xl-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Monthly Income</strong>
                </div>
                <div class="card-body">
                    <canvas id="monthlyIncomeChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales by Month Chart -->
        <div class="col-xl-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Sales by Month</strong>
                </div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Prepare data for Monthly Income chart
        const monthlyIncomeData = @json($monthlyIncome); // Convert PHP data to JS

        // Prepare labels (Months)
        const months = monthlyIncomeData.map(item => item.month);

        // Prepare data (Income)
        const income = monthlyIncomeData.map(item => item.total);

        // Create Monthly Income Bar Chart
        var ctx = document.getElementById('monthlyIncomeChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',  // Use 'bar' for bar chart
            data: {
                labels: months, // Months as x-axis
                datasets: [{
                    label: 'Monthly Income',
                    data: income, // Sales data
                    backgroundColor: 'rgba(0, 123, 255, 0.5)', // Bar color
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Prepare Sales Data for Monthly Sales chart
        const salesData = @json($monthlyIncome); // Reusing the same data structure

        // Prepare sales amounts (total sales value)
        const sales = salesData.map(item => item.total);

        // Create Monthly Sales Line Chart
        var ctx2 = document.getElementById('myAreaChart').getContext('2d');
        var mySalesChart = new Chart(ctx2, {
            type: 'line',  // Use 'line' for line chart
            data: {
                labels: months,  // Months as x-axis
                datasets: [{
                    label: 'Sales by Month',
                    data: sales,  // Sales data
                    fill: false,
                    borderColor: 'rgba(0, 123, 255, 1)', // Line color
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

@endsection
