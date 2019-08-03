<?php
function printMyCode() {
    $lines = file($_SERVER['SCRIPT_FILENAME']);
    echo "<pre class='mycode'>\n";
    foreach ($lines as $lineNo => $lineOfCode)
        printf("%3u: %1s \n", $lineNo, rtrim(htmlentities($lineOfCode)));
    echo "</pre>";
}

function preShow( $arr, $returnAsString=false ) {
    $ret  = '<pre>' . print_r($arr, true) . '</pre>';
    if ($returnAsString)
        return $ret;
    else 
        echo $ret; 
}

function debug_module() {
    printMyCode();
}

function top_module($pageTitle, $css='style')
{
    $style = <<<"STYLE"
.active {
    background-color: #cccccc;
}
STYLE;
    $module_content = <<<"TOP"
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <title>$pageTitle</title>

    <!-- Keep wireframe.css for debugging, add your css to style.css -->
    <link id='wireframecss' type="text/css" rel="stylesheet" href="../wireframe.css" disabled>
    <link href="https://fonts.googleapis.com/css?family=Lobster|Roboto:300" rel="stylesheet">
    <link id='stylecss' type="text/css" rel="stylesheet" href="css/$css.css">
    <script src='../wireframe.js'></script>
    <style>
        $style
    </style>
</head>

<body>
    <header>
        <a id='logo' class='h3' href='index.php'></a>
        <nav>
            <ul id="main-menu">
                <li class="menu-item">
                    <a href="login.php">
                        Log In
                    </a>
                </li>
                <li class="menu-item">
                    <a href="products.php">
                        Menu
                    </a>
                </li>
                <li class="menu-item">
                    <a href="cart.php">
                        Cart
                    </a>
                </li>
                <li class="menu-item active">
                    <a href="index.php">
                        Home
                    </a>
                </li>
            </ul>
        </nav>
    </header>

TOP;
    echo $module_content;
}

function bottom_module() {
    $showCode = 'printMyCode';
    $module_content = "
    <footer>
        <div class='footer-style'>
            <div>
                &copy;
                <script>
                    document.write(new Date().getFullYear());

                </script>
                Milindi Kodikara - s3667779 &amp; River Smith - s3445349
            </div>
            <div>
                Disclaimer: This website is not a real website and is being developed as part of a School of Science Web Programming course at RMIT University in Melbourne, Australia.
            </div>
            <div>
                <div>
                    Maintain links to your <a href='products.txt'>products spreadsheet</a> and <a href='orders.txt'>orders spreadsheet</a> here. <button id='toggleWireframeCSS' onclick='toggleWireframe()'>Toggle Wireframe CSS</button>
                </div>

                <button id='toggleWireframeCSS ' onclick='toggleWireframe() '>
                    Toggle Wireframe CSS
                </button>
            </div>
        </div>
    </footer>
    </body>
    </html>";
    echo $module_content;
}

function display_products() {
    $products = read_table("products.txt");
    $filtered_products = array_filter($products, "unique_id_filter");
    echo "<div class='prod-flex'>";
    foreach ($filtered_products as $product) {
        $name = $product["Title"];
        $picture = $product["Picture"];
        $id = $product["ID"];
        echo <<<"PRODUCT"
<button onclick="window.location.href='product.php?id=$id'">
    <img src='./media/$picture.png' alt='Image of two mint latte' class='prod-prod-image'>
    <p>$name</p>
</button>
PRODUCT;
    }
    echo "</div>";
}

function unique_id_filter($array) {
    if ($array["OID"] == "sml")
        return TRUE;
    else
        return FALSE;
}

function product_filter($id) {
    if ($array["ID"] == $id)
        return TRUE;
    else
        return FALSE;
}

function read_table($filename) {
    // Code adapted from lecture 10, slide 37
    $fp = fopen($filename, "r");
    flock($fp, LOCK_SH);
    $headings = fgetcsv($fp, 0, "\t");
    while ($row = fgetcsv($fp, 0, "\t")) {
        $row_to_add = array();
        $col_num = 0;
        foreach ($headings as $col) {
            $row_to_add[$col] = $row[$col_num];
            $col_num++;
        }
        $table_array[] = $row_to_add;
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    return $table_array;
}

function write_orders($filename) {
    $fp = fopen($filename,"a");
    flock($fp, LOCK_EX);
    foreach($_SESSION['cart'] as $order) {
        $order_array =
            [
                date('D-M-Y'),
                $_SESSION['user']['name'],
                $_SESSION['user']['email'],
                $_SESSION['user']['phone'],
                $_SESSION['user']['address'],
                $order['id'],
                $order['oid'],
                $order['qty'],
                $order['price'],
                $order['subtotal']
            ];
        fputcsv($fp, $order_array, "\t");
    }
    flock($fp, LOCK_UN);
    fclose($fp);
}

function find_product($id, $oid) {
    $products = read_table("products.txt");
    foreach($products as $product) {
        if ($id == $product['ID'] &&
           $oid == $product['OID']) {
            return $product;
        }
    }
    return FALSE;
}

function display_details($count, $cart=FALSE){
    echo "<tr>";
    foreach($_SESSION['cart'][$count] as $inner_key => $inner_value){
        switch ($inner_key) {
            case 'id':
                $display_id = $inner_value;
                $product = find_product($display_id,'sml');
                $display_image = $product['Picture'];
                $image = $cart ? "<td><img id='display_details' src='./media/$display_image.png'></td>" : "";
                $display_name = $product['Title'];
                $name = "<td>$display_name</td>";
                break;
            case 'oid':
                $oid = $inner_value;
                $product = find_product('1',$oid);
                $display_option = $product['Option'];
                $option = "<td>$display_option</td>";
                break;
            case 'qty':
                $display_qty = $inner_value;
                $quantity =  "<td>$display_qty</td>";
                break;
            case 'price':
                $price = "<td>$inner_value</td>";
                break;
            case 'subtotal':
                $subtotal = "<td>$inner_value</td>";
                break;
        }
    }
    echo "$image$name$option$quantity$price$subtotal</tr>";
}

// the prices are different for each id
// you need to make an array that only includes one product, but all of it's options, as prices, in order
function php2js( $arr, $arrName ) {
  $lineEnd="";
  echo "<script>\n";
  echo "  var $arrName = ".json_encode($arr, JSON_PRETTY_PRINT);
  echo "</script>\n\n";
}

function getPrice($id, $oid) {
    $product = find_product($id, $oid);
    $price = $product['Price'];
    return $price;

}

function calculateTotalPrice($count){
    $qty = intval($_SESSION['cart'][$count]['qty']);
    $id = $_SESSION['cart'][$count]['id'];
    $oid = $_SESSION['cart'][$count]['oid'];
    $price = getPrice($id, $oid);
    $totalPrice =$price * $qty;
    return $totalPrice;
}

?>
