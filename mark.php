<?php 
include('../config/db.php');

// Save
if($_POST){
  $subject = $_POST['subject'];
  $date = date('Y-m-d');

  foreach($_POST['st'] as $id=>$st){
    $q=$conn->prepare("INSERT INTO attendance(student_id,subject,date,status) VALUES(?,?,?,?)");
    $q->bind_param("isss",$id,$subject,$date,$st);
    $q->execute();
  }

  echo "<script>alert('Saved');</script>";
}

// Students
$s = $conn->query("SELECT * FROM students");
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="ml-64 p-6 bg-gray-100 min-h-screen">

<h2 class="text-xl mb-4">Mark Attendance</h2>

<form method="POST">

<!-- SUBJECT -->
<input name="subject" placeholder="Enter Subject"
class="border p-2 rounded mb-4 w-64" required>

<div class="bg-white rounded shadow">

<table class="w-full">

<?php while($x=$s->fetch_assoc()): ?>
<tr class="border-t">
<td class="p-3"><?= $x['name'] ?></td>

<td class="p-3">
<select name="st[<?= $x['id'] ?>]" class="border p-1 rounded">
<option value="present">Present</option>
<option value="absent">Absent</option>
</select>
</td>
</tr>
<?php endwhile; ?>

</table>
</div>

<button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded">
Save
</button>

</form>

</div>