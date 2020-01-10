
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
                    <th>Table </th>
                    <th>Action</th>
                </tr>
                <?php foreach($reservations as $res): ?>
                    <tr>
                        <td><?= $res->id; ?></td>
                        <td><?= $res->date; ?></td>
                        <td><?= $res->time; ?></td>
                        <td><?= $res->name; ?></td>
                        <td><?= $res->phone; ?></td>
                        <td><?= $res->tables_id; ?></td>
                        <td>

                            <a onclick="return confirm('Are you sure you want to delete this entry?')" href="pizzadelete.php?id=<?= $reservering->id ?>" class='btn btn-danger'>Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <a class="nav-link" href="createreservation.php">Create a reservation</a>

<?php require 'footer.php'; ?>