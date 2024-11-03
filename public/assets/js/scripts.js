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
    const materialSelect = document.getElementById('materialSelect');
    const quantityInput = document.getElementById('quantity');
    const addMaterialButton = document.getElementById('addMaterialButton');
    const selectedMaterialsTableBody = document.getElementById('selectedMaterials');
    const totalPriceField = document.getElementById('total_price');

    let selectedMaterials = []; // Array to store selected materials for calculation

    // Function to add selected material to the table
    addMaterialButton.addEventListener('click', () => {
        const selectedOption = materialSelect.options[materialSelect.selectedIndex];
        const materialId = selectedOption.value;
        const materialName = selectedOption.text;
        const unitPrice = parseFloat(selectedOption.dataset.unitPrice);
        const quantity = parseFloat(quantityInput.value);

        if (!materialId || isNaN(quantity) || quantity <= 0) {
            alert('Please select a material and enter a valid quantity.');
            return;
        }

        // Check if material is already selected
        const existingMaterial = selectedMaterials.find(material => material.id === materialId);
        if (existingMaterial) {
            alert('This material is already added. Please update its quantity if needed.');
            return;
        }

        // Add material to the selected materials list
        selectedMaterials.push({ id: materialId, name: materialName, unitPrice, quantity });

        // Update the display and calculate total price
        updateSelectedMaterialsDisplay();
        calculateTotalPrice();

        // Clear the inputs
        materialSelect.selectedIndex = 0;
        quantityInput.value = '';
    });

    // Function to update the selected materials table display
    function updateSelectedMaterialsDisplay() {
        selectedMaterialsTableBody.innerHTML = ''; // Clear current display
    
        selectedMaterials.forEach((material, index) => {
            const amount = (material.unitPrice * material.quantity).toFixed(2);
            const materialRow = document.createElement('tr');
            materialRow.innerHTML = `
                <td>${index + 1}</td>
                <td>${material.name}</td>
                <td>RM ${material.unitPrice.toFixed(2)}</td>
                <td>${material.quantity}</td>
                <td>RM ${amount}</td>
                <td>
                    <button class="btn btn-primary btn-sm edit-material" data-index="${index}"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete-material" data-index="${index}"><i class="fas fa-trash-alt"></i></button>
                </td>
            `;
            selectedMaterialsTableBody.appendChild(materialRow);
        });
    
        // Add event listeners for edit and delete buttons
        addActionEventListeners();
    }
    
    // Function to add event listeners for edit and delete buttons
    function addActionEventListeners() {
        const editButtons = document.querySelectorAll('.edit-material');
        const deleteButtons = document.querySelectorAll('.delete-material');
    
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const index = this.dataset.index;
                const material = selectedMaterials[index];
                // Populate the quantity input with the existing quantity for editing
                document.getElementById('materialSelect').value = material.id;
                document.getElementById('quantity').value = material.quantity;
                // Remove the material from the selected list
                selectedMaterials.splice(index, 1);
                updateSelectedMaterialsDisplay(); // Refresh the table
            });
        });
    
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const index = this.dataset.index;
                // Remove the selected material from the list
                selectedMaterials.splice(index, 1);
                updateSelectedMaterialsDisplay(); // Refresh the table
            });
        });
    }
    

    // Function to calculate and display the total price
    function calculateTotalPrice() {
        let totalPrice = selectedMaterials.reduce((sum, material) => {
            return sum + (material.unitPrice * material.quantity);
        }, 0);

        totalPriceField.value = `RM ${totalPrice.toFixed(2)}`;
    }
});