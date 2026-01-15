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
    <title>Insights - Brinth</title>
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../brinth_styles/index/insights.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_navbar.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_forgot.css" />

</head>

<body>
<?php include 'brinth_header.php'; ?>
    <div class="insight-container">
        <h1 class="insight-title">Brinth: Behind the Cards</h1>

        <section class="insight-block fade-in">
            <div class="insight-image left"><img src="../brinth_icons/aib.jpg" alt="Mystery Card Stack"></div>
            <div class="insight-text">
                <h2>The Concept</h2>
                <p>
                    Brinth was born from our fascination with Alice in Borderland,
                    a series that masterfully blends survival, strategy, and psychological tension through mysterious games.
                    Its dark atmosphere, high stakes, and symbolic use of playing cards sparked the idea to build
                    a game world where time is limited, choices matter, and players must earn their survival—just like in the series,
                    but with our own twist and universe.
                </p>
            </div>
        </section>

        <section class="insight-block fade-in">
            <div class="insight-text">
                <h2>Brinth x OpenAI</h2>
                <p>
                    The Brinth Team extend their heartfelt thanks to OpenAI for playing a vital role in shaping the game's artistic vision. 
                    From atmospheric backgrounds to iconic in-game visuals, nearly half of the images were crafted through the creative collaboration with AI. 
                    ChatGPT sucessfully brought to life the dark fantasy world of Brinth with stunning detail and imagination, including all four images of this page.
                </p>
            </div>
            <div class="insight-image right">
                <img src="../brinth_icons/chatgpt.jpg" alt="Leader Role Icon">
            </div>
        </section>

        <section class="insight-block fade-in">
            <div class="insight-image left"><img src="../brinth_icons/intro_image4.jpg" alt="Hearts Game Preview"></div>
            <div class="insight-text">
                <h2>Category Design</h2>
                <p>
                    Each suit — Spades, Hearts, Clubs, Diamonds — was chosen with a psychological theme in mind. Hearts challenge your vision.
                    Spades test logic. Clubs demand memory. And Diamonds wants strategy. The deeper you go, the darker it gets.
                </p>
                                <a href="all.php" class="cta-button">See More</a>

            </div>
        </section>

        <section class="insight-block fade-in">
            <div class="insight-text">
                <h2>Development Ethos</h2>
                <p>
                    Brinth was not built to waste time. It was built to value it. The countdown isn't just for show — it's your reminder
                    that every puzzle, every click, and every second is a chance to think better.
                </p>
                <a href="brinth_register_page.php" class="cta-button">Play Now!</a>
            </div>
            <a href="brinthgame.php">
                <div class="insight-image right">
                    <img src="../brinth_icons/inpage_ethos.png" alt="Core Visual">
                </div>
            </a>
        </section>
    </div>

    <hr class="brinth-divider">

<?php include 'brinth_footer.php'; ?>

    <script>
        const fadeEls = document.querySelectorAll('.fade-in');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, {
            threshold: 0.3
        });

        fadeEls.forEach(el => observer.observe(el));
    </script>
<script src="Brinth_Index_Script.js" defer></script>
</body>
</html>