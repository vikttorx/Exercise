
<?php



include 'db.php';

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...



$sql = 'SELECT * FROM orders JOIN reservation ON orders.reservation_id = reservation.id';
$statement = $con->prepare($sql);
$statement->execute();
$order = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<?php require 'header.php'; ?>
<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            <h2>All Orders</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Item name</th>
                    <th>Item quantity</th>
                    <th>Product price</th>
                    <th>Table</th>
                    <th>Reservation</th>



                </tr>
                <?php foreach($order as $ordr): ?>
                    <tr>
                        <td><?= $ordr->id; ?></td>
                        <td><?= $ordr->item_name; ?></td>
                        <td><?= $ordr->item_quantity; ?></td>
                        <td><?= $ordr->product_price; ?></td>
                        <td><?= $ordr->tables_id; ?></td>
                        <td><?= $ordr->name; ?></td>



                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>


    <a class="nav-link" href="index.php">Back</a>