<?php include('../config/db.php');
$id=$_GET['id'];

if($_POST){
 $q=$conn->prepare("UPDATE students SET name=?,email=?,class=? WHERE id=?");
 $q->bind_param("sssi",$_POST['name'],$_POST['email'],$_POST['class'],$id);
 $q->execute();
 header("Location: list.php");
}

$s=$conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
?>

<form method="POST">
<input name="name" value="<?= $s['name'] ?>">
<input name="email" value="<?= $s['email'] ?>">
<input name="class" value="<?= $s['class'] ?>">
<button>Update</button>
</form>