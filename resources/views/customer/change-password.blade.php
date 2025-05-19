@extends('customer.layout.admin')
@section('title', 'Change Password')

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

    .card {
        border-radius: 1rem;
    }
    .form-control {
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
    }
    .eye-toggle {
        cursor: pointer;
        color: #6c757d;
        transition: color 0.2s ease-in-out;
    }
    .eye-toggle:hover {
        color: #0d6efd;
    }
</style>

<body>
    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h3">AMD SYNERGY</h1>
            <img src="{{ asset('images/logoAMD.jpeg') }}" alt="AMD Synergy Logo" class="img-fluid" style="max-width: 100px;">
        </div> 

        <div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
            <div class="card shadow-lg border-0 w-100" style="max-width: 450px;">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-center fw-bold text-primary">Change Password</h4>

                    <!-- Success or Error Message -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif(session('success'))
                        <div id="successAlert" class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" width="20" height="20">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div>
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Password Change Form -->
                    <form method="POST" action="{{ route('customer.changePassword') }}">
                        @csrf

                        <div class="mb-3 position-relative">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Enter current password" required>

                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter new password" required>

                            @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Re-type new password" required>

                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
