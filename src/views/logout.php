<?php

if (User::getAuthUser()) {
    session_destroy();
}

header("Location: index.php");