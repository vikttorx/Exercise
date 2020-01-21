
<?php



include 'db.php';

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...



$sql = 'SELECT * FROM reservation';
$statement = $con->prepare($sql);
$statement->execute();
$reservations = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<?php require 'header.php'; ?>
<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            <h2>All people</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Name</th>
                    <th>Phone</th>

                    <th>Action</th>
                </tr>
                <?php foreach($reservations as $res): ?>
                    <tr>
                        <td><?= $res->id; ?></td>
                        <td><?= $res->date; ?></td>
                        <td><?= $res->time; ?></td>
                        <td><?= $res->name; ?></td>
                        <td><?= $res->phone; ?></td>

                        <td>
                            <a href="editreservation.php?id=<?= $res->id ?>" class="btn btn-info">Edit</a>
                            <a onclick="return confirm('Are you sure you want to delete this entry?')" href="deletereservation.php?id=<?= $res->id ?>" class='btn btn-danger'>Delete</a>
                            <a href="orderbon.php?id=<?= $res->id ?>" class="btn btn-success">Print bon</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <a class="nav-link" href="createreservation.php">Create a reservation</a>
    <a class="nav-link" href="index.php">Back</a>

<?php require 'footer.php'; ?>