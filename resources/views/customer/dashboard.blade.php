@extends('customer.layout.admin')
@section('title', 'Dashboard')
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

    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 2rem;
        background-color: #007bff;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .header-title {
        font-size: 2rem;
        font-weight: bold;
        margin: 0;
    }

    .logo {
        width: 150px;
        height: auto;
    }

    .main-content {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        height: calc(100vh - 120px); /* Adjust for header height */
    }

    .card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        padding: 2rem;
    }

    .card-header {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 1rem;
        text-align: center;
    }

    .card-body p {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .card-body p strong {
        color: #007bff;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease;
    }
</style>

<body>
    <header class="header-container">
        <h1 class="header-title">Dashboard</h1>
        <img src="{{ asset('images/logoAMD-no-bg.png') }}" alt="AMD Synergy Logo" class="logo" />
    </header>

    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h2>Customer Information</h2>
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>Name:</strong> {{ $customer->name }}</li>
                    <li><strong>Phone:</strong> {{ $customer->phone }}</li>
                    <li><strong>Location:</strong> {{ $customer->location }}</li>
                    <li><strong>Status:</strong> {{ $customer->status }}</li>
                </ul>
            </div>
        </div>
    </div>
</body>

@endsection
