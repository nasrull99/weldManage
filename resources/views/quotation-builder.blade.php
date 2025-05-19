@extends('layouts.admin')
@section('title', 'Quotation')
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
        background-color: #007bff;
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

    body .select2-selection {
        background-color: #ffffff !important; /* Light gray background */
        border: 1px solid #ced4da !important; /* Light gray border */
        border-radius: 5px !important; /* Rounded corners */
        height: 38px !important; /* Height of the dropdown */
        display: flex; /* Use flexbox to align items */
        justify-content: space-between; /* Space between items */
        align-items: center; /* Center items vertically */
    }

    /* Style the rendered selection */
    body .select2-selection__rendered {
        color: #333 !important; /* Dark text color */
        line-height: 36px !important; /* Center vertically */
        flex-grow: 1; /* Allow it to take available space */
    }

    /* Clear button styling */
    body .select2-selection__clear {
        color: #dc3545; /* Red color for clear button */
        cursor: pointer; /* Change cursor to pointer */
        margin-right: 8px; /* Space from the right */
    }

    /* Dropdown arrow styling */
    body .select2-selection__arrow {
        height: 36px !important; /* Align with the height of the selection */
        right: 10px !important; /* Position the arrow */
    }
    
    .alert svg {
        margin-right: 10px; /* Adjust this value to increase/decrease the gap */
    }

</style>

<body>
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

    <header class="header-title">QUOTATION MANAGEMENT</header>

    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3">AMD SYNERGY</h1>
            <img src="{{ asset('images/logoAMD.jpeg') }}" alt="AMD Synergy Logo" class="img-fluid" style="max-width: 100px;">
        </div>

        <div class="card-body">
            <form id="quotationForm" method="POST" action="{{ route('quotation.save') }}">
                @csrf
                
                <!-- Customer selection dropdown -->
                <div class="mb-3">
                    <label for="customerSelect" class="form-label">Select Customer</label>
                    <select id="customerSelect" name="customer_id" class="form-select" required>
                        <option disabled selected></option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>                

                <!-- Hidden input for customer name -->
                <input type="hidden" id="customer_name" name="customer_name">

                <!-- Material selection -->
                <div class="mb-3">
                    <label for="materialSelect" class="form-label">Select Material</label>
                    <select id="materialSelect" name="materials[]" class="form-select" required>
                        <option disabled selected>Select a material</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}" data-price="{{ $material->price }}">{{ $material->material }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="materials" id="materials">

                <!-- Quantity input -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input id="quantity" name="quantity" class="form-control w-auto" type="number" min="1" value="1" required>
                </div>

                <!-- Button to add row -->
                <button type="button" class="btn btn-primary mb-3" onclick="addRowQuotation()">Add</button>

                <div class="cardbody">
                    <table id="maintable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Unit Price(RM)</th>
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

                <input type="hidden" name="quotationData" id="quotationData">

                <div class="output">
                    <button type="submit" class="btn btn-primary" onclick="submitFormQuotation()">Save</button>
                    <span id="totalAmountDisplay">Total Amount: RM0.00</span>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection