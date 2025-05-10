@extends('layouts.admin')
@section('title', 'Material')
@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #f0f2f5, #ffffff);
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #007bff;
        padding: 1rem;
        margin: 1rem;
        text-align: center;
        border-radius: 10px;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ffffff;
        text-align: center;
    }

    /* Table styling */
    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th, .table td {
        padding: 1rem;
        text-align: left;
    }

    .table th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .table td {
        background-color: #f9f9f9;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    .btn-group button {
        border-radius: 50%;
    }

    .btn {
        font-size: 1rem;
        padding: 0.5rem 1rem;
        margin: 0.25rem;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    /* Success alert */
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        font-size: 1rem;
        padding: 1rem;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-radius: 5px 5px 0 0;
    }

    .modal-footer {
        text-align: right;
    }
</style>

<body>

    <div>
        <header class="header-title">MATERIALS MANAGEMENT</header>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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

    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-wrench"></i>
                List of Materials
            </div>
            <div class="ms-auto">
                <!-- This will push the button to the right -->
                <a href="{{ route('addmaterial') }}" class="btn btn-success"><i class="fa-solid fa-plus fa-flip-vertical"></i></a>
                <a href="{{ route('pdfmaterial') }}" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i>
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Material</th>
                        <th>Unit Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materials as $material)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $material->material }}</td>
                        <td>RM{{ $material->price }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <a href="{{ route('editmaterial', $material->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $material->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="deleteModal{{ $material->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel{{ $material->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $material->id }}">Confirm Deletion
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this data?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('destroymaterial', $material->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>

@endsection