<section id="page-profile">
    <h1>Profile</h1>

    <div class="profile">
        <?php if (isset($_SESSION['user'])) : ?>
            <?php $user = unserialize($_SESSION['user']); ?>
            <p>Login: <b><?= $user->login ?></b></p>
            <p>Email: <b><?= $user->email ?></b></p>
            <p>Role: <b><?= $user->is_admin ? 'Admin' : 'User' ?></b></p>
        <?php endif; ?>
    </div>
</section>