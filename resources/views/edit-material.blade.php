@extends('layouts.admin')

@section('title', 'Customer Management')

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

    header {
        background-color: #212529;
        padding: 1rem;
        margin: 1rem;
        text-align: center;
        border-radius: 5px;
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
        <h2 class="header-title">MATERIAL MANAGEMENT</h2>
    </header>

<!-- Display success message if material saved -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Display validation error messages -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">MATERIAL DETAILS</h1>
                    <div class="form-container">
                        <form action="{{ route('editsavedmaterial', $material->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Material:</label>
                                <input type="text" id="material" name="material" placeholder="Material name"
                                    value="{{ $material->material }}" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="text" id="price" name="price" placeholder="New price"
                                    value="{{ $material->price }}" required>
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