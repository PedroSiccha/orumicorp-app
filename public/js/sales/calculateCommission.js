function calculateCommission(inputAmount, inputPercent, inputExchangeRate, inputCommission) {
    var amount = $(inputAmount).val();
    var percent = $(inputPercent).val();
    var exchangeRate = $(inputExchangeRate).val();
    var amountCommission = "0.00";
    amountCommission = amount*(percent/100)*exchangeRate;
    $(inputCommission).val(amountCommission);
}
