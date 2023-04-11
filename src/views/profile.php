<section id="page-profile">
    <h1>Profile</h1>

    <div class="profile">
        <?php if (isset($_SESSION['user'])) : ?>
            <?php $user = unserialize($_SESSION['user']); ?>
            <p>First Name: <b><?= $user->first_name ?></b></p>
            <p>Last Name: <b><?= $user->last_name ?></b></p>
            <p>Birthdate: <b><?= $user->birthdate ?></b></p>
            <p>Login: <b><?= $user->login ?></b></p>
            <p>Email: <b><?= $user->email ?></b></p>
            <p>Role: <b><?= $user->admin ? 'Admin' : 'User' ?></b></p>
        <?php endif; ?>

        <a href="index.php?action=edit_profile">Edit Profile</a>
    </div>
</section>