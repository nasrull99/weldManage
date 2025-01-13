@extends('layouts.admin')
@section('title', 'Quotations List')
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
        font-weight: 600;
        color: #333;
    }
</style>

<body>

    <header>
        <h2 class="header-title">QUOTATION MANAGEMENT</h2>
    </header>
    
    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                List of Quotations
            </div>
            
            <div class="ms-auto">
                <!-- This will push the button to the right -->
                <a href="{{ route('showQuotation') }}" class="btn btn-primary">+ Add Quotation</a>
                <a href="#" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i>
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Quotation ID</th>
                        <th>Customer Name</th>
                        <th>Total Price (RM)</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $quotation->id }}</td>
                        <td>{{ $quotation->customer->name }}</td>
                        <td>{{ number_format($quotation->totalamount, 2) }}</td>
                        <td>{{ $quotation->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('viewForCustomer', ['customerId' => $quotation->customer->id, 'quotationId' => $quotation->id]) }}" class="btn btn-primary btn-sm">
                                view
                            </a>
                            <a href="{{ route('editQuotation', ['id' => $quotation->id]) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('deleteQuotation', ['id' => $quotation->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this quotation?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

@endsection
