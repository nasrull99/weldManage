/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

document.addEventListener('DOMContentLoaded', function () {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        // Start fade-out after 3 seconds
        setTimeout(() => {
            successAlert.classList.add('fade-out');
        }, 3000);

        // Remove the alert from the DOM after the fade-out transition (3.5 seconds total)
        setTimeout(() => {
            successAlert.remove();
        }, 3500);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
        // Start fade-out after 3 seconds
        setTimeout(() => {
            errorAlert.classList.add('fade-out');
        }, 3000);

        // Remove the alert from the DOM after the fade-out transition (3.5 seconds total)
        setTimeout(() => {
            errorAlert.remove();
        }, 3500);
    }
});

$(document).ready(function() {
    $('#customerSelect').select2({
        placeholder: "Select a customer",
        allowClear: true
    });
});

//QUOTATION
// Function to add a row in the quotation
function addRowQuotation() {
    const customerSelect = document.getElementById("customerSelect");
    const materialSelect = document.getElementById("materialSelect");
    const quantityInput = document.getElementById("quantity");

    const materialId = materialSelect.value;
    const material = materialSelect.options[materialSelect.selectedIndex].text;
    const price = parseFloat(materialSelect.options[materialSelect.selectedIndex].getAttribute("data-price"));
    const quantity = parseInt(quantityInput.value);
    const amount = (price * quantity).toFixed(2);

    const materialsInput = document.getElementById('materials');
    let materials = JSON.parse(materialsInput.value || '[]');

    const materialExists = materials.some(item => item.material_id === materialId);
    if (materialExists) {
        // Alert the user that the material is already added
        alert(`Material "${material}" has already been added to the quotation.`);
        return; // Stop further execution if the material is already added
    }

    // Check for validation (if customer, material, or quantity is invalid)
    if (!material || material === "Select a material" || isNaN(price) || price <= 0 || isNaN(quantity) || quantity < 1) {
        alert("Please fill all required fields correctly.");
        return;
    }

    // Add new row to the table
    const tableBody = document.getElementById("maintable").getElementsByTagName("tbody")[0];
    const newRow = tableBody.insertRow();
    newRow.innerHTML = `
        <td></td>
        <td>${material}<input type="hidden" id="material-${materialId}" value="${materialId}"></td>
        <td>${price.toFixed(2)}<input type="hidden" id="price-${materialId}" value="${price.toFixed(2)}"></td>
        <td>${quantity}<input type="hidden" id="quantity-${materialId}" value="${quantity}"></td>
        <td>${amount}<input type="hidden" id="amount-${materialId}" value="${amount}"></td>
        <td>
            <button type="button" class="btn btn-primary btn-sm" onclick="editRowQuotation(this)">edit</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRowQuotation(this)">X</button>
        </td>
    `;

    // Update row numbers and total
    updateRowNumbers();
    calculateAmountSumQuotation();
    updateMaterialsInput();

    materialSelect.selectedIndex = 0; 
    quantityInput.value = 1;
}

function editRowQuotation(button) {
    // Get the row that contains the button
    const row = button.closest('tr');

    // Get the quantity cell and amount cell
    const quantityCell = row.cells[3];
    const amountCell = row.cells[4];

    // Get the current quantity
    const currentQuantity = parseInt(quantityCell.textContent);

    // Create an input field for editing the quantity
    const input = document.createElement('input');
    input.type = 'number';
    input.value = currentQuantity;
    input.min = 1;

    // Create a save button
    const saveButton = document.createElement('button');
    saveButton.textContent = 'Save';
    saveButton.classList.add('btn', 'btn-success', 'btn-sm');

    // Replace the quantity cell content with the input field and save button
    quantityCell.innerHTML = '';
    quantityCell.appendChild(input);
    quantityCell.appendChild(saveButton);

    // Add event listener for the save button
    saveButton.addEventListener('click', () => {
        const newQuantity = parseInt(input.value);
        if (isNaN(newQuantity) || newQuantity < 1) {
            alert("Please enter a valid quantity.");
            return;
        }

        // Get the price from the price cell
        const price = parseFloat(row.cells[2].textContent);

        // Calculate the new amount
        const newAmount = price * newQuantity;

        // Update the quantity and amount cells (visually)
        quantityCell.textContent = newQuantity;
        amountCell.textContent = newAmount.toFixed(2);

        // Re-add hidden input fields for quantity and amount
        const hiddenQuantityInput = document.createElement('input');
        hiddenQuantityInput.type = 'hidden';
        hiddenQuantityInput.id = `quantity-${row.rowIndex}`;
        hiddenQuantityInput.value = newQuantity;

        const hiddenAmountInput = document.createElement('input');
        hiddenAmountInput.type = 'hidden';
        hiddenAmountInput.id = `amount-${row.rowIndex}`;
        hiddenAmountInput.value = newAmount.toFixed(2);

        row.appendChild(hiddenQuantityInput);
        row.appendChild(hiddenAmountInput);

        // Update the materials array in the hidden input
        updateMaterialsInput();

        // Recalculate the total amount
        calculateAmountSumQuotation();
    });
}

// Function to remove a row from the quotation
function removeRowQuotation(button) {
    const row = button.parentElement.parentElement;
    const amountCell = row.cells[4];
    const amount = parseFloat(amountCell.textContent);

    // Remove the row from the table
    row.parentElement.removeChild(row);

    // Update row numbers and total
    updateRowNumbers();
    calculateAmountSumQuotation();
    updateMaterialsInput();
}

function updateMaterialsInput() {
    const rows = document.querySelectorAll('#maintable tbody tr');
    const materials = [];

    rows.forEach(row => {
        // Log the row structure to see if the inputs exist
        console.log("new row:", row);

        // Extract materialId from the hidden input with id="material-{materialId}"
        const materialId = row.querySelector('input[id^="material-"]') ? row.querySelector('input[id^="material-"]').value : null;
        const quantity = row.querySelector('input[id^="quantity-"]') ? row.querySelector('input[id^="quantity-"]').value : null;
        const price = row.querySelector('input[id^="price-"]') ? row.querySelector('input[id^="price-"]').value : null;
        const amount = row.querySelector('input[id^="amount-"]') ? row.querySelector('input[id^="amount-"]').value : null;

        // Only push if all necessary values are available
        if (materialId && quantity && price && amount) {
            materials.push({
                material_id: materialId,
                quantity: quantity,
                price: price,
                amount: amount
            });
        }
    });

    // Log the materials array to ensure it has the correct data
    console.log("Materials Data:", materials);

    // Update the hidden #materials field with the materials data in JSON format
    document.getElementById('materials').value = JSON.stringify(materials);
}

function calculateAmountSumQuotation() {
    const rows = document.querySelectorAll("#maintable tbody tr");
    let totalSum = 0;

    rows.forEach(row => {
        const amountCell = row.cells[4];
        const amount = parseFloat(amountCell.textContent);
        if (!isNaN(amount)) {
            totalSum += amount;
        }
    });

    document.getElementById("totalAmountDisplay").textContent = "Total Amount: RM" + totalSum.toFixed(2);
}

function submitFormQuotation() {
    // Ensure all row data is updated in the hidden fields
    updateMaterialsInput();
    return true; // Proceed with the form submission
}

//INVOICES
function addRowInvoice() {
    // Get the material select element and quantity input element
    const customerSelect = document.getElementById("customerSelect");
    const materialSelect = document.getElementById("materialSelect");
    const quantityInput = document.getElementById("quantity");
    const depositInput = document.getElementById("deposit");

    // Get the selected material and its price
    const customer = customerSelect.options[customerSelect.selectedIndex].text;
    const materialId = materialSelect.options[materialSelect.selectedIndex].value; // get material ID
    const material = materialSelect.options[materialSelect.selectedIndex].text;
    const quantity = parseInt(quantityInput.value);
    const price = parseFloat(materialSelect.options[materialSelect.selectedIndex].getAttribute("data-price"));

    // Check if the material is already in the materials array
    const materialsInput = document.getElementById('materials');
    let materials = JSON.parse(materialsInput.value || '[]');

    const materialExists = materials.some(item => item.material_id === materialId);
    if (materialExists) {
        // Alert the user that the material is already added
        alert(`Material "${material}" has already been added to the invoice.`);
        return; // Stop further execution if the material is already added
    }

    // Get the quantity and calculate the amount
    const amount = (price * quantity).toFixed();

    // Check if customer and material is selected and quantity is valid
    if (!customer || customer === "Select a customer") { 
        alert("Please select a customer.");
        return;
    }
    if (!material || material === "Select a material") { 
        alert("Please select a material.");
        return;
    }
    if (isNaN(price) || price <= 0) { 
        alert("Please select a valid material with a price.");
        return;
    }
    if (isNaN(quantity) || quantity < 1) { 
        alert("Please enter a valid quantity (greater than 0).");
        return;
    }

    // Get the table body element
    const tableBody = document.getElementById("maintable").getElementsByTagName("tbody")[0];

    // Create a new row element
    const newRow = tableBody.insertRow();

    // Set the inner HTML of the new row
    newRow.innerHTML = `
        <td></td>  
        <td>${material}<input type="hidden" id="material-${materialId}" value="${materialId}"></td>
        <td>${price.toFixed(2)}<input type="hidden" id="price-${materialId}" value="${price.toFixed(2)}"></td>
        <td>${quantity}<input type="hidden" id="quantity-${materialId}" value="${quantity}"></td>
        <td>${amount}<input type="hidden" id="amount-${materialId}" value="${amount}"></td>
        <td>
            <button type="button" class="btn btn-primary btn-sm" onclick="editRowInvoice(this)">edit</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRowInvoice(this)">X</button>
        </td>
    `;

    // Update row numbers after adding a new row
    updateRowNumbers();

    // Calculate the total amount
    calculateAmountSumInvoice();    
    addInvoicesData(materialId, quantity);

    materialSelect.selectedIndex = 0; 
    quantityInput.value = 1;
}

function addInvoicesData(materialId, quantity) {
    const materialsInput = document.getElementById('materials');
    let materials = JSON.parse(materialsInput.value || '[]');

    // Find if the material already exists in the array
    let materialIndex = materials.findIndex(material => material.material_id === materialId);

    if (materialIndex !== -1) {
        // Update the existing material's quantity
        materials[materialIndex].quantity = quantity;
    } else {
        // Add new material data if it doesn't exist
        materials.push({
            material_id: materialId,
            quantity: quantity
        });
    }

    // Update the hidden input with the new materials data as a JSON string
    materialsInput.value = JSON.stringify(materials);
}


// Function to edit a row
function editRowInvoice(button) {
    const row = button.closest('tr');
    const quantityCell = row.cells[3];
    const amountCell = row.cells[4];

    const currentQuantity = parseInt(quantityCell.textContent);

    const input = document.createElement('input');
    input.type = 'number';
    input.value = currentQuantity;
    input.min = 1;

    const saveButton = document.createElement('button');
    saveButton.textContent = 'Save';
    saveButton.classList.add('btn', 'btn-success', 'btn-sm');

    quantityCell.innerHTML = '';
    quantityCell.appendChild(input);
    quantityCell.appendChild(saveButton);

    saveButton.addEventListener('click', () => {
        const newQuantity = parseInt(input.value);
        if (isNaN(newQuantity) || newQuantity < 1) {
            alert("Please enter a valid quantity.");
            return;
        }

        const price = parseFloat(row.cells[2].textContent);
        const newAmount = price * newQuantity;

        // Update the cells visually
        quantityCell.textContent = newQuantity;
        amountCell.textContent = newAmount.toFixed(2);

        // Update hidden inputs
        const materialId = row.querySelector('input[id^="material-"]').value;
        const hiddenQuantityInput = document.getElementById(`quantity-${materialId}`);
        const hiddenAmountInput = document.getElementById(`amount-${materialId}`);

        if (hiddenQuantityInput) hiddenQuantityInput.value = newQuantity;
        if (hiddenAmountInput) hiddenAmountInput.value = newAmount.toFixed(2);

        calculateAmountSumInvoice();
        addInvoicesData(materialId, newQuantity); 
    });
}

// function removeRowInvoice(button) {
//     // Get the row that contains the button
//     const row = button.parentElement.parentElement;
//     const amountCell = row.cells[4]; 
//     const amount = parseFloat(amountCell.textContent); 

//     // Remove the row from the table
//     row.parentElement.removeChild(row);

//     // Deduct the amount from the total sum
//     if (!isNaN(amount)) {
//         // Update the subtotal and total amount displays
//         const subtotalDisplay = document.getElementById("totalAmountDisplayAmount");
//         const depositDisplay = document.getElementById("totalAmountDisplayDeposit");
//         const totalDisplay = document.getElementById("totalAmountDisplayTotal");

//         let currentSubtotal = parseFloat(subtotalDisplay.textContent);
//         let currentDeposit = parseFloat(depositDisplay.textContent);
//         let currentTotal = parseFloat(totalDisplay.textContent);

//         // Update the subtotal
//         currentSubtotal -= amount; 
//         subtotalDisplay.textContent = currentSubtotal.toFixed(2);

//         // Update the total amount (considering deposit)
//         currentTotal = currentSubtotal - currentDeposit; 
//         totalDisplay.textContent = currentTotal.toFixed(2);
//     }

//     // Update row numbers after removing a row
//     updateRowNumbers();
//     calculateAmountSumInvoice();
// }

function removeRowInvoice(button) {
    // Get the row that contains the button
    const row = button.parentElement.parentElement;
    const materialId = row.querySelector('input[id^="material-"]').value;

    // Remove the row from the table
    row.remove();

    // Update the materials array
    const materialsInput = document.getElementById('materials');
    let materials = JSON.parse(materialsInput.value || '[]');

    // Filter out the removed material
    materials = materials.filter(material => material.material_id !== materialId);

    // Update the hidden input with the new materials data as a JSON string
    materialsInput.value = JSON.stringify(materials);

    // Recalculate totals
    calculateAmountSumInvoice();
    updateRowNumbers();
}


//Function to calculate the total amount
function calculateAmountSumInvoice() {
    // Get all rows in the table body
    const rows = document.querySelectorAll("#maintable tbody tr");

    // Initialize the total sum
    let totalSum = 0;

    // Iterate over each row
    rows.forEach(row => {
        // Get the amount cell
        const amountCell = row.cells[4]; // Assuming the amount is in the 5th column (index 4)

        // Get the amount
        const amount = parseFloat(amountCell.textContent);

        // Check if amount is valid
        if (!isNaN(amount)) {
            // Add the amount to the total sum
            totalSum += amount;
        }
    });

    // Get the deposit value from the input field
    const depositInput = document.getElementById("deposit");
    const depositValue = parseFloat(depositInput.value);

    let depositDisplayValue = 0;

    // Check if deposit value is valid
    if (!isNaN(depositValue)) {
        depositDisplayValue = -depositValue; // Store as negative for display
    }

    const finalTotal = totalSum + depositDisplayValue; // Subtracting deposit by adding a negative value

    // Update the total amount display
    document.getElementById("totalAmountDisplayAmount").textContent = totalSum.toFixed(2);
    document.getElementById("totalAmountDisplayDeposit").textContent = depositDisplayValue.toFixed(2);
    document.getElementById("totalAmountDisplayTotal").textContent = finalTotal.toFixed(2);

    console.log("FT: "+finalTotal);

    // --- Update hidden inputs ---
    document.getElementById('subtotal').value = totalSum.toFixed(2);
    document.getElementById('deposit_hidden').value = (-depositDisplayValue).toFixed(2); // Positive deposit
    document.getElementById('totalamount').value = finalTotal.toFixed(2);
}

function submitFormInvoices() {
    const materialsField = document.getElementById("materials");
    const materialsData = materialsField.value ? JSON.parse(materialsField.value) : [];

    if (materialsData.length === 0) {
        alert("Please add at least one material.");
        return false;
    }

    // Allow form submission
    document.getElementById("invoiceForm").submit();
}

// Function to update row numbers
function updateRowNumbers() {
    // Get all rows in the table body
    const rows = document.querySelectorAll("#maintable tbody tr");

    // Iterate over each row
    rows.forEach((row, index) => {
        // Set the row number based on the current position
        row.cells[0].textContent = index + 1;
    });
}