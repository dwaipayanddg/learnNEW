<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.html");
    exit();
}

$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="home-container">
        <div class="user-info">
            <button class="user-name"><?php echo $name; ?></button>
            <img src="path/to/your/image.jpg" alt="User Image">
            <h2><?php echo $name; ?></h2>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
