<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../loggedin/protected_page.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FAQ - Brinth</title>
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../brinth_styles/index/faq.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_navbar.css" />
    <link rel="stylesheet" href="../brinth_styles/index/brinth_forgot.css" />
    <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css" />
</head>

<body>
    <?php include 'brinth_header.php'; ?>

    <div class="page-container">
        <div class="page-title">Frequently Asked Questions</div>

        <!-- FAQ items -->
        <div class="faq-item">
            <button class="faq-question">1. What is Brinth?</button>
            <div class="faq-answer">Brinth is a dark-fantasy logic game where every decision matters. Solve puzzles, defeat time, and stay alive.</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">2. Is it free to play?</button>
            <div class="faq-answer">Yes! Brinth is completely free to play and always will be.</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">3. What are Savior Cards?</button>
            <div class="faq-answer">Savior Cards are your protection from permanent loss. Lose a game, lose a card. Run out? You risk being locked out.</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">4. How do I level up?</button>
            <div class="faq-answer">Earn XP by playing and winning games. Each category has unique challenges and unlock thresholds.</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">5. Can I play from mobile?</button>
            <div class="faq-answer">Brinth is optimized for desktop. Mobile support is in development.</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">6. Are there leaderboards?</button>
            <div class="faq-answer">Yes! The top players by XP are displayed on the Leaderboard page. Do you have what it takes?</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">7. What if I forget my password?</button>
            <div class="faq-answer">Password reset is available via your email address on the login page.</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">8. Is my progress saved?</button>
            <div class="faq-answer">Yes, all your progress, XP, and completed games are stored securely in our database.</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">9. Can I replay games?</button>
            <div class="faq-answer">No. Each game can only be played once per account. Choose wisely!</div>
        </div>

        <div class="faq-item">
            <button class="faq-question">10. Who created Brinth?</button>
            <div class="faq-answer">Brinth was developed by a passionate creator blending gameplay, logic, and storytelling.</div>
        </div>
    </div>

    <?php include 'brinth_footer.php'; ?>

    <script>
        const questions = document.querySelectorAll('.faq-question');
        const answers = document.querySelectorAll('.faq-answer');

        questions.forEach((q, index) => {
            q.addEventListener('click', () => {
                answers.forEach((a, i) => {
                    a.style.display = i === index ? (a.style.display === 'block' ? 'none' : 'block') : 'none';
                });
            });
        });
    </script>
    <script src="Brinth_Index_Script.js" defer></script>
</body>

</html>