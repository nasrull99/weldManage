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
        <h2 class="header-title">Quotation</h2>
    </header>

</body>


@endsection
