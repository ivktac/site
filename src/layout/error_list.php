<?php global $errors; ?>

<ul class="error-list">
    <?php foreach ($errors as $error): ?>
        <li><?= $error ?></li>
    <?php endforeach ?>
</ul>