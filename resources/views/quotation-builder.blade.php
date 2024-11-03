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
                    <label for="customerSelect" class="form-label">Select Customer</label>
                    <select id="customerSelect" name="customer_id" class="form-select" required>
                        <option disabled selected>Select a Customer</option>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->name }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Material selection dropdown -->
                <div class="mb-3">
                    <label for="materialSelect" class="form-label">Select Material</label>
                    <select id="materialSelect" class="form-select">
                        <option disabled selected>Choose Material</option>
                        @foreach ($materials as $material)
                        <option value="{{ $material->id }}" data-unit-price="{{ $material->price }}">
                            {{ $material->material }}
                        </option>
                        @endforeach
                    </select>

                </div>

                <!-- Quantity input and Add button -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <div class="col-2">
                        <input type="number" id="quantity" class="form-control" min="1" placeholder="Enter Quantity">
                    </div>
                </div>

                <button type="button" class="btn btn-secondary" id="addMaterialButton">Add</button>

                <!-- Selected materials table -->
                <h5 class="mt-4 ">Selected Materials</h5>
                <table class="table table-bordered" id="selectedMaterialsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Material</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="selectedMaterials"></tbody>
                </table>

                <!-- Total Price Display -->
                <div class="mb-3">
                    <label for="total_price" class="form-label">Total Price</label>
                    <div class="col-2">
                        <input type="text" id="total_price" name="total_price" class="form-control " readonly>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>


</body>

@endsection