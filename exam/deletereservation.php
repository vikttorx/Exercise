<?php
require 'db.php';
$id = $_GET['id'];
$sql = 'DELETE FROM reservation WHERE id=:id';
$statement = $con->prepare($sql);
if ($statement->execute([':id' => $id])) {
    header("Location: readreservation.php");
}