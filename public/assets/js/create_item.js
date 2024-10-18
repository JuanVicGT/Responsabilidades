
const updateAmount = (quantity, unitValue) => {
    unitValue = unitValue.replace(/,/g, "");

    let amountInput = document.getElementsByName('amount')[0];
    let amount = isNaN(parseFloat(quantity) * parseFloat(unitValue)) ? 0 : parseFloat(quantity) * parseFloat(unitValue);
    amountInput.value = parseFloat(amount).toFixed(2);
}

const updateUnitValue = (quantity, amount) => {
    amount = amount.replace(/,/g, "");

    let unitValueInput = document.getElementsByName('unit_value')[0];
    let unitValue = isNaN(parseFloat(amount) / parseFloat(quantity)) ? 0 : parseFloat(amount) / parseFloat(quantity);
    unitValueInput.value = parseFloat(unitValue).toFixed(2);
}

document.addEventListener('alpine:init', () => {
    let quantityInput = document.getElementsByName('quantity')[0];
    let unitValueInput = document.getElementsByName('unit_value')[0];
    let amountValueInput = document.getElementsByName('amount')[0];

    quantityInput.addEventListener('keyup', function () {
        updateAmount(quantityInput.value ?? 0, unitValueInput.value ?? 0);
    });

    unitValueInput.addEventListener('keyup', function () {
        updateAmount(quantityInput.value ?? 0, unitValueInput.value ?? 0);
    });

    amountValueInput.addEventListener('keyup', function () {
        updateUnitValue(quantityInput.value ?? 1, amountValueInput.value ?? 0);
    });
});