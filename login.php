<?php
session_start();

$_SESSION['logged'] = false;

require 'connection.php';
if (!empty($_POST)) {
    if (empty($_POST['email'])) {
        echo 'Veuillez renseigner votre email';
    } elseif (empty($_POST['password'])) {
        echo 'Veuillez renseigner votre mot de passe';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo 'Veuillez rentrer une adresse mail valide';
    } elseif (strlen(strtoupper($_POST['password'])) < 8) {
        echo "Veuillez rentrer un mot de passe d'au minimum 8 caractères";
    } else {
        $_SESSION['logged'] = true;
    }
}

if ($_SESSION['logged']) {
    $_SESSION['user'] = [
        'email' => $_POST['email'],
    ];
    $query = "SELECT * FROM users WHERE email LIKE :email";
    $response = $bdd->prepare($query);
    $response->execute([
        ':email' => $_SESSION['user']['email']
    ]);

    $user = $response->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        header('location:index.php');
        exit();
    } else {
        echo 'Mot de passe incorrect';
    }
} ?>

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
        <div id="login">
            <form action="login.php" method="post" class="form">
                <label for="email">Enter your email : </label>
                <input type="email" id="email" name="email" value="user@user.com" autofocus />

                <label for="password">Enter your password : </label>
                <input type="password" id="password" name="password" value="password" />
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
                <input type="submit" value="Submit" />
            </form>
        </div>
    </div>
</body>