<?php global $page; ?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'src/layout/head.php'; ?>
</head>

<body class=<?= "page-" . $page; ?>>
    <?php require_once 'src/layout/header.php'; ?>

    <main>
        <?php require_once "src/views/" . $page . ".php"; ?>
    </main>

    <?php require_once 'src/layout/footer.php'; ?>
</body>

</html>