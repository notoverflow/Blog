<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="style.css"/>
</head>
<body>

<div class="header">
    <h2>Blog Name</h2>
</div>

<div class="row">
    <div class="leftcolumn">

        <div class="card">
            <div class="fakeimg">
                <a href="index.php?page=nouveau"> Nouveau message</a>

            </div>
            <br>

            <div class="fakeimg">
                <a href="index.php?page=Présentation"> Présentation</a>
            </div>
            <br>
            <div class="fakeimg">
                <a href="index.php?page=Message"> Blog</a></div>

            <br>

            <div class="fakeimg">
                <a href="index.php?page=rechercher"> rechercher</a></div>
        </div>


    </div>
    <div class="center">

        <?php

        if ($_GET['page'] == 'Message') { ?>


            <div id="message">

                <div class="card">
                    <h2>TITLE HEADING</h2>
                    <h5>Title description, Dec 7, 2017</h5>
                    <p>Some text..</p>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit,
                        sed do
                        eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation
                        ullamco.</p>
                </div>
                <div class="card">
                    <h2>TITLE HEADING</h2>
                    <h5>Title description, Sep 2, 2017</h5>
                    <p>Some text..</p>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit,
                        sed do
                        eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation
                        ullamco.</p>
                </div>
            </div>
            <?php
        } else if ($_GET['page'] == 'nouveau') {

        } else if ($_GET['page'] == 'rechercher') {

        } else {

            ?>

            <div class="card">

                <h3 style="text-align: center">Blog de L1</h3>
                <p>ceci un un projet universitaire, qui consiste à faire un mini blog, voici ma version :) </p>


            </div>

            <?php

        }
        ?>


    </div>
</div>

<div class="footer">
    <?php
    include("pied.php");
    ?>
</div>

</body>
</html>
