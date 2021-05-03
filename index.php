<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="style.css"/>

</head>
<body>

<div class="header">
    <h2>Le blog de noto :')</h2>
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
                <a href="index.php?page=Message&n=1"> Blog</a></div>

            <br>

            <div class="fakeimg">
                <a href="index.php?page=rechercher"> rechercher</a></div>
        </div>


    </div>
    <div class="center">

        <?php


        if ($_SERVER["REQUEST_METHOD"] == "POST") {

//            on ajoute dans le message.txt


            $titre = $_POST["Titre"];
            $contenu = $_POST['commentaire'];
            $theme = $_POST['Theme'];
            $image = $_POST['image'];
            $auteur = $_POST['pseudo'];
//            todo rajouter l'images dans le formulaire et les mots clé
            $contenu = str_replace("\r\n", "<br>", $_POST['commentaire']);
            $fp = fopen("messages.txt", "a");
            $savestring = "\n" . $titre . "|" . $theme . "|" . $contenu . "|" . $image . "|" . $auteur;
            fwrite($fp, $savestring);
            fclose($fp);
            $P = true;

        } else {
            $P = false;
        }

        if ($_GET['page'] == 'suprimmer') {
//            todo suprimmer le message
            $P = true;
        }

        if ($_GET['page'] == 'Message' or $P) {

//lectures des messages et mise en place dans un tableau
            $file = fopen("messages.txt", "r");
            while (!feof($file))
                $messages[] = explode('|', trim(fgets($file)));
            fclose($file);

//definie les constantes pour la pagination

            $nbrligne = count($messages) - 1;
            $nbparpage = 4;
            $nbrpage = ceil($nbrligne / $nbparpage);

//            recupere la page courante
            if (isset($_GET['n']) && !empty($_GET['n'])) {
                $currentPage = (int)strip_tags($_GET['n']);
            } else {
                $currentPage = $nbrpage;
            }
            $premier = ($currentPage * $nbparpage) - $nbparpage + 1;
            $dernier = $premier + $nbparpage - 1;
            if ($dernier > $nbrligne) {
                $dernier = $nbrligne;
            }


            for ($i = $premier; $i <= $dernier; $i++) {
//                list($titre, $theme, $message, $image, $auteur) = explode("|", $donnees);
                $titre = $messages[$i][0];
                $theme = $messages[$i][1];
                $message = $messages[$i][2];
                $images = $messages[$i][3];
                $auteur = $messages[$i][4];
                $jour = date("d-m-Y");
                $heure = date("H:i");
//todo changer position id
                $id = 1;



                
                echo "
			<div class='w3-container'>
			<article>
			<header>
			<h1> $theme </h1>
			</header>
							
			<div class='w3-container w3-card-4'>
			<h3>$titre</h3>
			       <p> $message </p>
			       <img src='$image' style='weight:50px;height:50px'/>
			       <p class='w3-right'> Auteur: $auteur  Publié le $jour à $heure </p>
			       <br>
			       
			       			      <a href='index.php?page=suprimmer&id=";echo $id; echo "' > <button class='button button3' >Suprimmer </button></a>

			       <br>
			       
			       
			       
			       
			</div>
		
			      
			</article>
			</div>
			<hr>
			"; ?>


                <?php

            }
            ?>


            <div class="pagination">
                <a <?php if ($currentPage == 1) echo 'style="display:none"' ?>
                        href="index.php?page=Message&n=<?= $currentPage - 1 ?>">&laquo;</a>

                <?php for ($page = 1; $page <= $nbrpage; $page++): ?>
                    <a <?php if ($page == $currentPage) echo 'class="active"' ?>
                            href="index.php?page=Message&n=<?= $page ?> >"> <?= $page ?></a>
                <?php endfor ?>

                <a <?php if ($currentPage == $nbrpage) echo 'style="display:none"' ?>
                        href="index.php?page=Message&n=<?= $currentPage + 1 ?>">&raquo;</a>

            </div>


            <?php

        } else if ($_GET['page'] == 'nouveau') {


            ?>

            <div class="w3-container w3-card">

                <pre>


                </pre>
                <h3>Nouveau messages : </h3>
                <pre>



                </pre>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w3-container" id="new">

                    <p>

                        <label for="Theme" class="w3-text-teal">Theme</label>
                        <select name="Theme" id="Theme" class="w3-select">
                            <option value="Informatique" <?php if ((isset($POST['Theme']) && $_POST['Theme'] == '')) echo 'selected'; ?> >
                                Informatique
                            </option>
                            <option value="Musique" <?php if ((isset($POST['Theme']) && $_POST['Theme'] == '')) echo 'selected'; ?> >
                                Musique
                            </option>
                            <option value="Cuisine" <?php if ((isset($POST['Theme']) && $_POST['Theme'] == '')) echo 'selected'; ?> >
                                Cuisine
                            </option>

                        </select>
                    </p>

                    <p>

                        <label for="Titre" class="w3-text-teal">Titre</label>
                        <input type="text" name="Titre" id="Titre" class="w3-input"
                               value="<?php if (isset($_POST['Titre'])) echo $_POST['Titre']; else echo '' ?>"
                    </p>
                    <p>
                        <label for="pseudo" class="w3-text-teal">pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" class="w3-input"
                               value="<?php if (isset($_POST['pseudo'])) echo $_POST['pseudo']; else echo '' ?>"
                    </p>
                    <p>
                        <label for="commentaire" class="w3-text-teal">commentaire</label>
                        <textarea name="commentaire" id="commentaire" class="w3-input" rows="5" cols="33"
                                  value="<?php if (isset($_POST['commentaire'])) echo $_POST['commentaire']; else echo '' ?>"></textarea>

                    </p>


                    <p>
                        <input type="submit" value="OK" name="ok">

                    </p>


                </form>

            </div>


            <?php


            //    todo ici on mets messages d'erreur/ commentaire ajouter


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

<?php

function welcome()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        $text = "Bonjour " . " " . $_POST["pseudo"] . " " . $_POST["commentaire"] . " ,vous avez " . ".";

        return $text;
    }
}

?>