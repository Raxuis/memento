<?php
session_start();

require 'connection.php';
$_SESSION['logged'] = false;
if (!empty($_POST)) {
    if (strcmp($_POST['password'], $_POST['password_confirmation']) !== 0) {
        echo 'Vos mots de passe ne correspondent pas';
    } elseif (empty($_POST['name'])) {
        echo 'Veuillez renseigner votre nom';
    } elseif (empty($_POST['login'])) {
        echo 'Veuillez renseigner votre email';
    } elseif (empty($_POST['password']) || empty($_POST['password_confirmation'])) {
        echo 'Veuillez renseigner votre mot de passe';
    } elseif (!filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)) {
        echo 'Veuillez rentrer une adresse mail valide';
    } elseif (strlen($_POST['password']) < 8 || strlen($_POST['password_confirmation']) < 8) {
        echo "Veuillez rentrer un mot de passe d'au minimum 8 caractères";
    } else {
        $_SESSION['logged'] = true;
    }
    $authorizedImages = ['image/png', 'image/jpeg'];

    if ($_FILES['avatar']['error'] == 0 && $_FILES['avatar']['size'] <= 200 * 1024 && in_array($_FILES['avatar']['type'], $authorizedImages)) {
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $newFileName = time() . '.' . $extension;
        $destination = 'images/' . $newFileName;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);
    }

}
if ($_SESSION['logged']) {
    $_SESSION['user'] = [
        'name' => $_POST['name'],
        'login' => $_POST['login'],
        'avatar' => $newFileName
    ];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, avatar, email, password) VALUES (:name, :avatar, :login,:password)";
    $response = $bdd->prepare($query);
    $response->execute([
        ':name' => $_SESSION['user']['name'],
        ':avatar' => $_SESSION['user']['avatar'],
        ':login' => $_SESSION['user']['login'],
        ':password' => $password
    ]);
    header('location: profile.php');
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
            <label for="name">Enter your name : </label>
            <input type="text" id="name" name="name" autofocus />

            <label for="login">Enter your email : </label>
            <input type="login" id="login" name="login" />
            <label for="password">Enter your password : </label>
            <input type="password" id="password" name="password" />
            <label for="password_confirmation">Enter again your password : </label>
            <input type="password" id="password_confirmation" name="password_confirmation" />
            <input type="submit" value="Submit" />
        </form>
    </div>
</body>

</html>