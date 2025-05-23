@extends('layouts.admin')

@section('title', 'Customer Management')

@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #f0f2f5, #ffffff);
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #212529;
        padding: 1rem;
        margin: 1rem;
        text-align: center;
        border-radius: 10px;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ffffff;
        text-align: center;
    }

    .main-content {
        display: flex;
        justify-content: center;
        padding: 2rem 0;
    }

    .container {
        max-width: 900px;
        width: 100%;
        padding: 0 1rem;
    }

    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .form-group input {
        width: 100%;
        padding: 0.5rem;
        font-size: 1rem;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        outline: none;
    }

    .form-group input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }
</style>

<body>
    <header>
        <h2 class="header-title">CUSTOMER MANAGEMENT</h2>
    </header>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="h3">AMD SYNERGY</h1>
                    <img src="{{ asset('images/logoAMD.jpeg') }}" alt="AMD Synergy Logo" class="img-fluid" style="max-width: 100px;">
                </div>
                <div class="card-body">
                    <h1 class="card-title">CUSTOMER DETAILS</h1>
                    <div class="form-container">
                        <form action="{{ route('storecustomer') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}"> <!-- Hidden User ID Field -->

                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" placeholder="Enter customer username" required>
                                @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" placeholder="Enter customer name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number:</label>
                                <input type="text" id="phone" name="phone" placeholder="Enter customer phone number"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" placeholder="Enter customer email" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Address:</label>
                                <input type="text" id="location" name="location" placeholder="Enter customer Adress" required>
                            </div>
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="pending">PENDING</option>
                                    <option value="in_progress">IN PROGRESS</option>
                                    <option value="completed">COMPLETED</option>
                                </select>
                            </div>

                            <!-- Save Button -->
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

@endsection