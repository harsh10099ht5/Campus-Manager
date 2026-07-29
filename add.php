<?php 
include('../includes/sidebar.php'); 
include('../config/db.php');

// fetch classes
$classes = $conn->query("SELECT * FROM classes");

// fetch subjects
$subjects = $conn->query("SELECT * FROM subjects");

// AUTO ROLL NUMBER
$roll_data = $conn->query("SELECT MAX(id) as max_id FROM students")->fetch_assoc();
$next_roll = ($roll_data['max_id'] ?? 0) + 1;

// INSERT
if(isset($_POST['add'])){

$name = $_POST['name'];
$email = $_POST['email'];
$class_id = $_POST['class'];
$selected_subjects = $_POST['subjects'] ?? [];

// insert student
$conn->query("INSERT INTO students(name,email,class,roll_no) 
VALUES('$name','$email','$class_id','$next_roll')");

$student_id = $conn->insert_id;

// insert subjects mapping
foreach($selected_subjects as $sub){
$conn->query("INSERT INTO student_subjects(student_id,subject_id) 
VALUES($student_id,$sub)");
}

header("Location: list.php");
}
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="ml-64 p-8 bg-gray-100 min-h-screen">

<div class="flex justify-between mb-6">
<h2 class="text-2xl font-bold">Add Student</h2>

<a href="list.php" class="bg-gray-800 text-white px-4 py-2 rounded">
Back
</a>
</div>

<div class="bg-white p-6 rounded-xl shadow max-w-2xl">

<form method="POST" class="space-y-4">

<!-- NAME -->
<input type="text" name="name" placeholder="Student Name"
class="w-full border p-3 rounded" required>

<!-- EMAIL -->
<input type="email" name="email" placeholder="Email"
class="w-full border p-3 rounded" required>

<!-- CLASS DROPDOWN -->
<select name="class" class="w-full border p-3 rounded" required>
<option value="">Select Class</option>
<?php while($c=$classes->fetch_assoc()): ?>
<option value="<?= $c['id'] ?>">
<?= $c['name'] ?>
</option>
<?php endwhile; ?>
</select>

<!-- AUTO ROLL -->
<input type="text" value="Roll No: <?= $next_roll ?>" 
class="w-full border p-3 rounded bg-gray-100" readonly>

<!-- SUBJECT MULTI SELECT -->
<label class="font-semibold">Assign Subjects</label>

<select name="subjects[]" multiple
class="w-full border p-3 rounded h-40">

<?php while($s=$subjects->fetch_assoc()): ?>
<option value="<?= $s['id'] ?>">
<?= $s['name'] ?>
</option>
<?php endwhile; ?>

</select>

<p class="text-sm text-gray-500">Hold CTRL to select multiple</p>

<!-- BUTTON -->
<button type="submit" name="add"
class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700">
Add Student
</button>

</form>

</div>

</div>