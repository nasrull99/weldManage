@extends('layouts.admin')
@section('title', 'Quotation')
@section('content')

<style>

    body{
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
            <img src="{{ asset('images/logoAMD.jpeg') }}" alt="AMD Synergy Logo" class="img-fluid" style="max-width: 100px;">
        </div>
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="customerSelect" class="form-label">Select Customer</label>
                    <select class="form-select" aria-label="Default select example">
                        <option disabled selected>Open this select menu</option>
                        @forelse ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @empty
                            <option disabled>No customers available</option>
                        @endforelse
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Quotation</button>
            </form>
        </div>
    </div>
    

</body>

@endsection