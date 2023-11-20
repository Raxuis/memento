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
    </head>

    <body>
        <form action="remove.php?id=<?= $id ?>" method="post">
            <label for="delete">Are you sure you want to delete the post it?</label>
            <input type="radio" id="yes" name="delete" value="1">
            <label for="yes">Yes</label>
            <input type="radio" id="no" name="delete" value="0">
            <label for="no">No</label>
            <input type="submit" value="Submit" />
        </form>
    </body>

    </html>

    <?php

} else {
    echo "ID not found.";
}
?>