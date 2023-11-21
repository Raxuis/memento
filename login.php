<?php
session_start();

$_SESSION['logged'] = false;
require 'connection.php';

if (!empty($_POST)) {
    $query = "SELECT * FROM users WHERE email LIKE :email";
    $response = $bdd->prepare($query);
    $response->execute([
        ':email' => $_POST['email']
    ]);
    $user = $response->fetch(PDO::FETCH_ASSOC);
    if (empty($_POST['email'])) {
        echo 'Please enter your email';
    } elseif (empty($_POST['password'])) {
        echo 'Please enter your password';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo 'Please enter a valid email address';
    } elseif (strlen(strtoupper($_POST['password'])) < 8) {
        echo 'Please enter a password with at least 8 characters';
    } else {
        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['token'] = md5(uniqid(mt_rand(), true));
            $_SESSION['logged'] = true;
            $_SESSION['user'] = [
                'email' => $_POST['email'],
            ];
        } else {
            echo 'Incorrect password';
        }
    }
}

if ($_SESSION['logged']) {
    header('location:index.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Glass+Antiqua&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Glagolitic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <?php include 'header.php'; ?>
    <div class="container">
        <form action="login.php" method="post">
            <h3>Login Here</h3>
            <label for="email">Enter your email : </label>
            <input type="email" id="email" name="email" autofocus placeholder="Email" id="username" />

            <label for="password">Enter your password : </label>
            <input type="password" id="password" name="password" placeholder="Password" id="password" />
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
            <button type="submit" value="Submit" class="submit">Log In</button>
        </form>
    </div>
    </div>
</body>