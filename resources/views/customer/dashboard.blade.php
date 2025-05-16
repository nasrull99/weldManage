@extends('customer.layout.admin')
@section('title', 'Dashboard')
@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
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
        flex-wrap: wrap;
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
        padding: 3rem 1rem;
        flex-wrap: wrap;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 700px;
        padding: 2rem;
        margin: 20px;
    }

    .card-header {
        font-size: 1.75rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 1.5rem;
        text-align: center;
        border-bottom: 2px solid #007bff;
        padding-bottom: 1rem;
    }

    .card-body ul {
        list-style: none;
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
        margin: 1rem auto;
        max-width: 700px;
        border-radius: 8px;
    }

    .tracker-wrapper {
        background: #f8f9fa;
        border: 1px solid #e3e3e3;
        position: relative;
        padding-left: 30px;
        border-left: 3px solid #0d6efd;
        margin-top: 30px;
        padding: 1rem;
        border-radius: 8px;
    }

    .tracker-item {
        position: relative;
        padding-bottom: 30px;
    }

    .tracker-item:last-child {
        padding-bottom: 0;
    }

    .tracker-item::before {
        content: '';
        position: absolute;
        left: -27px;
        top: 0;
        width: 20px;
        height: 20px;
        background-color: #0d6efd;
        border: 3px solid white;
        border-radius: 50%;
        z-index: 1;
    }

    .tracker-content {
        background: #fff;
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .header-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .logo {
            margin-top: 10px;
        }

        .card,
        .alert {
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<body>
    <header class="header-container">
        <h1 class="header-title">Dashboard</h1>
        <img src="{{ asset('images/logoAMD-no-bg.png') }}" alt="AMD Synergy Logo" class="logo" />
    </header>

    @if(session('error'))
    <div id="errorAlert" class="alert alert-danger d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div>{{ session('error') }}</div>
    </div>
    @elseif(session('success'))
    <div id="successAlert" class="alert alert-success d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    <div class="main-content">
        <div class="card">
            <div class="card-header">Customer Information</div>

            <div class="card-body">
                <ul>
                    <li><strong>Name:</strong> {{ $customer->name }}</li>
                    <li><strong>Phone:</strong> {{ $customer->phone }}</li>
                    <li><strong>Location:</strong> {{ $customer->location }}</li>
                    <li><strong>Status:</strong> {{ $customer->status }}</li>
                </ul>
            </div>

            <div class="tracker-wrapper">
                <h5 class="mb-3">Job Tracker</h5>
                @php
                    $history = $customer->description ? json_decode($customer->description, true) : [];
                    if (!is_array($history)) $history = [];
                @endphp

                @if(count($history))
                    @foreach($history as $entry)
                        <div class="tracker-item">
                            <div class="tracker-content">
                                <div><strong>Date & Time:</strong> {{ $entry['datetime'] ?? '-' }}</div>
                                <div><strong>Description:</strong> {{ $entry['description'] ?? '-' }}</div>
                                <div class="mt-2">
                                    @if(!empty($entry['image']))
                                        @php
                                            $ext = pathinfo($entry['image'], PATHINFO_EXTENSION);
                                            $isVideo = in_array(strtolower($ext), ['mp4','avi','mov','wmv']);
                                        @endphp
                                        @if($isVideo)
                                            <video controls style="border-radius:8px; max-width:100%; height:auto;">
                                                <source src="{{ asset('storage/' . $entry['image']) }}" type="video/{{ $ext }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{{ asset('storage/' . $entry['image']) }}" alt="Image" style="border-radius: 8px; max-width: 100%;">
                                        @endif
                                    @else
                                        <span class="text-muted">No image/video</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <span class="text-muted">No tracker history yet.</span>
                @endif
            </div>
        </div>
    </div>
</body>

@endsection
