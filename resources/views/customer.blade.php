@extends('layouts.admin')

@section('title', 'Customer Management')

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
        
        header {
            background-color: #f9fafb;
            padding: 1rem;
            text-align: center;
            border-radius: 5px;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
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
                <div class="card-body">
                    <h1 class="card-title">CUSTOMER DETAILS</h1>
                    <div class="form-container">
                        <form action="{{ route('storecustomer') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" placeholder="Enter customer name" required>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number:</label>
                                <input type="text" id="phone" name="phone" placeholder="Enter customer phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Location:</label>
                                <input type="text" id="location" name="location" placeholder="Enter Location" required>
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
