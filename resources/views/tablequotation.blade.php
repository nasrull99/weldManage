@extends('layouts.admin')
@section('title', 'Quotations List')
@section('content')

<h2>Customer List</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Customer Name</th>
            <th>Total Price (RM)</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($quotations as $quotation)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $quotation->customer->name }}</td>
            <td>RM {{ number_format($quotation->total_price, 2) }}</td>
            <td>{{ $quotation->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach --}}
    </tbody>
</table>

@endsection
