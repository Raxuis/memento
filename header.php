<header>
    <div class="container">
        <nav>
            <a href="index.php" title="Home" id="memento">Memento</a>
            <div id="nav-second">
                <?php if (!$_SESSION['logged']) { ?>
                    <a href="login.php" class="links" title="Login">Login</a>
                    <a href="register.php" title="Register" class="links">Register</a>
                </div>
            <?php } else { ?>
                <a href="profile.php" class="links" title="Profile">Profile</a>
                <a href="disconnect.php" title="Register" class="links">Disconnect</a>
            <?php } ?>

        </nav>
        <hr>
    </div>
</header>