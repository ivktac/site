<?php

if (!isSignedIn()) {
    header("Location: index.php");
}

if (isset($_SESSION["user"])) {
    session_destroy();
    header("Location: index.php");
}