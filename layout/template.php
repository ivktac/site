<!DOCTYPE html>
<html lang="en-US">

<head>
    <?php require_once 'layout/head.php'; ?>
</head>

<body class=<?= "page-" . $page; ?>>
    <?php require_once 'layout/header.php'; ?>

    <main>
        <?php require_once "views/" . $page . ".php"; ?>
    </main>

    <?php require_once 'layout/footer.php'; ?>
</body>

</html>