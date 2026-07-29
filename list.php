<?php 
include('../config/db.php');

// Search
$q = $_GET['q'] ?? '';
$r = $conn->query("SELECT * FROM students WHERE name LIKE '%$q%'");
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="ml-64 p-6 bg-gray-100 min-h-screen">

<!-- Header -->
<div class="flex justify-between items-center mb-6">

  <div class="flex items-center gap-3">
    <a href="../dashboard/dashboard.php"
    class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-300">
    ← Back
    </a>

    <h2 class="text-2xl font-semibold text-gray-800">Students</h2>
  </div>

  <a href="add.php"
  class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
  + Add Student
  </a>

</div>

<!-- Search -->
<form method="GET" class="mb-4">
  <input name="q" value="<?= htmlspecialchars($q) ?>"
  placeholder="🔍 Search student..."
  class="border p-2 rounded-lg w-64 focus:ring-2 focus:ring-blue-500">
</form>

<!-- Count -->
<div class="flex justify-between items-center mb-3">
  <p class="text-sm text-gray-500">
    Total: <?= $r->num_rows ?> students
  </p>
</div>

<?php if($r->num_rows > 0): ?>

<!-- Table -->
<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full">

<thead class="bg-gray-100 text-gray-600 text-sm">
<tr>
  <th class="p-4 text-left">Name</th>
  <th class="p-4 text-left">Email</th>
  <th class="p-4 text-left">Class</th>
  <th class="p-4 text-left">Action</th>
</tr>
</thead>

<tbody class="text-sm">

<?php $i=0; while($x=$r->fetch_assoc()): $i++; ?>
<tr class="<?= $i%2==0 ? 'bg-gray-50' : '' ?> hover:bg-blue-50 transition">

  <td class="p-4 font-medium"><?= $x['name'] ?></td>
  <td class="p-4 text-gray-600"><?= $x['email'] ?></td>
  <td class="p-4"><?= $x['class'] ?></td>

  <td class="p-4 space-x-2">

    <a href="edit.php?id=<?= $x['id'] ?>"
    class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
    Edit
    </a>

    <a href="delete.php?id=<?= $x['id'] ?>"
    onclick="return confirm('Delete this student?')"
    class="px-3 py-1 text-sm bg-red-100 text-red-600 rounded hover:bg-red-200">
    Delete
    </a>

  </td>

</tr>
<?php endwhile; ?>

</tbody>
</table>

</div>

<?php else: ?>

<!-- Empty State -->
<div class="bg-white p-8 rounded-xl text-center text-gray-500 shadow">
  <p class="text-lg">No students found</p>
  <a href="add.php" class="text-blue-600 underline mt-2 inline-block">
    Add your first student
  </a>
</div>

<?php endif; ?>

</div>

<!-- Smooth UI -->
<script>
document.querySelectorAll('tr').forEach(row=>{
  row.style.transition="all 0.2s ease";
});
</script>