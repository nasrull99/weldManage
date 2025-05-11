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
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        background-color: #007bff;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
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
        padding: 3rem;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 650px;
        padding: 2rem;
        margin: 20px;
    }

    .card-header {
        font-size: 1.75rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 1rem;
        text-align: center;
        border-bottom: 2px solid #007bff;
        padding-bottom: 1rem;
    }

    .card-body ul {
        list-style-type: none;
        padding: 0;
    }

    .card-body li {
        margin: 10px 0;
        font-weight: 500;
    }

    .card-body li strong {
        color: #007bff;
    }


    .alert {
        font-size: 1rem;
        padding: 1rem;
        margin-top: 10px;
        border-radius: 8px;
    }

    .alert svg {
        margin-right: 10px;
    }

    /* Responsive design for smaller screens */
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
        <img src="{{ asset('images/logoAMD-no-bg.png') }}" alt="AMD Synergy Logo" class="logo" />
    </header>

    @if(session('error'))
    <div id="errorAlert" class="alert alert-danger d-flex align-items-center my-2" role="alert"
        style="font-size: 1rem; padding: 1rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ban" viewBox="0 0 16 16">
            <path d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0"/>
          </svg>
        <div>
            {{ session('error') }}
        </div>
    </div>
    @elseif(session('success'))
    <div id="successAlert" class="alert alert-success d-flex align-items-center my-2" role="alert"
        style="font-size: 1rem; padding: 1rem;">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" style="width: 1.5em; height: 1.5em;">
            <use xlink:href="#check-circle-fill" />
        </svg>
        <div>
            {{ session('success') }}
        </div>
    </div>

    @endif

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
