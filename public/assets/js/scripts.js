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

$(document).ready(function() {
    $('#customerSelect').select2({
        placeholder: "Select a customer",
        allowClear: true
    });
});

//QUOTATION
function addRowQuotation() {
    // Get the material select element and quantity input element
    const customerSelect = document.getElementById("customerSelect");
    const materialSelect = document.getElementById("materialSelect");
    const quantityInput = document.getElementById("quantity");

    // Get the selected material and its price
    const materialId = materialSelect.value;
    const customer = customerSelect.options[customerSelect.selectedIndex].text;
    const material = materialSelect.options[materialSelect.selectedIndex].text;
    const price = parseFloat(materialSelect.options[materialSelect.selectedIndex].getAttribute("data-price"));

    // Get the quantity and calculate the amount
    const quantity = parseInt(quantityInput.value);
    const amount = (price * quantity).toFixed(2);

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
        <td>${material}</td>
        <td>${price.toFixed(2)}</td>
        <td>${quantity}</td>
        <td>${amount}</td>
        <td>
            <button type="button" class="btn btn-primary btn-sm" onclick="editRowQuotation(this)">edit</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRowQuotation(this)">X</button>
        </td>
    `;

    // Update row numbers after adding a new row
    updateRowNumbers();

    // Calculate the total amount
    calculateAmountSumQuotation();
    addQuotationData(materialId, quantity, price, amount);
    
    materialSelect.selectedIndex = 0; 
    quantityInput.value = 1;
}

function addQuotationData(materialId, quantity, price, amount) {
    const materialsInput = document.getElementById('materials');
    let materials = JSON.parse(materialsInput.value || '[]');

    // Add the new material data to the array
    materials.push({
        material_id: materialId,
        quantity: quantity,
        price: price,
        amount: amount
    });

    // Update the hidden input with the new materials data as a JSON string
    materialsInput.value = JSON.stringify(materials);
}

// Function to edit a row
function editRowQuotation(button) {
    // Get the row that contains the button
    const row = button.parentNode.parentNode;

    // Get the quantity cell
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

        // Update the quantity and amount cells
        quantityCell.textContent = newQuantity;
        amountCell.textContent = newAmount.toFixed(2);

        // Recalculate the total amount
        calculateAmountSumQuotation();
    });
}

// Function to remove a row
function removeRowQuotation(button) {
    // Get the row that contains the button
    const row = button.parentElement.parentElement;

    // Get the amount cell from the row to deduct from the total
    const amountCell = row.cells[4]; 
    const amount = parseFloat(amountCell.textContent); 

    // Remove the row from the table
    row.parentElement.removeChild(row);

    // Deduct the amount from the total sum
    if (!isNaN(amount)) {
        const totalAmountDisplay = document.getElementById("totalAmountDisplay");
        let currentTotal = parseFloat(totalAmountDisplay.textContent.replace("Total Amount: RM", ""));
        currentTotal -= amount; 
        totalAmountDisplay.textContent = "Total Amount: RM" + currentTotal.toFixed(2); 
    }

    // Update row numbers after removing a row
    updateRowNumbers();
}

function calculateAmountSumQuotation() {
    // Get all rows in the table body
    const rows = document.querySelectorAll("#maintable tbody tr");

    // Initialize the total sum
    let totalSum = 0;

    // Iterate over each row
    rows.forEach(row => {
        // Get the amount cell
        const amountCell = row.cells[4]; 

        // Get the amount
        const amount = parseFloat(amountCell.textContent);

        // Check if amount is valid
        if (!isNaN(amount)) {
            // Add the amount to the total sum
            totalSum += amount;
        }
    });

    // Update the total amount display
    document.getElementById("totalAmountDisplay").textContent = "Total Amount: RM" + totalSum.toFixed(2);
}


//INVOICES
function addRowInvoice() {
    // Get the material select element and quantity input element
    const customerSelect = document.getElementById("customerSelect");
    const materialSelect = document.getElementById("materialSelect");
    const quantityInput = document.getElementById("quantity");

    // Get the selected material and its price
    const customer = customerSelect.options[customerSelect.selectedIndex].text;
    const material = materialSelect.options[materialSelect.selectedIndex].text;
    const price = parseFloat(materialSelect.options[materialSelect.selectedIndex].getAttribute("data-price"));

    // Get the quantity and calculate the amount
    const quantity = parseInt(quantityInput.value);
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
        <td>${material}</td>
        <td>${price.toFixed(2)}</td>
        <td>${quantity}</td>
        <td>${amount}</td>
        <td>
            <button type="button" class="btn btn-primary btn-sm" onclick="editRowInvoice(this)">edit</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRowInvoice(this)">X</button>
        </td>
    `;

    // Update row numbers after adding a new row
    updateRowNumbers();

    // Calculate the total amount
    calculateAmountSumInvoice();    

    materialSelect.selectedIndex = 0; 
    quantityInput.value = 1;
}

// Function to edit a row
function editRowInvoice(button) {
    // Get the row that contains the button
    const row = button.parentNode.parentNode;

    // Get the quantity cell
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

        // Update the quantity and amount cells
        quantityCell.textContent = newQuantity;
        amountCell.textContent = newAmount.toFixed(2);

        // Recalculate the total amount
        calculateAmountSumInvoice();
    });
}

function removeRowInvoice(button) {
    // Get the row that contains the button
    const row = button.parentElement.parentElement;

    // Get the amount cell from the row to deduct from the total
    const amountCell = row.cells[4]; 
    const amount = parseFloat(amountCell.textContent); 

    // Remove the row from the table
    row.parentElement.removeChild(row);

    // Deduct the amount from the total sum
    if (!isNaN(amount)) {
        // Update the subtotal and total amount displays
        const subtotalDisplay = document.getElementById("totalAmountDisplayAmount");
        const depositDisplay = document.getElementById("totalAmountDisplayDeposit");
        const totalDisplay = document.getElementById("totalAmountDisplayTotal");

        let currentSubtotal = parseFloat(subtotalDisplay.textContent);
        let currentDeposit = parseFloat(depositDisplay.textContent);
        let currentTotal = parseFloat(totalDisplay.textContent);

        // Update the subtotal
        currentSubtotal -= amount; 
        subtotalDisplay.textContent = currentSubtotal.toFixed(2);

        // Update the total amount (considering deposit)
        currentTotal = currentSubtotal - currentDeposit; 
        totalDisplay.textContent = currentTotal.toFixed(2);
    }

    // Update row numbers after removing a row
    updateRowNumbers();
}

// Function to calculate the total amount
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

    console.log(totalSum);
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

function submitFormQuotation() {
    const materialsField = document.getElementById("materials");
    const materialsData = materialsField.value ? JSON.parse(materialsField.value) : [];

    if (materialsData.length === 0) {
        alert("Please add at least one material.");
        return false; // Prevent form submission
    }

    // Allow form submission
    document.getElementById("quotationForm").submit();
}