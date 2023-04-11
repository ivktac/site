<?php
global $page;

$menu = [
    'main' => ['name' => 'Main'],
    'about' => ['name' => 'About'],
    'news' => ['name' => 'News'],
    'registration' => ['name' => 'Registration', 'visible' => !User::isAuth()],
    'login' => ['name' => 'Login', 'visible' => !User::isAuth()],
    'profile' => ['name' => 'Profile', 'visible' => User::isAuth()],
    'logout' => ['name' => 'Logout', 'visible' => User::isAuth()]
];
?>

<nav id="nav">
    <div class="menu">
        <ul>
            <?php foreach ($menu as $action => $options) : ?>
                <?php if (isset($options['visible']) && !$options['visible']) continue; ?>
                <li>
                    <a href="index.php?action=<?= $action; ?>" class="link <?= $action == $page ? 'active' : ''; ?>">
                        <?= $options['name']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>