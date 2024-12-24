<?php
$request = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Vending Machine' ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <header>
        <nav>
            <!-- <a href="/">Home</a> -->
            <div class="logout-btn">
            <?php if (isset($_SESSION['user'])): ?>
                
                    <a href="/logout" style="display:flex;text-decoration:none;padding:3px 10px">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                    &nbsp;Logout</a>
                
            <?php elseif ($request == '/login'): ?>                
                <a href="/register" style="text-decoration:none;padding:3px 10px">Register</a>
            <?php elseif ($request == '/register'): ?>                
                <a href="/login" style="text-decoration:none;padding:3px 10px">Login</a>
            <?php endif; ?>
            </div>
            <div style="clear:both;"></div>
        </nav>
    </header>
    <main class="container" style="min-height:70vh">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

        <?= $content ?>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> Vending Machine</p>
    </footer>
</body>
</html>
