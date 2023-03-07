<nav id="nav">
    <div class="brand">
        <a href="index.php" class="link brand">
            <img src="assets/img/arch.svg" />
            <span>Arch Linux</span>
        </a>
    </div>
    <div class="menu">
        <ul>
            <?php foreach ($menu as $action => $title) : ?>
                <li>
                    <a href="index.php?action=<?= $action; ?>" class="link <?= $action == $page ? 'active' : ''; ?>"><?= $title; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>