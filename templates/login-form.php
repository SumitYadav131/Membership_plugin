<?php if ( is_user_logged_in() ) : ?>
    <p>You are already logged in. <a href="/my-account">Go to My Account</a></p>
<?php else : ?>

<form method="post">
    <p>
        <label>Username or Email</label><br>
        <input type="text" name="username" required>
    </p>

    <p>
        <label>Password</label><br>
        <input type="password" name="password" required>
    </p>

    <?php wp_nonce_field('cmp_login', 'cmp_login_nonce'); ?>

    <p><button type="submit">Log In</button></p>

    <?php if ( isset($_GET['login']) && $_GET['login'] === 'failed' ) : ?>
        <p style="color:red;">❌ Incorrect username or password.</p>
    <?php endif; ?>
</form>
<?php endif; ?>
