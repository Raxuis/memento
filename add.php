<?php
require 'connection.php';
session_start();

if (isset($_POST['token'])) {
    $token = $_POST['token'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!$token || $token !== $_SESSION['token']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        } else {
            $queryId = "SELECT id FROM users WHERE email=:email";
            $responseUser = $bdd->prepare($queryId);
            $responseUser->execute(
                [
                    'email' => $_SESSION['user']['email'],
                ]
            );
            $user_id = $responseUser->fetch();
            $query = "INSERT INTO post_it (title, content, date, color, user_id) VALUES (:title, :content, :date, :color, :user_id)";
            $response = $bdd->prepare($query);
            $response->execute([
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'date' => $_POST['date'],
                'color' => $_POST['color'],
                'user_id' => $user_id['id'],
            ]);
            header('location: index.php');
            exit();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post it Addition</title>
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
        <form action="add.php" method="post">
            <label for="title">Add the title: </label>
            <input type="text" id="title" name="title" />
            <label for="content">Add the content: </label>
            <textarea id="content" name="content"></textarea>
            <label for="date">Add the date: </label>
            <input type="date" id="date" name="date" />
            <label for="color">Choose the color of the post it: </label>
            <input type="color" id="color" name="color" />
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
            <button type="submit" value="Submit" class="submit">Create a post it </button>
        </form>
    </div>
</body>

</html>