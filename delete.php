<?php include('../config/db.php');
$conn->query("DELETE FROM students WHERE id=".$_GET['id']);
header("Location: list.php");