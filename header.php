<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="bg-white/80 backdrop-blur-md border-b px-6 py-3 flex justify-between items-center sticky top-0 z-10">  <h1 class="text-lg font-semibold text-gray-800">Campus ERP</h1>

  <div class="flex items-center gap-4">
    <span class="text-gray-600 text-sm"><?= $_SESSION['user']['name'] ?></span>
    <a href="../auth/logout.php" class="text-red-500 hover:underline text-sm">Logout</a>
  </div>
</div>