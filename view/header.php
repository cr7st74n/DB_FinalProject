<header>
    <div class="container">
        <div class="hero">
            <h1>The Teenage Mutant Ninja Turtles Project</h1>
        </div>
    </div>

    <nav class="navbar navbar-expand-sm bg-success navbar-dark">
        <a class="navbar-brand">
            <img src="./img/TMNT.png" alt="logo" style="width:60px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php">Products</a>
                </li>

                <?php
                session_start();
                if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Signin.php">Sign Up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>