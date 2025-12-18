<!-- brinth_header.php -->
<header class="brinth-navbar">
    <div class="navbar-left">
        <a href="brinthgame.php">
            <img src="../brinth_icons/brinth_logo.png" alt="Brinth Logo" class="nav-logo" />
        </a>

        <div class="nav-item dropdown">
            <a href="#" class="nav-link">Information↴</a>
            <div class="dropdown-content">
                <a href="all.php">Categories</a>
                <a href="all.php#roles-section">Roles</a>
                <a href="brinth_gamespage.php">Games</a>
            </div>
        </div>

        <a href="Brinth_Sin_Insights.php" class="nav-item nav-link">Insights</a>
        <a href="brinth_leaderboard.php" class="nav-item nav-link">Leaderboard</a>
    </div>

    <form class="navbar-login" action="brinthlogin.php" method="POST">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <div class="login-group">
            <button type="submit">Login</button>
            <a href="#" class="forgot-pass" onclick="openForgotForm()">Forgot Password?</a>
        </div>
    </form>
</header>

<!-- Mobile Nav -->
<div class="mobile-nav">
    <div class="mobile-nav-top">
        <a href="brinthgame.php">
            <img src="../brinth_icons/brinth_logo.png" class="nav-logo" alt="Brinth Logo">
        </a>
        <div class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</div>
    </div>

    <div id="mobileMenu" class="mobile-menu-slide">
        <div class="mobile-menu-header">
            <img src="../brinth_icons/brinth_logo.png" class="nav-logo" alt="Brinth Logo">
            <div class="mobile-close-btn" onclick="toggleMobileMenu()">✖</div>
        </div>

        <div class="mobile-menu-links">
            <div class="mobile-dropdown">
                <span onclick="toggleDropdown(this)">Information↴</span>
                <div class="dropdown-items">
                    <a href="all.php">Categories</a>
                    <a href="all.php#roles-section">Roles</a>
                    <a href="brinth_gamespage.php">Games</a>
                </div>
            </div>
            <a href="Brinth_Sin_Insights.php">Insights</a>
            <a href="brinth_leaderboard.php">Leaderboard</a>
        </div>

        <form class="mobile-login" action="brinthlogin.php" method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
            <a href="#" class="forgot-pass" onclick="openForgotForm()">Forgot Password?</a>
        </form>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="forgot-modal" id="forgot-modal">
    <div class="forgot-box">
        <form id="forgot-form">
            <h3>Recover Password</h3>
            <input type="email" name="recovery_email" placeholder="Enter your email" required />
            <button type="submit">Send Reset Link</button>
            <button type="button" onclick="closeForgotForm()">Cancel</button>
        </form>
    </div>
</div>
<div id="login-error-popup" class="login-error-popup" style="display: none;">
    <div class="login-error-box">
        <p>Incorrect Username or Password<br><br>Please, try again.</p>
    </div>
</div>