<?php
include('../config/db.php');
session_start();

if(isset($_POST['login'])){

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if($res && password_verify($password, $res['password'])){

$_SESSION['user'] = $res;

if($res['role'] == 'admin'){
header("Location: ../dashboard/dashboard.php");
}else{
header("Location: ../teacher/dashboard.php");
}
exit;

}else{
$error = "Invalid Email or Password";
}

}
?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="min-h-screen flex items-center justify-center bg-gray-100">

<form method="POST" class="bg-white p-6 rounded-xl shadow w-80">

<h2 class="text-xl font-bold mb-4 text-center">Login</h2>

<?php if(isset($error)): ?>
<p class="bg-red-100 text-red-600 p-2 mb-3 rounded text-sm">
<?= $error ?>
</p>
<?php endif; ?>

<input type="email" name="email" placeholder="Email"
class="w-full border p-2 mb-3 rounded" required>

<input type="password" name="password" placeholder="Password"
class="w-full border p-2 mb-3 rounded" required>

<button name="login"
class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
Login
</button>

<a href="register.php"
class="block text-center mt-3 text-blue-600 text-sm">
Create Account
</a>

</form>
</div>