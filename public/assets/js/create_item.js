const updateAmount = (quantity, unitValue) => {
    unitValue = unitValue.replace(/,/g, "");

    let amountInput = document.getElementsByName('amount')[0];
    let amount = parseFloat(quantity) * parseFloat(unitValue);
    amountInput.value = numberWithCommas(amount);
}

document.addEventListener('alpine:init', () => {
    let quantityInput = document.getElementsByName('quantity')[0];
    let unitValueInput = document.getElementsByName('unit_value')[0];

    quantityInput.addEventListener('keyup', function () {
        updateAmount(quantityInput.value ?? 0, unitValueInput.value ?? 0);
    });

    unitValueInput.addEventListener('keyup', function () {
        updateAmount(quantityInput.value ?? 0, unitValueInput.value ?? 0);
    });
});