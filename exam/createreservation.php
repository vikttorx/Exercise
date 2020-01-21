<?php
require 'db.php';
$message = '';
if (isset ($_POST['name'])  && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['phone']) ) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $phone = $_POST['phone'];
    $sql = 'INSERT INTO reservation(name, date, time, phone) VALUES(:name, :date, :time, :phone)';
    $statement = $con->prepare($sql);
    if ($statement->execute([':name' => $name, ':date' => $date, ':time' => $time,  ':phone' => $phone])) {
        $message = 'data inserted successfully';
    }
}
?>
<?php require 'header.php'; ?>
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h2>Create a reservation</h2>
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
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date"  name="date" id="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time"  name="time" id="time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text"  name="phone" id="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">Update reservation</button>
                    </div>
                    <a href="/exam/readreservation.php">Back</a>
                </form>
            </div>

