<section id="page-profile">
    <h1>Profile</h1>

    <div class="profile">
        <?php if (isset($_SESSION['user'])): ?>
            <?php $user = unserialize($_SESSION['user']); ?>
            <?php if ($user instanceof UserResponse): ?>
                <p>Login: <b>
                        <?= $user->login ?>
                    </b></p>
                <p>Email: <b>
                        <?= $user->email ?>
                    </b></p>
                <p>Role: <b>
                        <?= $user->role ? 'Admin' : 'User' ?>
                    </b></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>