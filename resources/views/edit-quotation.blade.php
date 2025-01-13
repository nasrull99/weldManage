@extends('layouts.admin')
@section('title', 'Edit Quotation')
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

    header {
        background-color: #007bff;
        padding: 1rem;
        margin: 1rem;
        text-align: center;
        border-radius: 5px;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #ffffff;
        text-align: center;
    }
</style>

<body>
    <header>
        <h2 class="header-title">EDIT QUOTATION</h2>
    </header>

    <form action="{{ route('updateQuotation', $quotation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container my-4">
            <div class="card">
                <div class="card-header">
                    <strong>Quotation Details</strong>
                </div>
                <div class="card-body">

                    <p>ID: {{ $quotation->id }}</p>

                    <div class="mb-3">
                        <label for="customerName" class="form-label">Customer Name:</label>
                        <input type="text" id="customerName" name="customer_name" 
                            value="{{ $quotation->customer->name }}" 
                            class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="material" class="form-label">Select Material:</label>
                        <select id="material" class="form-select">
                            <option value="">-- Select Material --</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" 
                                    data-price="{{ $material->price }}">
                                    {{ $material->material }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="button" id="addMaterial" class="btn btn-primary">Add</button>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Material</th>
                                <th>Price (RM)</th>
                                <th>Quantity</th>
                                <th>Amount (RM)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="quotationItems">
                            @foreach ($quotation->materials as $index => $material)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <input type="hidden" name="materials[{{ $index }}][id]" value="{{ $material->id }}">
                                        {{ $material->material }}
                                    </td>
                                    <td>
                                        <span>{{ number_format($material->price, 2) }}</span>
                                    </td>
                                    <td>
                                        <input type="number" name="materials[{{ $index }}][quantity]" 
                                            value="{{ $material->pivot->quantity }}" 
                                            class="form-control updateQuantity" min="1">
                                    </td>
                                    <td class="amount">{{ number_format($material->price * $material->pivot->quantity, 2) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total Amount(RM):</strong></td>
                                <td id="totalAmount">{{ number_format($quotation->totalamount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Update Quotation</button>
                        <a href="{{ route('tablequotation') }}" class="btn btn-secondary">Cancel</a>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script>
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.amount').forEach(amountCell => {
                total += parseFloat(amountCell.textContent);
            });
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        }

        document.getElementById('addMaterial').addEventListener('click', function () {
            const materialSelect = document.getElementById('material');
            const selectedOption = materialSelect.options[materialSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const materialId = materialSelect.value;
            const materialName = selectedOption.text;

            if (materialId) {
                const tbody = document.getElementById('quotationItems');
                const existingRow = Array.from(tbody.querySelectorAll('input[name$="[id]"]'))
                    .find(input => input.value === materialId);

                if (existingRow) {
                    alert('Material already added.');
                    return;
                }

                const rowCount = tbody.children.length + 1;

                tbody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <td>${rowCount}</td>
                        <td>
                            <input type="hidden" name="materials[${rowCount - 1}][id]" value="${materialId}">
                            ${materialName}
                        </td>
                        <td>${parseFloat(price).toFixed(2)}</td>
                        <td>
                            <input type="number" name="materials[${rowCount - 1}][quantity]" 
                                class="form-control updateQuantity" min="1" value="1">
                        </td>
                        <td class="amount">${parseFloat(price).toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
                        </td>
                    </tr>
                `);

                calculateTotal();
            }
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('removeRow')) {
                e.target.closest('tr').remove();
                calculateTotal();
            }
        });

        document.addEventListener('input', function (e) {
            if (e.target.classList.contains('updateQuantity')) {
                const row = e.target.closest('tr');
                const price = parseFloat(row.children[2].textContent);
                const quantity = parseFloat(e.target.value) || 0;
                const amountCell = row.querySelector('.amount');
                amountCell.textContent = (price * quantity).toFixed(2);
                calculateTotal();
            }
        });
    </script>
</body>

@endsection
