@extends('layouts.admin')

@section('title', 'Dashboard')
<!-- Set the title here -->

@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url('{{ asset('images/welcomebg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        height: 100vh;
        margin: 0;
    }

    .header-container {
        display: flex;
        /* Use flexbox for alignment */
        align-items: center;
        /* Center items vertically */
        justify-content: space-between;
        /* Space out the logo and title */
        padding: 1rem;
        /* Add padding around the header */
    }

    .header-title {
        font-size: 2rem;
        /* Increase font size for better visibility */
        font-weight: bold;
        /* Make the title bold */
        color: #ffffff;
        /* Dark color for the title */
        margin: 0;
        /* Remove default margin */
        text-align: left;
        /* Align text to the left */
    }

    .logo {
        width: 150px;
        /* Set a more appropriate size for the logo */
        height: auto;
        /* Maintain aspect ratio */
        margin-right: 20px;
        /* Space between the logo and title */
    }
</style>

<body>
    <header class="header-container">
        <h1 class="header-title">Dashboard</h1>
        <img src="images/logoAMD-no-bg.png" alt="AMD Synergy Logo" class="logo" />
    </header>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Customer</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('showname') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Materials</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('tablematerial') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Quotation</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('tablequotation') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Invoices</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('tableinvoicesView') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Bar Chart Example
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
</body>
@endsection