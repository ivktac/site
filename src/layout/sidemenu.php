<?php
global $page;

$menu = [
    'main' => 'Main',
    'about' => 'About',
    'news' => 'News',
    'registration' => 'Registration',
    'login' => 'Login',
    'profile' => 'Profile',
    'logout' => 'Logout'
];

if (!isset($_SESSION["user"])) {
    unset($menu['profile']);
    unset($menu['logout']);
}
?>

<nav id="nav">
    <div class="menu">
        <ul>
            <?php foreach ($menu as $action => $title) : ?>
                <li>
                    <a href="index.php?action=<?= $action; ?>" class="link <?= $action == $page ? 'active' : ''; ?>">
                        <?= $title; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>