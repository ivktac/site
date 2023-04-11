<?php global $page; ?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale-1.0" />
    <title>
        Arch Linux | <?= $page != '404' ? ucfirst($page) : 'Page Not Found'; ?>
    </title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css?v=1" />
    <link rel="shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/a/a5/Archlinux-icon-crystal-64.svg" type="image/png" />
</head>

<body class=<?= "page-" . $page; ?>>
    <header class="header">
        <div class="brand">
            <a href="index.php" class="link brand">
                <img src="assets/img/arch.svg" />
                <span>Arch Linux</span>
            </a>
        </div>

        <?php require_once 'layout/sidemenu.php'; ?>
    </header>