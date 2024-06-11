const updateAmount = (quantity, unitValue) => {
    let amountInput = document.getElementById('amount');
    amountInput.value = parseFloat(quantity) * parseFloat(unitValue);
}

document.addEventListener('DOMContentLoaded', function () {
    let quantityInput = document.getElementById('quantity');
    let unitValueInput = document.getElementById('unit_value');

    quantityInput.addEventListener('onchange', function () {
        updateAmount(quantityInput.value ?? 0, unitValueInput.value ?? 0);
    });

    unitValueInput.addEventListener('onchange', function () {
        updateAmount(quantityInput.value ?? 0, unitValueInput.value ?? 0);
    });
});