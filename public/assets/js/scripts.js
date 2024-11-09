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

//add material selection in quotation-builder
function addRow() {
    // Get the material select element and quantity input element
    const materialSelect = document.getElementById("materialSelect");
    const quantityInput = document.getElementById("quantity");

    // Get the selected material and its price
    const material = materialSelect.options[materialSelect.selectedIndex].text;
    const price = parseFloat(materialSelect.options[materialSelect.selectedIndex].getAttribute("data-price"));

    // Get the quantity and calculate the amount
    const quantity = parseInt(quantityInput.value);
    const amount = price * quantity;

    // Check if material is selected and quantity is valid
    if (!material || isNaN(price) || isNaN(quantity)) {
        alert("Please select a material and enter a valid quantity.");
        return;
    }

    // Get the table body element
    const tableBody = document.getElementById("maintable").getElementsByTagName("tbody")[0];

    // Create a new row element
    const newRow = tableBody.insertRow();

    // Set the inner HTML of the new row
    newRow.innerHTML = `
        <td></td>  <!-- Placeholder for row number -->
        <td>${material}</td>
        <td>${price.toFixed(2)}</td>
        <td>${quantity}</td>
        <td>${amount.toFixed(2)}</td>
        <td>
            <button type="button" class="btn btn-primary btn-sm" onclick="editRow(this)">edit</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
        </td>
    `;

    // Update row numbers after adding a new row
    updateRowNumbers();

    // Calculate the total amount
    calculateAmountSum();
}

// Function to calculate the total amount
function calculateAmountSum() {
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

    // Update the total amount display
    document.getElementById("totalAmountDisplay").textContent = "Total Amount: RM" + totalSum.toFixed(2);
}

// Function to edit a row
function editRow(button) {
    // Get the row that contains the button
    const row = button.parentNode.parentNode;

    // Get the material, price, quantity, and amount cells
    const materialCell = row.cells[1];
    const priceCell = row.cells[2];
    const quantityCell = row.cells[3];
    const amountCell = row.cells[4];

    // TO DO: implement edit functionality
}

// Function to remove a row
function removeRow(button) {
    // Get the row that contains the button
    const row = button.parentElement.parentElement;

    // Remove the row from the table
    row.parentElement.removeChild(row);

    // Update row numbers after removing a row
    updateRowNumbers();
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

function editRow(button) {
    const row = button.parentNode.parentNode; // Get the row that contains the button
    const materialCell = row.cells[1]; // Get the material cell
    const priceCell = row.cells[2]; // Get the price cell
    const quantityCell = row.cells[3]; // Get the quantity cell
    const amountCell = row.cells[4]; // Get the amount cell
    

}

function removeRow(button) {
    const row = button.parentElement.parentElement;
    row.parentElement.removeChild(row);
    updateRowNumbers(); // Update row numbers after removing a row
}

function updateRowNumbers() {
    const rows = document.querySelectorAll("#maintable tbody tr");
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1; // Set row number based on current position
    });
}


