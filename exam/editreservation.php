<?php
require 'db.php';
$id = $_GET['id'];
$sql = 'SELECT * FROM reservation WHERE id=:id';
$statement = $con->prepare($sql);
$statement->execute([':id' => $id ]);
$reservation = $statement->fetch(PDO::FETCH_OBJ);
if (isset ($_POST['name'])  && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['phone']) ) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $phone = $_POST['phone'];
    $sql = 'UPDATE reservation SET name=:name, date=:date, time=:time, phone=:phone WHERE id=:id';
    $statement = $con->prepare($sql);
    if ($statement->execute([':name' => $name, ':date' => $date, ':time' => $time,  ':phone' => $phone, ':id' => $id])) {
        header("Location: readreservation.php");
    }
}

?>
<?php require 'header.php'; ?>
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h2>Update reservation</h2>
            </div>
            <div class="card-body">
                <?php if(!empty($message)): ?>
                    <div class="alert alert-success">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input value="<?= $reservation->name; ?>" type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" value="<?= $reservation->date; ?>" name="date" id="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" value="<?= $reservation->time; ?>" name="time" id="time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" value="<?= $reservation->phone; ?>" name="phone" id="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">Update reservation</button>
                    </div>
                    <a href="/exam/readreservation.php">Back</a>
                </form>
            </div>
        </div>
    </div>
