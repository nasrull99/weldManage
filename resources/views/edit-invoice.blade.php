@extends('layouts.admin')
@section('title', 'Edit Invoice')
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
        background-color: #212529;
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

      .total-amount-container {
        border: 1px solid #000000; /* Light gray border */
        padding: 15px; /* Padding inside the container */
        margin: 20px; /* Space above the container */
        background-color: #f9f9f9; /* Light background color */
    }

    .total-amount-title {
        font-size: 1.5em; /* Larger font size */
        margin-bottom: 10px; /* Space below the title */
        color: #333; /* Darker text color */
    }

    .amount-display {
        font-size: 1.2em; /* Slightly larger font size */
        margin: 5px 0; /* Space above and below each line */
        display: flex; /* Use flexbox for alignment */
        justify-content: space-between; /* Space between text and value */
        align-items: center; /* Center align items vertically */
    }

    .amount-display span {
        margin-left: 20px; /* Add consistent space between the text and the value */
        min-width: 80px; /* Ensure all values are aligned with the same width */
        text-align: right; /* Right-align the value */
    }

    .total-amount {
        font-weight: bold; /* Bold text for emphasis */
        color: #d9534f; /* Bootstrap danger color for total amount */
    }
</style>

<body>
    <header>
        <h2 class="header-title">EDIT INVOICE</h2>
    </header>



    <form action="{{ route('updateInvoice', $invoice->id) }}" method="POST">    
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
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
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="container my-4">
            <div class="card">
                <div class="card-header">
                    <strong>invoice Details</strong>
                </div>
                <div class="card-body">

                    <p>ID: {{ $invoice->id }}</p>

                    <div class="mb-3">
                        <label for="customerName" class="form-label">Customer Name:</label>
                        <input type="text" id="customerName" name="customer_name" 
                            value="{{ $invoice->customer->name }}" 
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
                        <label for="updatedeposit" class="form-label">deposit (RM)</label>
                        <input id="updatedeposit" name="updatedeposit" class="form-control w-auto" type="number" min="0" 
                               value="{{ $invoice->deposit }}" required>
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
                        <tbody id="invoiceItems">
                            @foreach ($invoice->materials as $index => $material)
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
                                        <button type="button"
                                            class="btn btn-danger btn-sm removeRow"
                                            data-invoice-id="{{ $invoice->id }}"
                                            data-material-id="{{ $material->id }}">
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <input type="hidden" id="subtotal" name="updatesubtotalinvoice" value="{{ $invoice->subtotal }}">
                    <input type="hidden" id="totalamount" name="updatetotalamountinvoice" value="{{ $invoice->totalamount }}">
                    <input type="hidden" id="updatenewdeposit" name="updatenewdeposit" value="{{ $invoice->deposit }}">

                    <div class="mt-3">
                        <div class="total-amount-container">
                            <div class="amount-display">Subtotal(RM): <span id="updatesubtotalinvoice">{{ number_format($invoice->subtotal, 2) }}</span></div>
                            <div class="amount-display">invoice(RM): <span id="updatedepositinvoice">{{ number_format($invoice->deposit, 2) }}</span></div>
                            <div class="amount-display total-amount">Total Amount(RM): <span id="updatetotalamountinvoice">{{ number_format($invoice->totalamount, 2) }}</span></div>
                            <button type="submit" class="btn btn-primary">update</button>
                            <a href="{{ route('tableinvoice') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
       // Automatic calculation when quantity or deposit changes
       function calculateTotal() {
            let subtotal = 0;

            // Sum all the amounts from the table
            document.querySelectorAll('.amount').forEach(amountCell => {
                subtotal += parseFloat(amountCell.textContent.replace(',', '').replace('RM', '').trim());
            });

            // Get the deposit value from the input
            const deposit = parseFloat(document.getElementById('updatedeposit').value) || 0;

            // Calculate the total amount (Total = Subtotal - Deposit)
            const totalAmount = subtotal - deposit;

            // Update the displayed subtotal, deposit, and total amount in the UI
            document.getElementById('updatesubtotalinvoice').textContent = subtotal.toFixed(2);
            document.getElementById('updatedepositinvoice').textContent = deposit.toFixed(2);
            document.getElementById('updatetotalamountinvoice').textContent = totalAmount.toFixed(2);

            // Update the hidden inputs (for form submission)
            document.getElementById('subtotal').value = subtotal.toFixed(2); // Subtotal
            document.getElementById('totalamount').value = totalAmount.toFixed(2); // Total Amount
            document.getElementById('updatenewdeposit').value = deposit.toFixed(2); // Deposit
        }

        // Event listener for updating quantities
        document.addEventListener('input', function (e) {
            if (e.target.classList.contains('updateQuantity')) {
                const row = e.target.closest('tr');
                const price = parseFloat(row.children[2].textContent);
                const quantity = parseFloat(e.target.value) || 0;
                const amountCell = row.querySelector('.amount');
                amountCell.textContent = (price * quantity).toFixed(2);
                calculateTotal();
            }

            if (e.target.id === 'updatedeposit') {
                calculateTotal(); // Recalculate total when deposit is changed
            }
        });

        // Event listener for removing materials
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('removeRow')) {
                const row = e.target.closest('tr');
                const invoiceId = e.target.getAttribute('data-invoice-id');
                const materialId = e.target.getAttribute('data-material-id');

                if (confirm('Are you sure you want to remove this material?')) {
                    // Send an AJAX request to remove the material from the database
                    fetch(`/invoice/${invoiceId}/material/${materialId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove the row from the table
                                row.remove();
                                calculateTotal(); // Recalculate totals
                                alert(data.message);
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to remove material. Please try again.');
                        });
                }
            }
        });

        // Calculate totals on page load
        window.onload = calculateTotal;

        document.getElementById('addMaterial').addEventListener('click', function () {
            const materialSelect = document.getElementById('material');
            const selectedOption = materialSelect.options[materialSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const materialId = materialSelect.value;
            const materialName = selectedOption.text;

            if (materialId) {
                const tbody = document.getElementById('invoiceItems');
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
                            <button type="button"
                                class="btn btn-danger btn-sm removeRow"
                                data-invoice-id="{{ $invoice->id }}"
                                data-material-id="{{ $material->id }}">
                                Remove
                            </button>
                        </td>
                    </tr>
                `);

                calculateTotal();
            }
        });
    </script>
</body>

@endsection
