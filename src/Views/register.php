<?php
$title = "Register";
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

<h1>Register</h1>

<form method="POST" action="/register">
    <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" required  placeholder="Enter username">
    </div>

    <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" required  placeholder="Enter password">
    </div>

    <div class="form-group">
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required  placeholder="Enter password again">
    </div>

    <div class="form-group">
        <label>Role:</label><br/>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button type="submit" class="mt-20 btn btn-add form-control">Register</button>
</form>

<p>Already have an account? <a href="/login" style="color:blue;">Login here</a></p>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
