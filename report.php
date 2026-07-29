<?php 
include('../config/db.php');

$student_id = $_GET['student'] ?? 1;

// Students
$students = $conn->query("SELECT * FROM students");

// SUMMARY
$summary = $conn->query("
SELECT 
COUNT(*) total,
SUM(status='present') present,
SUM(status='absent') absent
FROM attendance 	
WHERE student_id=$student_id
")->fetch_assoc();

$total = $summary['total'] ?? 0;
$present = $summary['present'] ?? 0;
$percent = $total ? round(($present/$total)*100,2) : 0;

// SUBJECT WISE
$subjects = $conn->query("
SELECT subject,
COUNT(*) total,
SUM(status='present') present,
SUM(status='absent') absent
FROM attendance
WHERE student_id=$student_id
GROUP BY subject
");

// DATE WISE
$records = $conn->query("
SELECT date, subject, status
FROM attendance
WHERE student_id=$student_id
ORDER BY date DESC
");
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="ml-64 p-6 bg-gray-100 min-h-screen">

<div class="flex justify-between items-center mb-4">

<h2 class="text-xl">Attendance Status</h2>

<a href="../dashboard/dashboard.php"
class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700">
Back
</a>

</div>
    
<!-- STUDENT -->
<form method="GET" class="mb-4">
<select name="student" onchange="this.form.submit()" class="border p-2 rounded">
<?php while($s=$students->fetch_assoc()): ?>
<option value="<?= $s['id'] ?>" <?= $student_id==$s['id']?'selected':'' ?>>
<?= $s['name'] ?>
</option>
<?php endwhile; ?>
</select>
</form>

<!-- SUMMARY -->
<div class="bg-white p-4 mb-4 rounded shadow">
<p>Total: <?= $total ?></p>
<p>Present: <?= $present ?></p>
<p>%: <?= $percent ?></p>
</div>

<!-- SUBJECT -->
<div class="bg-white p-4 mb-4 rounded shadow">
<h3 class="mb-2 font-semibold">Subject Wise</h3>

<table class="w-full">
<tr class="bg-gray-100">
<th>Subject</th><th>Total</th><th>Present</th><th>Absent</th>
</tr>

<?php while($sub=$subjects->fetch_assoc()): ?>
<tr class="border-t">
<td><?= $sub['subject'] ?></td>
<td><?= $sub['total'] ?></td>
<td class="text-green-600"><?= $sub['present'] ?></td>
<td class="text-red-600"><?= $sub['absent'] ?></td>
</tr>
<?php endwhile; ?>

</table>
</div>

<!-- DATE -->
<div class="bg-white p-4 rounded shadow">
<h3 class="mb-2 font-semibold">Date Wise</h3>

<table class="w-full">
<tr class="bg-gray-100">
<th>Date</th><th>Subject</th><th>Status</th>
</tr>

<?php while($r=$records->fetch_assoc()): ?>
<tr class="border-t">
<td><?= $r['date'] ?></td>
<td><?= $r['subject'] ?></td>
<td><?= $r['status'] ?></td>
</tr>
<?php endwhile; ?>

</table>

</div>

</div>