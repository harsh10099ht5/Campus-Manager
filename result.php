<?php 
include('../includes/auth_check.php'); 
include('../config/db.php'); 

$class=$_GET['class']??'';

$classes=$conn->query("SELECT DISTINCT class FROM students");
$subjects=$conn->query("SELECT * FROM subjects");

$students=$conn->query("SELECT * FROM students".($class?" WHERE class='$class'":""));

$data=[];

while($s=$students->fetch_assoc()){
 $id=$s['id'];

 $row=['id'=>$id,'name'=>$s['name'],'class'=>$s['class'],'marks'=>[],'total'=>0,'count'=>0];

 $subs=$conn->query("SELECT * FROM subjects");
 while($sub=$subs->fetch_assoc()){
  $m=$conn->query("SELECT marks FROM marks WHERE student_id=$id AND subject=".$sub['id']);
  $val=$m->fetch_assoc()['marks']??0;

  $row['marks'][]=$val;
  $row['total']+=$val;
  if($val>0)$row['count']++;
 }

 $row['avg']=$row['count']?round($row['total']/$row['count'],2):0;
 $data[]=$row;
}

usort($data, fn($a,$b)=>$b['avg']<=>$a['avg']);
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="ml-64 p-6 bg-gray-100 min-h-screen">

<div class="flex justify-between mb-6">

<form method="GET">
<select name="class" class="border p-2 rounded">
<option value="">All Classes</option>
<?php while($c=$classes->fetch_assoc()): ?>
<option value="<?= $c['class'] ?>" <?= $class==$c['class']?'selected':'' ?>>
<?= $c['class'] ?>
</option>
<?php endwhile; ?>
</select>
<button class="bg-blue-600 text-white px-3 rounded">Filter</button>
</form>

<a href="analysis.php" class="bg-purple-600 text-white px-4 py-2 rounded">
Analytics
</a>

</div>

<div class="bg-white rounded-xl shadow overflow-auto">

<table class="w-full text-sm">

<tr class="bg-gray-100">
<th>Rank</th>
<th>Name</th>
<th>Class</th>

<?php $subjects->data_seek(0); while($sub=$subjects->fetch_assoc()): ?>
<th><?= $sub['name'] ?></th>
<?php endwhile; ?>

<th>Total</th>
<th>Avg</th>
<th>Report</th>
</tr>

<?php $rank=1; foreach($data as $d): ?>
<tr class="<?= $rank==1?'bg-yellow-50':'' ?> border-t">

<td><?= $rank ?></td>
<td><?= $d['name'] ?></td>
<td><?= $d['class'] ?></td>

<?php foreach($d['marks'] as $m): ?>
<td><?= $m ?></td>
<?php endforeach; ?>

<td class="font-semibold"><?= $d['total'] ?></td>
<td><?= $d['avg'] ?></td>

<td>
<a href="student_report.php?student=<?= $d['id'] ?>"
class="text-blue-600 underline">View</a>
</td>

</tr>
<?php $rank++; endforeach; ?>

</table>

</div>

</div>