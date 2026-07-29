<?php 
include('../includes/auth_check.php'); 
include('../config/db.php'); 

$class = $_GET['class'] ?? '';

$classes = $conn->query("SELECT DISTINCT class FROM students");
$subjects = $conn->query("SELECT * FROM subjects");

$stats=[];

while($sub=$subjects->fetch_assoc()){
 $sid=$sub['id'];
 $where = $class ? " AND students.class='".$conn->real_escape_string($class)."'" : "";

 $q=$conn->query("
 SELECT AVG(m.marks) avg_marks,
 SUM(m.marks>=40) pass_count,
 COUNT(*) total
 FROM marks m
 JOIN students ON students.id=m.student_id
 WHERE m.subject=$sid $where
 ");

 $r=$q->fetch_assoc();

 $total=$r['total']??0;
 $avg=$total?round($r['avg_marks'],2):0;
 $passp=$total?round(($r['pass_count']/$total)*100,2):0;

 $stats[]=[
  'subject'=>$sub['name'],
  'avg'=>$avg,
  'passp'=>$passp
 ];
}
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="ml-64 p-6 bg-gray-100 min-h-screen">

<!-- HEADER -->
<div class="flex justify-between mb-6">
<h2 class="text-2xl font-bold">Analytics Dashboard</h2>

<form method="GET">
<select name="class" class="border p-2 rounded">
<option value="">All Classes</option>
<?php while($c=$classes->fetch_assoc()): ?>
<option value="<?= $c['class'] ?>" <?= $class==$c['class']?'selected':'' ?>>
<?= $c['class'] ?>
</option>
<?php endwhile; ?>
</select>
<button class="bg-blue-600 text-white px-3 rounded">Apply</button>
</form>
</div>

<!-- CARDS -->
<div class="grid grid-cols-3 gap-4 mb-6">

<div class="bg-white p-4 rounded-xl shadow">
<p class="text-gray-500">Subjects</p>
<h2 class="text-xl font-bold"><?= count($stats) ?></h2>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<p class="text-gray-500">Avg Score</p>
<h2 class="text-xl font-bold">
<?= round(array_sum(array_column($stats,'avg'))/max(count($stats),1),2) ?>
</h2>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<p class="text-gray-500">Avg Pass %</p>
<h2 class="text-xl font-bold">
<?= round(array_sum(array_column($stats,'passp'))/max(count($stats),1),2) ?>%
</h2>
</div>

</div>

<!-- CHARTS -->
<div class="grid grid-cols-2 gap-6">

<div class="bg-white p-6 rounded-xl shadow">
<canvas id="avgChart"></canvas>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<canvas id="passChart"></canvas>
</div>

</div>

</div>

<script>
const labels = <?= json_encode(array_column($stats,'subject')) ?>;
const avgData = <?= json_encode(array_column($stats,'avg')) ?>;
const passData = <?= json_encode(array_column($stats,'passp')) ?>;

// Avg Chart
new Chart(document.getElementById('avgChart'), {
 type:'bar',
 data:{
  labels:labels,
  datasets:[{label:'Average Marks', data:avgData}]
 }
});

// Pass %
new Chart(document.getElementById('passChart'), {
 type:'line',
 data:{
  labels:labels,
  datasets:[{label:'Pass %', data:passData}]
 }
});
</script>