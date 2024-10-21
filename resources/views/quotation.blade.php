@extends('layouts.admin')

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
        }

    .header-title {
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }
    .item-1{
        background-color: #ffffff;
    }
</style>

<body>

    <div>
        <header class="header-title">QUOTATION</header>
    </div>

    <div class="my-3">
        <table class="table table-bordered border primary">
            <div>
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Material</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </div>
        </table>
    </div>

</body>

@endsection