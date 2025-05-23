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
        padding: 2rem;
        background-color: #212529;
        color: white;
        border-radius: 8px;
        margin: 1rem;
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
        background-color: #212529;
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

    .card-hover {
        transition: all 0.2s;
        cursor: pointer;
    }
    .card-hover.bg-warning:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        transform: translateY(-5px) scale(1.03);
        transition: all 0.2s;
        cursor: pointer;
        background-color: #ffbf00 !important;
        color: #343a40 !important;
    }
    .card-hover.bg-success:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        transform: translateY(-5px) scale(1.03);
        transition: all 0.2s;
        cursor: pointer;
        background-color: #00ff84 !important;
        color: #343a40 !important;
    }
    .card-hover.bg-danger:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        transform: translateY(-5px) scale(1.03);
        transition: all 0.2s;
        cursor: pointer;
        background-color: #ff1500 !important;
        color: #343a40 !important;
    }
    .card-hover.bg-primary:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        transform: translateY(-5px) scale(1.03);
        transition: all 0.2s;
        cursor: pointer;
        background-color: #0062ff !important;
        color: #343a40 !important;
    }
</style>

<body>
    <header class="header-container">
        <h1 class="header-title">Dashboard</h1>
    </header>

    <div class="container my-4">
        <div class="row">
            <!-- Customer Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white card-hover" onclick="window.location='{{ route('showname') }}'">
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
                <div class="card bg-success text-white card-hover">
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
                <div class="card bg-danger text-white card-hover">
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
                <div class="card bg-primary text-white card-hover">
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

       <div class="row mb-4">
            <!-- Stats Cards (Left) -->
            <div class="col-lg-3 mb-4 d-flex">
                <div class="card w-100 h-100 shadow border-0">
                    <div class="card-header bg-gradient-primary text-white d-flex align-items-center" style="font-size:1.15rem;">
                        <i class="fas fa-chart-bar me-2"></i> Stats Summary
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0 text-center align-middle">
                            <tbody>
                                <tr>
                                    <th class="text-success d-flex align-items-center justify-content-center gap-2" style="font-weight:600; font-size:1.08rem;">
                                        <i class="fas fa-coins fa-lg"></i> Total Sales
                                    </th>
                                    <td class="fw-bold" style="font-size:1.1rem;">RM {{ number_format($totalSales, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-info d-flex align-items-center justify-content-center gap-2" style="font-weight:600; font-size:1.08rem;">
                                        <i class="fas fa-shopping-cart fa-lg"></i> Total Orders
                                    </th>
                                    <td class="fw-bold" style="font-size:1.1rem;">{{ $totalOrders }} Orders</td>
                                </tr>
                                <tr>
                                    <th class="text-warning d-flex align-items-center justify-content-center gap-2" style="font-weight:600; font-size:1.08rem;">
                                        <i class="fas fa-trophy fa-lg"></i> Highest Sale
                                    </th>
                                    <td class="fw-bold" style="font-size:1.1rem;">RM {{ number_format($highestSale, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Customers (Right) -->
            <div class="col-lg-9 mb-4 d-flex">
                <div class="card w-100 h-100">
                    <div class="card-header">
                        <i class="fas fa-users me-1"></i>
                        Recent Customers
                    </div>
                    <div class="card-body">
                        <table class="table table-striped align-middle table-bordered shadow-sm" style="border-radius: 12px; overflow: hidden; background: #fff;">
                            <thead class="table-body">
                                <tr style="font-size: 1.1rem;">
                                    <th style="width: 60px;">#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newCustomers as $customer)
                                    <tr style="font-size: 1.05rem;">
                                        <td class="fw-bold">{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $customer->username }}</td>
                                        <td>
                                            @php
                                                $status = strtolower($customer->status);
                                                $badgeClass = match($status) {
                                                    'pending' => 'text-danger',
                                                    'in_progress' => 'text-primary',
                                                    'completed' => 'text-success',
                                                    default => 'text-secondary',
                                                };
                                                $statusLabel = ucfirst(str_replace('_', ' ', $customer->status));
                                            @endphp
                                            <span class="badge {{ $badgeClass }} px-3 py-2" style="font-size: 1rem; letter-spacing: 1px; border-radius: 8px;">{{ $statusLabel }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Monthly Income Chart -->
        {{-- <div class="col-xl-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Monthly Income</strong>
                </div>
                <div class="card-body">
                    <canvas id="monthlyIncomeChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div> --}}

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
        // // Prepare data for Monthly Income chart
        // const monthlyIncomeData = @json($monthlyIncome); // Convert PHP data to JS

        // // Prepare labels (Months)
        // const months = monthlyIncomeData.map(item => item.month);

        // // Prepare data (Income)
        // const income = monthlyIncomeData.map(item => item.total);

        // // Create Monthly Income Bar Chart
        // var ctx = document.getElementById('monthlyIncomeChart').getContext('2d');
        // var myChart = new Chart(ctx, {
        //     type: 'bar',  // Use 'bar' for bar chart
        //     data: {
        //         labels: months, // Months as x-axis
        //         datasets: [{
        //             label: 'Monthly Income',
        //             data: income, // Sales data
        //             backgroundColor: 'rgba(0, 123, 255, 0.5)', // Bar color
        //             borderColor: 'rgba(0, 123, 255, 1)',
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

        // Prepare Sales Data for Monthly Sales chart
        const salesData = @json($monthlyIncome); // Reusing the same data structure

        // Prepare sales amounts (total sales value)
        const months = salesData.map(item => item.month);
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
                    borderColor: 'rgba(0, 0, 0, 1)', // Line color
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'RM ' + value;
                            }
                        },
                        title: {
                            display: true,
                            text: 'Sales (RM)'
                        },
                    }
                }
            }
        });
    </script>

</body>

@endsection
