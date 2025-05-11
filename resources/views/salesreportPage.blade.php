@extends('layouts.admin')
@section('title', 'Sales Report')
@section('content')

<div class="container mt-5">
    <h1 class="text-center mb-4">Sales Report</h1>

    <!-- Summary Section -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text">RM {{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text">{{ $totalOrders }} Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Highest Sale</h5>
                    <p class="card-text">RM {{ number_format($highestSale, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            @if($start && $end)
                <h4 class="mt-4">Showing results from <strong>{{ $start }}</strong> to <strong>{{ $end }}</strong></h4>
            @endif
        </div>
        
        <div class="ms-auto">
            <a href="{{ route('salesreport.download', ['start_date' => $start, 'end_date' => $end]) }}" class="btn btn-primary">
                <i class="fa-solid fa-download"></i>PDF
            </a>
        </div>
    </div>    

    @if($salesData->count())
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Total Sales (RM)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesData as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->customer_name }}</td>
                        <td>RM {{ number_format($data->total, 2) }}</td>
                        <td>{{ Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mt-3">No sales data available for the selected range.</p>
    @endif

</div>

@endsection
