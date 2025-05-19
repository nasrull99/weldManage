@extends('layouts.admin')
@section('title', 'Customer Tracker')
@section('content')

<style>
    .header-title {
        font-size: 2rem;
        font-weight: bold;
        color: #fff;
        text-align: center;
    }

    .main-content {
        padding: 2rem 1rem;
    }

    .card-custom {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .tracker-wrapper {
        position: relative;
        border-left: 4px solid #0d6efd;
        margin-top: 1rem;
        padding-left: 1.5rem;
    }

    .tracker-item {
        position: relative;
        padding-bottom: 15px;
    }

    .tracker-item:last-child {
        padding-bottom: 0;
    }

    .tracker-item::before {
        content: '';
        position: absolute;
        left: -36px;
        top: 0;
        width: 20px;
        height: 20px;
        background-color: #0d6efd;
        border: 3px solid white;
        border-radius: 50%;
        z-index: 1;
    }
    .tracker-content {
        background: #fff;
        padding: 1rem;
        border-radius: 0.75rem;
        border: 1px solid #e3e3e3;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

   .tracker-delete-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        margin: 0;
        z-index: 2;
    }

    @media (max-width: 768px) {
        .tracker-delete-btn {
            top: 8px;
            right: 8px;
        }
    }
</style>

<body>
    <header class="bg-primary py-3 text-center rounded mb-4 mx-3">
        <h2 class="header-title">CUSTOMER MANAGEMENT</h2>
    </header>

    <div class="container main-content">
        {{-- Alerts --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Show success or error message from session -->
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

        <div class="row g-4">
            {{-- Left Side - Customer Info and Form --}}
            <div class="col-md-5">
                <div class="card card-custom p-4">
                    <h4 class="text-primary fw-bold mb-3 text-center">Customer Information</h4>
                    <ul class="list-unstyled">
                        <li><strong>Name:</strong> {{ $customer->name }}</li>
                        <li><strong>Phone:</strong> {{ $customer->phone }}</li>
                        <li><strong>Location:</strong> {{ $customer->location }}</li>
                        <li><strong>Status:</strong> {{ $customer->status }}</li>
                    </ul>

                    <form action="{{ route('tracker.edit', $customer->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="time" class="form-label">Time</label>
                            <input type="time" id="time" name="time" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" id="image" name="image" class="form-control" alt="img" required accept="image/*,video/*">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Entry</button>
                    </form>
                </div>
            </div>

            {{-- Right Side - Timeline Tracker --}}
            <div class="col-md-7">
                <div class="card card-custom p-4">
                    <h5 class="fw-bold text-primary mb-3">Job Tracker History</h5>
                    @php
                        $history = $customer->description ? json_decode($customer->description, true) : [];
                        if (!is_array($history)) $history = [];
                    @endphp

                    @if(count($history))
                        <div class="tracker-wrapper">
                            @foreach($history as $index => $entry)
                                <div class="tracker-item mb-4">
                                    <div class="tracker-content" style="position: relative;">
                                        <div>
                                            <div><strong>Date & Time:</strong> {{ $entry['datetime'] ?? '-' }}</div>
                                            <div><strong>Description:</strong> {{ $entry['description'] ?? '-' }}</div>
                                            <div class="mt-2">
                                                @if(!empty($entry['image']))
                                                  @php
                                                    $ext = strtolower(pathinfo($entry['image'], PATHINFO_EXTENSION));
                                                    $isVideo = in_array($ext, ['mp4','avi','mov','wmv']);
                                                    $mime = $ext === 'mp4' ? 'video/mp4' : ($ext === 'mov' ? 'video/quicktime' : 'video/' . $ext);
                                                @endphp
                                                @if($isVideo)
                                                    <video controls style="border-radius:8px; max-width:100%; height:auto;">
                                                        <source src="{{ asset('storage/' . $entry['image']) }}" type="{{ $mime }}">
                                                        Your browser does not support the video tag or this video format. Please use MP4 for best compatibility.
                                                    </video>
                                                @else
                                                    <img src="{{ asset('storage/' . $entry['image']) }}" alt="Image" style="border-radius: 8px; max-width: 100%;">
                                                @endif
                                                @else
                                                    <span class="text-muted">No image/video</span>
                                                @endif
                                            </div>
                                        </div>
                                        <form action="{{ route('tracker.delete', [$customer->id, $index]) }}" method="POST" class="tracker-delete-btn">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                &times;
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-muted">No tracker history yet.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
