<?php 
include('../includes/sidebar.php'); 
include('../config/db.php');

// TOTAL STUDENTS
$total_students = $conn->query("SELECT COUNT(*) c FROM students")
->fetch_assoc()['c'] ?? 0;

// TODAY PRESENT
$present_today = $conn->query("
SELECT COUNT(*) c FROM attendance 
WHERE status='present' AND date = CURDATE()
")->fetch_assoc()['c'] ?? 0;

// TOTAL CLASSES (attendance entries)
$total_classes = $conn->query("SELECT COUNT(*) c FROM attendance")
->fetch_assoc()['c'] ?? 0;

// TOTAL PRESENT
$total_present = $conn->query("
SELECT COUNT(*) c FROM attendance WHERE status='present'
")->fetch_assoc()['c'] ?? 0;

// PERCENT
$percent = $total_classes ? round(($total_present/$total_classes)*100,2) : 0;

// RECENT ACTIVITY
$recent = $conn->query("
SELECT s.name, a.status, a.date
FROM attendance a
JOIN students s ON s.id = a.student_id
ORDER BY a.date DESC LIMIT 5
");
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="ml-64 p-6 bg-gray-100 min-h-screen">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
<h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>

<a href="../students/add.php"
class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
+ Add Student
</a>
</div>

<!-- CARDS -->
<div class="grid grid-cols-4 gap-4 mb-6">

<div class="bg-blue-500 text-white p-4 rounded-xl shadow">
<p class="text-sm">Total Students</p>
<p class="text-2xl font-bold"><?= $total_students ?></p>
</div>

<div class="bg-green-500 text-white p-4 rounded-xl shadow">
<p class="text-sm">Present Today</p>
<p class="text-2xl font-bold"><?= $present_today ?></p>
</div>

<div class="bg-yellow-500 text-white p-4 rounded-xl shadow">
<p class="text-sm">Total Classes</p>
<p class="text-2xl font-bold"><?= $total_classes ?></p>
</div>

<div class="bg-purple-500 text-white p-4 rounded-xl shadow">
<p class="text-sm">Attendance %</p>
<p class="text-2xl font-bold"><?= $percent ?>%</p>
</div>

</div>

<!-- MAIN GRID -->
<div class="grid grid-cols-2 gap-6">

<!-- RECENT ACTIVITY -->
<div class="bg-white p-5 rounded-xl shadow">
<h3 class="font-semibold mb-4 text-gray-700">Recent Activity</h3>

<table class="w-full text-sm">
<tr class="bg-gray-100">
<th class="p-2 text-left">Student</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php while($r=$recent->fetch_assoc()): ?>
<tr class="border-t">
<td class="p-2"><?= $r['name'] ?></td>

<td class="<?= $r['status']=='present' ? 'text-green-600' : 'text-red-600' ?>">
<?= ucfirst($r['status']) ?>
</td>

<td><?= $r['date'] ?></td>
</tr>
<?php endwhile; ?>

</table>
</div>

<!-- QUICK ACTIONS -->
<div class="bg-white p-5 rounded-xl shadow">
<h3 class="font-semibold mb-4 text-gray-700">Quick Actions</h3>

<div class="grid grid-cols-2 gap-4">

<a href="../students/list.php"
class="bg-blue-100 text-blue-700 p-4 rounded-lg text-center hover:bg-blue-200">
Students
</a>

<a href="../attendance/mark.php"
class="bg-green-100 text-green-700 p-4 rounded-lg text-center hover:bg-green-200">
Mark Attendance
</a>

<a href="../attendance/report.php"
class="bg-yellow-100 text-yellow-700 p-4 rounded-lg text-center hover:bg-yellow-200">
Attendance Report
</a>

<a href="../marks/result.php"
class="bg-purple-100 text-purple-700 p-4 rounded-lg text-center hover:bg-purple-200">
Results
</a>

</div>
</div>

</div>

<!-- EXTRA SECTION -->
<div class="mt-6 bg-white p-5 rounded-xl shadow">
<h3 class="font-semibold mb-4 text-gray-700">System Overview</h3>

<div class="grid grid-cols-3 gap-4 text-center">

<div>
<p class="text-gray-500 text-sm">Students</p>
<p class="text-xl font-bold"><?= $total_students ?></p>
</div>

<div>
<p class="text-gray-500 text-sm">Total Attendance</p>
<p class="text-xl font-bold"><?= $total_classes ?></p>
</div>

<div>
<p class="text-gray-500 text-sm">Performance</p>
<p class="text-xl font-bold text-green-600"><?= $percent ?>%</p>
</div>

</div>

</div>

</div>