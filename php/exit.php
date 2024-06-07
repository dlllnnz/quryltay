<?php require('../parts/globals.php') ?>
<?php
    session_unset();
    session_destroy();
    header("refresh:0.5, url=../index.php");
?>