<?php

function checkAllowedRights()
{
    if (isset($_SESSION["user"])) {
        $user = unserialize($_SESSION["user"]);
        if (!$user->is_admin) {
            header("Location: index.php");
        }
    }
}
