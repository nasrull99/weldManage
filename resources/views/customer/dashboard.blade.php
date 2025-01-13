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
        padding: 1rem;
    }

    .header-title {
        font-size: 2rem;
        font-weight: bold;
        color: #ffffff;
        margin: 0;
        text-align: left;
    }

    .logo {
        width: 150px;
        height: auto;
        margin-right: 20px;
    }
</style>

<body>
    <header class="header-container">
        <h1 class="header-title">Dashboard</h1>
        <img src="{{ asset('images/logoAMD-no-bg.png') }}" alt="AMD Synergy Logo" class="logo" />
    </header>

    <div class="card-body">
        <h1>Customer Details</h1>
        @if(isset($customer))
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone }}</p>
            <p><strong>Location:</strong> {{ $customer->location }}</p>
            <p><strong>Status:</strong> {{ ucfirst($customer->status) }}</p>
        @else
            <p>No customer found.</p>
        @endif
    </div>
</body>
@endsection