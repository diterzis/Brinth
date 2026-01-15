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
    <title>Categories - Brinth</title>
    <link rel="icon" type="image/png" href="../brinth_icons/brinth_logo.png">
    <link rel="stylesheet" href="../brinth_styles/index/all.css">
    <link rel="stylesheet" href="../brinth_styles/index/brinth_navbar.css" />
    <link rel="stylesheet" href="../brinth_styles/index/brinth_footer.css" />
    <link rel="stylesheet" href="../brinth_styles/index/brinth_forgot.css" />


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&family=UnifrakturMaguntia&display=swap');

        @font-face {
            font-family: 'CopperplateCC-Bold';
            src: url('../brinth_styles/brinth_fonts/CopperplateCC-Bold.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Attack of Monster';
            src: url('Brinth_Fonts/Attack Of Monster.ttf') format('truetype');
        }

        body {
            margin: 0;
            font-family: 'Georgia', serif;
            background: radial-gradient(ellipse at center, #102324, #000);
            color: #f0f0f0;
        }

        .page-container {
            padding: 80px 20px 60px 20px;
            text-align: center;
        }

        .category-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 60px;
            max-width: 900px;
            margin: 0 auto;
        }

        .category-row {
            display: flex;
            align-items: center;
            gap: 40px;
            text-align: left;
        }

        .category-row img {
            width: 150px;
            height: auto;
            box-shadow: 0 0 20px #000;
            border-radius: 10px;
        }

        .card-text {
            font-size: 1.2em;
            font-family: 'CopperplateCC-Bold', serif;
            color: #d5c1ad;
            text-shadow: 0 0 6px #5e4431;
            max-width: 550px;
            line-height: 1.6;
        }


        @media (max-width: 768px) {
            .category-row {
                flex-direction: column;
                text-align: center;
            }
        }



        /* Showcase Section */
        .brinth-games-showcase {
            background-size: cover;
            background: url("../brinth_icons/index_cat_showcase_bg.jpg") no-repeat right center;
            position: relative;
            isolation: isolate;
            box-shadow: 0 0 40px #000000b3;
            padding: 60px 8%;
            margin: 100px auto;
            min-height: 450px;
        }


        .game-tile {
            width: 300px;
            height: 580px;
            overflow: hidden;
            background-color: #111;
            border-radius: 10px;
            box-shadow: 0 0 12px #00000088;
            position: relative;
            transition: all 0.5s ease;
            cursor: pointer;
        }

        .game-tile.expanded {
            width: 350px;
            height: 600px;
        }

        .game-tile .tile-top {
            width: 100%;
            height: 60%;
            position: relative;
        }

        .game-tile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tile-overlay {
            position: relative;
            background-color: #111;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            gap: 6px;
            height: 90px;
            padding-top: 50px;
            font-family: 'Cinzel Decorative', serif;
            opacity: 1;
            transition: opacity 0.3s ease;
        }


        .tile-title {
            font-size: 2em;
            font-weight: bold;
            letter-spacing: 1px;
            font-family: 'Roboto Slab', serif;
        }

        .tile-expand {
            font-size: 1.1em;
            padding: 5px 12px;
            border: 1px solid #5e4431;
            border-radius: 30px;
            transition: background 0.3s ease, box-shadow 0.3s ease;
            margin-top: 25px;
        }



        .tile-expand:hover {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 6px #a88a60;
        }

        .tile-content {
            opacity: 0;
            padding: 15px;
            transition: opacity 0.3s ease;
        }

        .game-tile.expanded .tile-content {
            opacity: 1;
        }

        .game-tile.expanded .tile-overlay {
            opacity: 0;
            pointer-events: none;
        }

        .tile-content p {
            color: #ccc;
            font-size: 0.95em;
            margin-bottom: 15px;
            font-style: italic;
        }
    </style>

<body>
    <?php include 'brinth_header.php'; ?>


    <div class="page-container">

        <p style="margin-top: 100px; color: #6b8c8cff; font-size: 1.2em; text-shadow: 0 0 4px #d4dfdf;">
            Discover the four mystical Categories that define your challenge path:
            <br>Each set offers a unique type of gameplay.
            <br><br>
            Ascend through the Ranks and prove your worth: from an Unclassified soul to a
            commanding Leader
            <br>Your role is earned. Your legacy awaits!
        </p>



        <div class="showcase-title">
            <h2>Categories</h2>
        </div>

        <!-- Showcase Section -->
        <section class="brinth-games-showcase">
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/cat_spades.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Spades</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p>Spades are pure logic. Each game tests your ability to reason clearly and solve under
                        pressure.</p>
                    <p>Every correct answer gets 33 xp. Win the round by having at least 7/10 and get 100 xp bonus!</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/cat_hearts.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Hearts</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p>Hearts are the hardest. A world of illusion and pattern recognition — only for the brave.</p>
                    <p>Find the door and instantly receive 350 experience points to your account!</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/cat_clubs.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Clubs</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p>Clubs bring memory and rhythm. Follow the sequence, or be thrown back into confusion.</p>
                    <p>In Hangman, you receive 350 xp points if it's correct. <br>In Crack the Code you receive 100 points for every correct digit, find all 3 to receive +50xp!</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/cat_diamonds.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Diamonds</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p>Diamonds require intuition and speed. Quick thinking leads to glory — hesitation to
                        downfall.</p>
                    <p>Due to the time you spend figuring it out, we decided to give you the most xp, giving you 400 for every solved mystery!</p>
                </div>
            </div>
        </section>

        <div id="roles-section"></div>
        <div class="showcase-title">
            <h2>Roles</h2>
        </div>
        <!-- Second Showcase Section -->
        <section class="brinth-games-showcase">
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role1_unclassified.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Unclassified</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>Unclassified</ins></b></p>
                    <p></p>
                    <p>A gentle start. Trust your instincts and begin your journey into the unknown.</p>
                    <p>Only stay here until you reach 1000 experience points</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role2_brinther.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Brinther</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>Brinther</ins></b></p>
                    <p></p>
                    <p>Darkness deepens. Watch carefully – not all doors are what they seem.</p>
                    <p>Reach 1000 experience points and receive your first role!</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role3_first_class_brinther.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">First Class Brinther</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>First Class Brinther</ins></b></p>
                    <p></p>
                    <p>Your memory will be tested. Remember the path that brought you here.</p>
                    <p>Double your experience point to make them 2k and reach the First Class</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role4_master_brinther.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Master Brinther</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>Master Brinther</ins></b></p>
                    <p></p>
                    <p>Trickery lies ahead. Rely on logic more than luck from this point on.</p>
                    <p>+1500xp and you're a master!</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role5_specialist.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Specialist</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>Specialist</ins></b></p>
                    <p></p>
                    <p>Halfway through. The stakes grow higher. Who will you trust?</p>
                    <p>5000 is enough to be a Specialist</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role6_captain.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Captain</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>Captain</ins></b></p>
                    <p></p>
                    <p>A twist in the tale. Patterns begin to emerge — can you see them?</p>
                    <p>Only those having 7000 experience points and above have the rights to be a Captain!</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role7_major_brinther.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Major Brinther</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>Major Brinther</ins></b></p>
                    <p></p>
                    <p>Danger and deception. This level separates the brave from the reckless.</p>
                    <p>Promoted to Major just by having 2k xp more!</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role8_command_brinth_major.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Command Brinth Major</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>Command Brinth Major</ins></b></p>
                    <p></p>
                    <p>Only a few remain. Focus. Every step now echoes in eternity.</p>
                    <p>10000 experience points for this. Do you think that's a lot?</p>
                </div>
            </div>
            <div class="game-tile collapsed">
                <div class="tile-top">
                    <img src="../brinth_icons/cat_ranks/role9_leader.jpg" alt="Brinth Main" />
                    <div class="tile-overlay">
                        <div class="tile-title">Leader</div>
                        <div class="tile-expand">+</div>
                    </div>
                </div>
                <div class="tile-content">
                    <p><b><ins>Leader</ins></b></p>
                    <p></p>
                    <p>The final riddle. Face it with courage and claim your legacy.</p>
                    <p>Reach 12000 experience points, and fight the list to remain on the top!</p>
                </div>
            </div>
    </div>
    </section>
    <hr class="brinth-divider">
    <?php include 'brinth_footer.php'; ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const tiles = document.querySelectorAll(".game-tile");

            tiles.forEach(tile => {
                tile.addEventListener("click", (e) => {
                    // Collapse all other tiles first
                    tiles.forEach(t => {
                        if (t !== tile) t.classList.remove("expanded");
                    });

                    tile.classList.toggle("expanded");
                });
            });
        });
    </script>
    <script src="Brinth_Index_Script.js" defer></script>

</body>

</html>