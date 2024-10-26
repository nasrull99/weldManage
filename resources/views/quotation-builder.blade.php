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

    .form-select{
        width: 500px;
    }

</style>

<body>

    <div>
        <header class="header-title">QUOTATION MANAGEMENT</header>
    </div>

    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form action="{{ route('showQuotation') }}" method="POST">
                <select class="form-select" aria-label="Default select example">
                    <option disabled selected>Open this select menu</option>
                        @forelse ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @empty
                        @endforelse
                </select>
            </form>
        </div>
    </div>

</body>

@endsection