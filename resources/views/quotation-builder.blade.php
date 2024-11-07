@extends('layouts.admin')
@section('title', 'Quotation')
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
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }
</style>

<body>

    <div>
        <header class="header-title">QUOTATION MANAGEMENT</header>
    </div>

    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3">AMD SYNERGY</h1>
            <img src="{{ asset('images/logoAMD.jpeg') }}" alt="AMD Synergy Logo" class="img-fluid"
                style="max-width: 100px;">
        </div>
        <div class="card-body">
            <form method="POST">
                @csrf

                <!-- Customer selection dropdown -->
                <div class="mb-3">
                    <label for="customerInput" class="form-label">Select Customer</label>
                    <input type="text" id="customerInput" name="customer_name" class="form-control" placeholder="Enter Customer Name" required>
                </div>

                <div class="mb-3">
                    <label for="materialSelect" class="form-label">Select material</label>
                    <select id="materialSelect" name="material_id" class="form-select" required>
                        <option disabled selected>Select a material</option>
                        @foreach ($materials as $material)
                        <option value="{{ $material->material }}">{{ $material->material }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input id="quantity" name="quantity" class="form-control w-auto" type="number" min="1" required>
                </div>

                <button type="button" class="btn btn-primary">add</button>
            </form>
        </div>
    </div>
</body>

@endsection