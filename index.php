<?php
require 'connection.php';
session_start();
if (isset($_SESSION['user']['email'])) {
    $query = "SELECT p.id AS post_it_id, p.title, p.content, p.color, p.date, u.id AS user_id, u.email
        FROM post_it as p 
        INNER JOIN users as u ON p.user_id = u.id 
        WHERE u.email=:email 
        ORDER BY p.created_at DESC";
    $response = $bdd->prepare($query);
    $response->execute(
        [
            'email' => $_SESSION['user']['email'],
        ]
    );
    $datas = $response->fetchAll();
}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memento</title>
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
    <?php include 'header.php';
    ?>
    <?php if (isset($_SESSION['logged'])) { ?>
        <?php if ($_SESSION['logged']) { ?>
            <div class="container">
                <div id="page-title">
                    <h1>Memento</h1>
                    <button class="btn" onclick="window.location.href = 'add.php';">Add Post it</button>
                </div>
                <div class="post-its">
                    <?php foreach ($datas as $data) { ?>
                        <article class="card" style="background-color: <?= $data['color'] ?>;">
                            <div class="card-title">
                                <h3>
                                    <?= $data['title'] ?>
                                </h3>
                                <a href="remove.php?id=<?= $data['post_it_id'] ?>" class="delete" title="<?= $data['title'] ?>"><i
                                        class="fa-regular fa-circle-xmark"></i></a>

                            </div>
                            <div class="card-body">
                                <p>
                                    <?= nl2br($data['content']) ?>
                                </p>
                                <p>
                                    <?= $data['date'] ?>
                                </p>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="container" id="not-connected">
                <p>You are not connected, connect to be able to create post its.</p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="container" id="not-connected">
            <p>You are not connected, connect to be able to create post its.</p>
        </div>
    <?php } ?>

    </div>
    </main>

</body>

</html>