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
        margin-bottom: 1rem;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .btn {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .output {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
    font-size: 1rem;
    }

    .output span {
        border: 2px solid black;
        padding: 0.5rem;            
        border-radius: 5px;         
    }


</style>

<body>

    <header class="header-title">QUOTATION MANAGEMENT</header>

    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3">AMD SYNERGY</h1>
            <img src="{{ asset('images/logoAMD.jpeg') }}" alt="AMD Synergy Logo" class="img-fluid" style="max-width: 100px;">
        </div>
        <div class="card-body">
            <form method="POST">
                @csrf

                <!-- Customer selection dropdown -->
                <div class="mb-3">
                    <label for="customerInput" class="form-label">Select Customer</label>
                    <input type="text" id="customerInput" name="customer_name" class="form-control" placeholder="Enter Customer Name" required>
                </div>

                <!-- Material selection -->
                <div class="mb-3">
                    <label for="materialSelect" class="form-label">Select Material</label>
                    <select id="materialSelect" name="material_id" class="form-select" onchange="updatePrice()" required>
                        <option disabled selected>Select a material</option>
                        @foreach ($materials as $material)
                        <option value="{{ $material->material }}" data-price="{{ $material->price }}">{{ $material->material }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity input -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input id="quantity" name="quantity" class="form-control w-auto" type="number" min="1" value="1" onchange="updateAmount()" required>
                </div>

                <!-- Button to add row -->
                <button type="button" class="btn btn-primary mb-3" onclick="addRow()">Add</button>

                <div class="cardbody">
                    <table id="maintable"  class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Amount(RM)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be added here dynamically -->
                        </tbody>
                    </table>
                </div>

                <div class="output">
                    <button type="button" class="btn btn-primary">save</button>
                    <span id="totalAmountDisplay">Total Amount: RM0.00</span>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection
