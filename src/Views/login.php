<?php
$title = "Login";
ob_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header("Location: /admin/dashboard");
        exit;
    } else {
        header("Location: /shop");
        exit;
    }
}
?>

<div class="login-div">
<h1>Login</h1>
<form action="/login" method="POST">
    <div class="form-control">
    <label for="username">Username:</label><br/>
    <input type="text" id="username" name="username" placeholder="Enter username" required>
    </div>
    <div class="form-control">
    <label for="password">Password:</label><br/>
    <input type="password" id="password" name="password" placeholder="Enter password" required>
    </div>
    
    <button type="submit" class="mt-20 btn btn-add form-control">Login</button>
</form>

<p>Don't have an account? <a href="/register" style="color:blue;">Register here</a></p>
</div>


<?php
$content = ob_get_clean();
include 'layout.php';
?>
