<?php
require 'connection.php';
$query = "SELECT * FROM post_it ORDER BY created_at DESC";
$response = $bdd->query($query);
$datas = $response->fetchAll();
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
    <main>
        <div class="container">
            <div id="title">
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
                            <a href="remove.php?id=<?= $data['id'] ?>" class="delete" title="<?= $data['title'] ?>"><i
                                    class="fa-regular fa-circle-xmark"></i></a>
                        </div>
                        <div class="card-body">

                            <p>
                                <?= $data['content'] ?>
                            </p>
                            <p>
                                <?= $data['date'] ?>
                            </p>

                        </div>

                    </article>
                <?php } ?>
            </div>
    </main>

</body>

</html>