<nav id="nav">
    <div class="brand">
        <a href="index.php" class="link brand">
            <img src="assets/img/arch.svg" />
            <span>Arch Linux</span>
        </a>
    </div>
    <div class="menu">
        <ul>
            <?php foreach ($menu as $action => $title): ?>
                <li>
                    <a href="index.php?action=<?php echo $action; ?>"
                        class="link <?php echo $action == $page ? 'active' : ''; ?>"><?php echo $title; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>