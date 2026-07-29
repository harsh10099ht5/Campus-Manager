<?php 
include('../config/db.php');

$id = $_GET['student'] ?? 1;

// student
$st = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();

// subjects
$subs = $conn->query("SELECT * FROM subjects");

$total=0; $count=0;
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="p-6">

<div class="max-w-xl mx-auto bg-white p-6 shadow">

<h2 class="text-xl font-bold mb-4">Report Card</h2>

<p><b>Name:</b> <?= $st['name'] ?></p>
<p><b>Class:</b> <?= $st['class'] ?></p>

<hr class="my-4">

<table class="w-full">

<tr class="bg-gray-100">
<th class="p-2 text-left">Subject</th>
<th class="p-2">Marks</th>
</tr>

<?php while($sub=$subs->fetch_assoc()): 

$m = $conn->query("SELECT marks FROM marks WHERE student_id=$id AND subject=".$sub['id']);
$val = $m->fetch_assoc()['marks'] ?? 0;

$total += $val;
if($val>0) $count++;
?>

<tr class="border-t">
<td class="p-2"><?= $sub['name'] ?></td>
<td class="p-2"><?= $val ?></td>
</tr>

<?php endwhile; ?>

</table>

<hr class="my-4">

<?php $avg = $count ? round($total/$count,2) : 0; ?>

<p><b>Total:</b> <?= $total ?></p>
<p><b>Average:</b> <?= $avg ?></p>

<button onclick="window.print()"
class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
Download PDF
</button>

</div>

</body>