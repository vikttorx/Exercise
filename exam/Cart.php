<?php
session_start();
$dsn = 'mysql:host=localhost;dbname=exam';
$username = 'root';
$password = '';
$options = [];
try {
    $con = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e) {
}

if (isset($_POST["add"])){
    if (isset($_SESSION["cart"])){
        $item_array_id = array_column($_SESSION["cart"],"product_id");
        if (!in_array($_GET["id"],$item_array_id)){
            $count = count($_SESSION["cart"]);
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>window.location="Cart.php"</script>';
        }else{
            echo '<script>alert("Product is already Added to Cart")</script>';
            echo '<script>window.location="Cart.php"</script>';
        }
    }else{
        $item_array = array(
            'product_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'product_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"],
        );
        $_SESSION["cart"][0] = $item_array;
    }
}
if (isset($_GET["action"])){
    if ($_GET["action"] == "delete"){
        foreach ($_SESSION["cart"] as $keys => $value){
            if ($value["product_id"] == $_GET["id"]){
                unset($_SESSION["cart"][$keys]);
                echo '<script>alert("Product has been Removed...!")</script>';
                echo '<script>window.location="Cart.php"</script>';
            }
        }
    }
}
//var_dump($_POST);
$response = false;
if($_POST && isset($_POST)):
foreach ($_SESSION['cart'] as $orderitem):


        $item_name   = $orderitem['item_name'];
        $item_quantity   = $orderitem['item_quantity'];
        $product_price   = $_POST['product_price'];
        $tables_id   = $_POST['tables_id'];
        $reservation_id  = $_POST['reservation_id'];
        $sql = 'INSERT INTO orders(item_name , item_quantity , product_price, tables_id, reservation_id) VALUES(:item_name, :item_quantity, :product_price, :tables_id , :reservation_id)';
        $statement = $con->prepare($sql);
        $response = $statement->execute([':item_name' => $item_name, ':item_quantity' => $item_quantity, ':product_price' => $product_price, ':tables_id' => $tables_id, ':reservation_id' => $reservation_id  ]);

endforeach;
endif;
$message = '';
if ($response) {
    $message = 'data inserted successfully';
}
echo $message;
//if (isset ($_POST['item_name'])  && isset($_POST['item_quantity']) && isset($_POST['product_price']) && isset($_POST['reservation_id'])  ) {
//    $item_name = $_POST['item_name'];
//    $item_quantity   = $_POST['item_quantity'];
//    $product_price   = $_POST['product_price'];
//    $reservation_id   = $_POST['reservation_id'];
//    $sql = 'INSERT INTO orders(item_name, item_quantity, product_price, reservation_id) VALUES(:item_name,:item_quantity,:product_price, :reservation_id)';
//    $statement = $con->prepare($sql);
//    if ($statement->execute([':item_name' => $item_name, ':item_quantity' => $item_quantity , ':product_price' => $product_price , ':reservation_id' => $reservation_id ])) {
//        $message = 'data inserted successfully';
//    }
//}
//session_destroy();

$tables = $con->prepare("SELECT * FROM tables");
$tables->execute();
$tables = $tables->fetchAll(PDO::FETCH_ASSOC);

$reservation = $con->prepare("SELECT * FROM reservation");
$reservation->execute();
$reservation = $reservation->fetchAll(PDO::FETCH_ASSOC);

error_reporting(0);
ini_set('display_errors', 0);

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Titillium+Web');
        *{
            font-family: 'Titillium Web', sans-serif;
        }

        .product{
            border: 1px solid #eaeaec;
            margin: -1px 19px 3px -1px;
            padding: 10px;
            text-align: center;
            background-color: #efefef;
        }
        table, th, tr{
            text-align: center;
        }
        .title2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        h2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        table th{
            background-color: #efefef;
        }
    </style>
</head>
<body>

<div class="container" style="width: 65%">
    <h2>Shopping Cart</h2>
    <?php
    $query = "SELECT * FROM product ORDER BY id ASC ";
//    $result = mysqli_query($con,$query);
    $getUsers = $con->prepare($query);
    $getUsers->execute();
    $users = $getUsers->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $row ) {
            ?>
            <div class="col-md-3">

                <form method="post" action="Cart.php?action=add&id=<?php echo $row["id"]; ?>">

                    <div class="product">
                        <!--                                <img src="--><?php //echo $row["image"]; ?><!--" class="img-responsive">-->
                        <h5 class="text-info"><?php echo $row["pname"]; ?></h5>
                        <h5 class="text-danger">&euro;<?php echo $row["price"]; ?></h5>
                        <input type="text" name="quantity" class="form-control" value="1">
                        <input type="hidden" name="hidden_name" value="<?php echo $row["pname"]; ?>">
                        <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                        <input type="submit" name="add" style="margin-top: 5px;" class="btn btn-success"
                               value="Add to Cart">
                    </div>
                </form>
            </div>
            <?php

    }
    ?>

    <div style="clear: both"></div>
    <h3 class="title2">Shopping Cart Details</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <form method="post">
            <tr>
                <th width="30%">Product Name</th>
                <th width="10%">Quantity</th>
                <th width="13%">Price Details</th>
                <th width="10%">Total Price</th>
                <th width="17%">Remove Item</th>
            </tr>

            <?php
            if(!empty($_SESSION["cart"])){
                $total = 0;
                foreach ($_SESSION["cart"] as $key => $value) {
                    ?>








                    <tr>
                        <td><input name="item_name[]" value="<?php echo $value["item_name"]; ?>" type="hidden"> <?php echo $value["item_name"]; ?></td>
                        <td><input name="item_quantity[]" value="<?php echo $value["item_quantity"]; ?>" type="hidden"> <?php echo $value["item_quantity"]; ?></td>
                        <td><input name="product_price" value="<?php echo $value["product_price"]; ?>" type="hidden"> <?php echo $value["product_price"]; ?></td>
                        <td>
                            &euro; <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?></td>
                        <td><a href="Cart.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span
                                        class="text-danger">Remove Item</span></a></td>

                    </tr>
                    <?php
                    $total = $total + ($value["item_quantity"] * $value["product_price"]);
                }
                ?>

                <tr>
                    <td colspan="3" align="right">Total</td>
                    <th align="right">&euro; <?php echo number_format($total, 2); ?></th>
                    <td></td>
                </tr>
                <div class="form-group">
                    <label for="name">Tables</label>
                    <select name="tables_id">
                        <?php

                        foreach($tables as $tbls)
                        {
                            echo "<option value=\"{$tbls['id']}\">{$tbls['id']} ({$tbls['description']})</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Reservations</label>
                    <select name="reservation_id">
                        <?php

                        foreach($reservation as $res)
                        {
                            echo "<option value=\"{$res['id']}\">{$res['id']} ({$res['name']})</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info">Create a order</button>
                </div>

            </form>
                <?php
            }
            ?>
        </table>

    </div>
<a class="nav-link" href="index.php">Back</a>
</div>


</body>
</html>