<?php
$title = "Admin Dashboard";
ob_start();
?>

<div style="text-align:center" class="mt-20">
    <h1 style="margin-bottom:10%;">Admin Dashboard</h1>
    <div style="box-shadow:#ccc 3px 0px 5px 0px; padding:30px; border-radius: 5px;background-color:#eee; width: 50%; margin: auto;">
        <p style="text-align:center; color:gray; font-size: 1.5em">Welcome, <?= $_SESSION['user']['username'] ?>!</p>
        <a href="/products" class="btn btn-add mt-20">Manage Products</a>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
