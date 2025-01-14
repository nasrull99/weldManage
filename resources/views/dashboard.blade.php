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
    }

    .header-title {
        font-size: 2rem;
        font-weight: bold;
        margin: 0;
    }

    .logo {
        width: 120px;
        height: auto;
        margin-left: 20px;
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

    @media (max-width: 768px) {
        .header-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .logo {
            margin-top: 10px;
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
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            Customer
                            <a href="{{ route('showname') }}" class="text-white small stretched-link">
                            </a>
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Materials Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            Materials
                            <a href="{{ route('tablematerial') }}" class="text-white small stretched-link">
                            </a>
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Quotation Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            Quotation
                            <a href="{{ route('tablequotation') }}" class="text-white small stretched-link">
                            </a>
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Invoices Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            Invoices
                            <a href="{{ route('tableinvoicesView') }}" class="text-white small stretched-link">
                            </a>
                        </h5>
                    </div>
                </div>
            </div>


        <!-- Chart Section -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Sales
                    </div>
                    <div class="card-body">
                        <canvas id="myAreaChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Sales
                    </div>
                    <div class="card-body">
                        <canvas id="myBarChart" width="100%" height="40"></canvas>
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
            <div class="col-xl-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-line me-1"></i> Weekly Comparison
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Customers</h5>
                        <p>Current Week: {{ 25 }} Customers</p>
                        <p>Previous Week: {{ 18 }} Customers</p>
                    </div>
                </div>
            </div>
        </div>
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
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
 // Dummy data for monthly income
 const labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const data = [3000, 4000, 3500, 5000, 6000, 5500, 4500, 7000, 7500, 8000, 6500, 9000]; // Dummy income values

    // Create the chart
    new Chart(document.getElementById('monthlyIncomeChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Income (RM)',
                backgroundColor: '#007bff',
                data: data,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

        // Dummy data for months and customer counts
        var months = ['January', 'February', 'March', 'April', 'May', 'June'];
        var counts = [12, 19, 3, 5, 2, 3];

        // Dummy data for Area Chart
    var salesData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
            label: 'Sales',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    var areaCtx = document.getElementById('myAreaChart').getContext('2d');
    var myAreaChart = new Chart(areaCtx, {
        type: 'line',
        data: salesData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

        // Create the bar chart using Chart.js
        var ctx = document.getElementById('myBarChart').getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months, // months as labels
                datasets: [{
                    label: 'Customer Count',
                    data: counts, // customer counts as data
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                    borderColor: 'rgba(75, 192, 192, 1)', // Border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
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
