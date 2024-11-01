<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Material PDF</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            font-size: 14px;
            margin: 10px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        img {
            display: block;
            margin: 10px auto;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <p>Date: {{ $date }}</p>
    <img src="{{ $image }}" alt="Company Logo" width="100">
    <p>{{ $content }}</p>

    <table id="datatablesSimple" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Material</th>
                <th>Unit Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($materials as $material)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $material->material }}</td>
                <td>RM{{ $material->price }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No materials found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>