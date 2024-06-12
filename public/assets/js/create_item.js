const updateAmount = (quantity, unitValue) => {
    unitValue = unitValue.replace(/,/g, "");

    let amountInput = document.getElementsByName('amount')[0];
    amountInput.value = parseFloat(quantity) * parseFloat(unitValue);
}

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM loaded');

    let quantityInput = document.getElementsByName('quantity')[0];
    let unitValueInput = document.getElementsByName('unit_value')[0];

    quantityInput.addEventListener('keyup', function () {
        updateAmount(quantityInput.value ?? 0, unitValueInput.value ?? 0);
    });

    unitValueInput.addEventListener('keyup', function () {
        updateAmount(quantityInput.value ?? 0, unitValueInput.value ?? 0);
    });
});