<?php
include('../config/db.php');

if(isset($_POST['register'])){

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// default teacher
$role = 'teacher';

$conn->query("
INSERT INTO users(name,email,password,role)
VALUES('$name','$email','$password','$role')
");

header("Location: login.php");
exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="min-h-screen flex items-center justify-center bg-gray-100">

<form method="POST" class="bg-white p-6 rounded-xl shadow w-80">

<h2 class="text-xl font-bold mb-4 text-center">Register</h2>

<input type="text" name="name" placeholder="Name"
class="w-full border p-2 mb-3 rounded" required>

<input type="email" name="email" placeholder="Email"
class="w-full border p-2 mb-3 rounded" required>

<input type="password" name="password" placeholder="Password"
class="w-full border p-2 mb-3 rounded" required>

<button name="register"
class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">
Register
</button>

<a href="login.php"
class="block text-center mt-3 text-blue-600 text-sm">
Already have account?
</a>

</form>
</div>