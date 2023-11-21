<?php
session_start();

require 'connection.php';
$_SESSION['registered'] = false;
if (!empty($_POST)) {
    if (strcmp($_POST['password'], $_POST['password_confirmation']) !== 0) {
        echo 'Vos mots de passe ne correspondent pas';
    } elseif (empty($_POST['username'])) {
        echo 'Veuillez renseigner votre nom';
    } elseif (empty($_POST['email'])) {
        echo 'Veuillez renseigner votre email';
    } elseif (empty($_POST['password']) || empty($_POST['password_confirmation'])) {
        echo 'Veuillez renseigner votre mot de passe';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo 'Veuillez rentrer une adresse mail valide';
    } elseif (strlen($_POST['password']) < 8 || strlen($_POST['password_confirmation']) < 8) {
        echo "Veuillez rentrer un mot de passe d'au minimum 8 caractères";
    } else {
        $_SESSION['registered'] = true;
    }

}
if ($_SESSION['registered']) {
    $_SESSION['user'] = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
    ];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email,:password)";
    $response = $bdd->prepare($query);
    $response->execute([
        ':username' => $_SESSION['user']['username'],
        ':email' => $_SESSION['user']['email'],
        ':password' => $password
    ]);
    header('location: index.php');
    exit();
} ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
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
        <form action="register.php" method="post" class="form">
            <h3>Register Here</h3>
            <label for="username">Enter your username : </label>
            <input type="text" id="username" name="username" autofocus placeholder="Your username" />

            <label for="email">Enter your email : </label>
            <input type="email" id="email" name="email" placeholder="Your email" />
            <label for="password">Enter your password <span>(at least 8 characters):<span> </label>
            <input type="password" id="password" name="password" placeholder="Your password" />
            <label for="password_confirmation">Enter again your password <span>(at least 8 characters):<span> </label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                placeholder="Enter your password again" />
            <button type="submit" value="Submit" class="submit">Register</button>
        </form>
    </div>
</body>

</html>