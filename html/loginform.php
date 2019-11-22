<div class="login-background">
<div class="login">
    <h1>eClass4Learning Network Administration Console</h1>
    <form action="authenticate.php" method="post">
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <input type="text" name="username" placeholder="Username" id="username" value="<?php if(isset($_SESSION['username'])) { print $_SESSION['username']; }?>" required>

        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>

        <?php if(isset($_SESSION['loginerror']) && $_SESSION['loginerror'] == TRUE): ?>
            <p class="login-error">Your username and/or password was incorrect.</p>
        <?php endif; ?>

        <input type="submit" value="Login">
    </form>
</div>
</div>
