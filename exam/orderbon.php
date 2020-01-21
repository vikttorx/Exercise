<?php
require 'db.php';
$id = $_GET['id'];
$sql = 'SELECT * FROM reservation JOIN orders ON reservation.id = orders.id';


$statement = $con->prepare($sql);
$statement->execute([':id' => $id ]);
$reservation = $statement->fetch(PDO::FETCH_OBJ);


?>
<?php require 'header.php'; ?>
<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            <h2>Order bon</h2>
        </div>
        <div class="card-body">
            <?php if(!empty($message)): ?>
                <div class="alert alert-success">
                    <?= $message; ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="name">Reservation name:</label>
                    <br><?= $reservation->name; ?>
                </div>
                <div class="form-group">
                    <label for="name">Reservation date:</label>
                    <br><?= $reservation->date; ?>
                </div>
                <div class="form-group">
                    <label for="name">Item name:</label>
                    <br><?= $reservation->item_name; ?>
                </div>
                <div class="form-group">
                    <label for="name">Item quantitiy:</label>
                    <br><?= $reservation->item_quantity; ?>
                </div>
                <div class="form-group">
                    <label for="name">Item price:</label>
                    <br><?= $reservation->product_price; ?>
                </div>
                <div class="form-group">
                    <label for="name">tables</label>
                    <br><?= $reservation->tables_id; ?>
                </div>



            </form>
        </div>
    </div>
</div>
<a class="nav-link" href="readreservation.php">Back</a>