<nav id="nav">
    <div class="menu">
        <ul>
            <?php foreach ($menu as $action => $title): ?>
                <li>
                    <a href="index.php?action=<?= $action; ?>" class="link <?= $action == $page ? 'active' : ''; ?>"><?= $title; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>