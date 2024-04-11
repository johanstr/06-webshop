function changeAmount(product_id)
{
   let amount_value = parseInt(document.querySelector('#amount-' + product_id).value);
   let form = document.querySelector('#new-amount-form-' + product_id);
   let new_amount = document.querySelector('#new-amount-' + product_id);

   new_amount.value = amount_value;
   form.submit();
}

function deleteProduct(product_id)
{
   let form = document.querySelector('#delete-product-' + product_id);

   form.submit();
}