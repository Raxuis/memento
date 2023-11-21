<?php
require 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (count($_POST) != 0) {
        if (isset($_POST['delete']) && $_POST['delete'] == 1) {
            $query = "DELETE FROM post_it WHERE id=" . $id;
            $bdd->query($query);
            header('location: index.php');
            exit();
        } else {
            header('location: index.php');
            exit();
        }
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Post it Deletion</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div class="container">
            <form action="remove.php?id=<?= $id ?>" method="post">
                <label for="delete">Are you sure you want to delete the post it?</label>
                <label for="yes">Yes :</label>
                <input type="radio" id="yes" name="delete" value="1" class="radio">
                <label for="no">No : </label>
                <input type="radio" id="no" name="delete" value="0" class="radio">
                <input type="submit" value="Submit" class="submit" />
            </form>
        </div>
    </body>

    </html>

    <?php

} else {
    echo "ID not found.";
}
?>