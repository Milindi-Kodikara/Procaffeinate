function validateForm() {
    var option = document.getElementById("size").selectedIndex;
    var size = document.getElementById("number").value;
    if ((parseInt(option) === 0) || (parseInt(size) <= 0)) {
        return false;
    }
    return true;
}

function increaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    //Code adapted from https://codepen.io/mtbroomell/pen/yNwwdv and used for educational purposes only
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('number').value = value;
}

function decreaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    //Code adapted from https://codepen.io/mtbroomell/pen/yNwwdv and used for educational purposes only
    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    value--;
    document.getElementById('number').value = value;
}

function displayPrice() {

    //var product_oid = '';
    var product_id_num = document.getElementById("current_id").value;
    var product_id = product_id_num.toString();
    //var product_id = <?php echo json_encode($product_price_id); ?> ;
    var qtyOfItem = document.getElementById("number").value;
    var product_oidIndex = document.getElementById("size").selectedIndex;

    if (product_oidIndex == 1) {
        product_oid = "sml";
    } else if (product_oidIndex == 2) {
        product_oid = "med";
    } else if (product_oidIndex == 3) {
        product_oid = "lrg";
    }

    var firstRowProd = products.length;
    var secondRowProd = products[0].length;
    var price = '';

    for (var row = 0; row < firstRowProd; row++) {

        for (var col = 0; col < secondRowProd; col++) {

            for (var colIn in products[col]) {
                // console.log(products[col][colIn]);

                if ((product_id === products[col][colIn]["ID"]) && (product_oid === products[col][colIn]["OID"])) {
                    price = products[col][colIn]["Price"];
                }
            }
        }
    }

    var totalPrice = qtyOfItem * price;
    if (totalPrice <= 0) {
        totalPrice = 0;
    }
    document.getElementById("demo-price").innerHTML = "$" + totalPrice.toFixed(2);

}

function clearPrice() {
    document.getElementById('demo-price').innerHTML = "$" + 0.0.toFixed(2)
}