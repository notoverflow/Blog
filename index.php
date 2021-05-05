<!DOCTYPE html><?php

function triTableau($tableau,$cle,$asc)
{
    $nb=count($tableau);
    echo "taille : ".$nb."<br>";

    $i = 1;
    while ($i < $nb - 1) {
        for ($j=$i+1; $j < $nb; $j++) {
            if (($tableau[$i][$cle]>$tableau[$j][$cle] and $asc)or ($tableau[$i][$cle]<$tableau[$j][$cle] and !$asc)) {
                $ligne = $tableau[$i];
                $tableau[$i] = $tableau[$j];
                $tableau[$j] = $ligne;

            }
        }
        $i++;
    }

    return $tableau;

}
function get_extension($nom)
{
    $nom = explode(".", $nom);
    $nb = count($nom);
    return strtolower($nom[$nb - 1]);
}

function loadImage($nom, $nom_tmp)
{
    $sortie = false;
    $extensions_ok = array('jpg', 'jpeg', 'png');
    $typeimages_ok = array(2, 3);
    $taille_ko = 10000;
    $taille_max = $taille_ko * 3072;
    $dest_dossier = 'Images/'; //nom du dossier ou vous allez stocké vos images
    $dest_fichier = "Images/";

//**************************************
    {
        if ((!in_array(get_extension($nom), $extensions_ok))) {
            return false;
        } else {
//******************************
// on vérifie le poids de l'image
            if (file_exists($nom_tmp) and filesize($nom_tmp) > $taille_max) {
                return false;
            } else {

                $dest_fichier = basename($nom);
                $dest_fichier = strtr($dest_fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
// un chtit regex pour remplacer tous ce qui n'est ni chiffre ni lettre par "_"
                $dest_fichier = preg_replace('/([^.a-z0-9]+)/i', '_', $dest_fichier);
// pour ne pas écraser un fichier existant
                $dossier = $dest_dossier;
                while (file_exists($dossier . $dest_fichier)) {
                    $dest_fichier = rand() . $dest_fichier;

                }
//********************************
                if (move_uploaded_file($nom_tmp, $dossier . $dest_fichier)) {
                    return $dossier.$dest_fichier;
                } else {
                    return false;
                }
            }
        }
    }


    return "ok";
}

?>
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
            <div >
                <a href="index.php?page=nouveau" > <button class ="button button5"> Nouveau message</button></a>

            </div>
            <br>

            <div >
                <a href="index.php?page=Présentation"> <button class ="button button5"> Présentation</button></a>
            </div>
            <br>
            <div >
                <a href="index.php?page=Message&n=1"><button class ="button button5">  Blog</button></a></div>

            <br>

            <div >
                <a href="index.php?page=rechercher"> <button class ="button button5"> rechercher</button></a></div>
        </div>


    </div>
    <div class="center">


        <?php


        if ($_SERVER["REQUEST_METHOD"] == "POST") {

//            on ajoute dans le message.txt
            if ($_POST['ok'] == "OK") {
                $file = fopen("messages.txt", "r");
                while (!feof($file))
                    $messages[] = explode('|', trim(fgets($file)));
                fclose($file);
                $id = intval($messages[count($messages) - 1][0]) + 1;
                $titre = $_POST["Titre"];
                $contenu = str_replace("\r\n", "<br>", $_POST['commentaire']);
                $theme = $_POST['Theme'];
                $auteur = $_POST['pseudo'];
                $motscle = $_POST['motscle'];

                $date = date("d/m/Y") . " à " . date("H:i");

                $logo = $_FILES['image']['name'];
                $logo_tmp = $_FILES['image']['tmp_name'];

                if ($logo != "") {
                    $image = loadImage($logo, $logo_tmp);
                    if ($image == false) {
                        $image = "";
                    }
                } else {
                    $image = "";
                }


                $fp = fopen("messages.txt", "a");
                $savestring = "\n" . $id . "|" . $titre . "|" . $theme . "|" . $contenu . "|" . $image . "|" . $auteur . "|" . $motscle . "|" . $date;
                fwrite($fp, $savestring);
                fclose($fp);

                $theme = "";
                $motscle = "";
                $P = true;

            } else if ($_POST['ok'] == "Chercher") {
                $theme = $_POST['Theme'];
                $motscle = $_POST['motscle'];
            } else if ($_POST['modif'] == "MODIFIER") {

                $id = $_POST['id'];
                $titre = $_POST["Titre"];
                $contenu = str_replace("\r\n", "<br>", $_POST['commentaire']);
                $theme = $_POST['Theme'];
                $auteur = $_POST['pseudo'];
                $motscle = $_POST['motscle'];
                $date = $_POST['date'];
                $nouvdate = date("d/m/Y") . " à " . date("H:i");


                $logo = $_FILES['image']['name'];
                $logo_tmp = $_FILES['image']['tmp_name'];

                if ($logo != "") {
                    $image = loadImage($logo, $logo_tmp);
                    if ($image == false) {
                        $image = "";
                    }
                } else {
                    $image = "";
                }



                $file = fopen("messages.txt", "r");
                while (!feof($file))
                    $messages[] = explode('|', trim(fgets($file)));
                fclose($file);

                $file = fopen("messages.txt", "w");
                for ($i = 1; $i < count($messages); $i++) {
                    if ($messages[$i][0] != $id) {
                        fwrite($file, "\n" . $messages[$i][0] . "|" . $messages[$i][1] . "|" . $messages[$i][2] . "|" . $messages[$i][3] . "|" . $messages[$i][4] . "|" . $messages[$i][5] . "|" . $messages[$i][6] . "|" . $messages[$i][7] . "|" . $messages[$i][8]);

                    } else {
                        $savestring = "\n" . $id . "|" . $titre . "|" . $theme . "|" . $contenu . "|" . $image . "|" . $auteur . "|" . $motscle . "|" . $date . "|" . $nouvdate;
                        fwrite($file, $savestring);

                    }

                }
                fclose($file);


                $theme = "";
                $motscle = "";

            }
            $P = true;

        } else {
            $P = false;
        }

        if ($_GET['page'] == 'supprimer') {

//lectures des messages et mise en place dans un tableau
            $file = fopen("messages.txt", "r");
            $id = $_GET['id'];
            while (!feof($file))
                $messages[] = explode('|', trim(fgets($file)));
            fclose($file);

            $file = fopen("messages.txt", "w");
            for ($i = 1; $i < count($messages); $i++) {
                if ($messages[$i][0] != $id) {
                    fwrite($file, "\n" . $messages[$i][0] . "|" . $messages[$i][1] . "|" . $messages[$i][2] . "|" . $messages[$i][3] . "|" . $messages[$i][4] . "|" . $messages[$i][5] . "|" . $messages[$i][6] . "|" . $messages[$i][7] . "|" . $messages[$i][8]);

                }

            }
            fclose($file);

            $P = true;
        }

        if ($_GET['page'] == 'Message' or $P) {

            if (!$P) {
                $theme = $_GET['theme'];
                $motscle = $_GET['motscle'];

            }

            if ($theme == '' and $motscle == '') {
                $recherche = false;
                $cmp = "";
            } else {

                $recherche = true;
                $cmp = "&theme=" . $theme . "&motscle=" . $motscle;
            }


//lectures des messages et mise en place dans un tableau
            $file = fopen("messages.txt", "r");
            while (!feof($file))
                $messages[] = explode('|', trim(fgets($file)));
            fclose($file);


            if ($recherche) {
                $i = 1;
                while ($i < count($messages)) {

                    if ($theme != "Tous" and $messages[$i][2] != $theme) {
                        unset($messages[$i]);
                        $messages = array_values($messages);
                    } else if (strpos($messages[$i][6], $motscle) === false) {
                        unset($messages[$i]);
                        $messages = array_values($messages);
                    } else {
                        $i++;
                    }
                }
                echo "<h3>Résultat de recherche : </h3>";
            }

//definie les constantes pour la pagination

            $nbrligne = count($messages) - 1;

            if ($nbrligne == 0) {
                echo " <h3>Pas de Résultat  </h3>";
            } else {

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
//                list($id, $titre, $theme, $message , $image, $auteur) = explode("|", $donnees);
                    $id = $messages[$i][0];
                    $titre = $messages[$i][1];
                    $theme = $messages[$i][2];
                    $message = $messages[$i][3];
                    $images = $messages[$i][4];
                    $auteur = $messages[$i][5];
                    $date = $messages[$i][7];
                    $modifier = $messages[$i][8];


                    echo "
			<div class='w3-container'>
			<article>
			<header>
			<h1> $theme </h1>
			</header>
							
			<div class='w3-container w3-card-4'>
			<h3>$titre</h3>
			       <p> $message </p>
			       <img src='$images' style='weight:50px;height:50px'/>
			       <p class='w3-right'> Auteur: $auteur  Publié le $date </p>
			       ";
                    if ($modifier != "") {
                        echo "<p> modifier le $modifier </p>";
                    }
                    echo "
        
			       <br>
			       
			       	<a href='index.php?page=supprimer&id=";
                    echo $id;
                    echo "' > <button class='button button3' >Supprimer </button></a>

			       	<a href='index.php?page=nouveau&id=";
                    echo $id;
                    echo "' > <button class='button button2' >Modifier  </button></a>

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
                            href="index.php?page=Message&n=<?= $currentPage - 1 . $cmp ?>">&laquo;</a>

                    <?php for ($page = 1; $page <= $nbrpage; $page++): ?>
                        <a <?php if ($page == $currentPage) echo 'class="active"' ?>
                                href="index.php?page=Message&n=<?= $page . $cmp ?> >"> <?= $page ?></a>
                    <?php endfor ?>

                    <a <?php if ($currentPage == $nbrpage) echo 'style="display:none"' ?>
                            href="index.php?page=Message&n=<?= $currentPage + 1 . $cmp ?>">&raquo;</a>

                </div>


                <?php
            }
            //todo rajouter images
        } //        ajout de message
        else if ($_GET['page'] == 'nouveau') {


            ?>

            <div class="w3-container w3-card">

                <pre>


                </pre>
                <?php

                $id = $_GET['id'];

                if ($id != "") {
                    echo " <h3>Modification de messages</h3>";
                    $file = fopen("messages.txt", "r");
                    while (!feof($file))
                        $messages[] = explode('|', trim(fgets($file)));
                    fclose($file);
                    for ($i = 1; $i < count($messages); $i++) {
                        if ($messages[$i][0] == $id) {
                            $titre = $messages[$i][1];
                            $theme = $messages[$i][2];
                            $message = $messages[$i][3];
                            $images = $messages[$i][4];
                            $auteur = $messages[$i][5];
                            $motscle = $messages[$i][6];
                            $date = $messages[$i][7];
                            $message = str_replace("<br>", "\r\n", $message);

                        }

                    }

                } else {
                    echo " <h3>Nouveau messages : </h3>";
                }

                ?>

                <pre>



                </pre>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w3-container" id="new"
                      enctype="multipart/form-data">

                    <?php

                    if ($id != "") {

                        ?>
                        <p>
                            <label for="id" class="w3-text-teal">Id du message : </label>
                            <input type="text" name="id" class="w3-select" readonly="true" value="<?= $id ?>">
                            <label for="date" class="w3-text-teal">date de création : </label>
                            <input type="text" name="date" class="w3-select" readonly="true" value="<?= $date ?>">

                        </p>


                        <?php
                    }

                    ?>
                    <p>

                        <label for="Theme" class="w3-text-teal">Theme</label>
                        <select name="Theme" id="Theme" class="w3-select">
                            <option value="Informatique" <?php if ($theme == "Informatique") echo 'selected'; ?> >
                                Informatique
                            </option>
                            <option value="Musique" <?php if ($theme == "Musique") echo 'selected'; ?> >
                                Musique
                            </option>
                            <option value="Cuisine" <?php if ($theme == "Cuisine") echo 'selected'; ?> >
                                Cuisine
                            </option>

                        </select>
                    </p>

                    <p>

                        <label for="Titre" class="w3-text-teal">Titre</label>
                        <input type="text" name="Titre" id="Titre" class="w3-input"
                               value="<?php echo $titre ?>"
                    </p>
                    <p>
                        <label for="pseudo" class="w3-text-teal">pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" class="w3-input"
                               value="<?php echo $auteur ?>"
                    </p>

                    <p>
                        <label for="motscle" class="w3-text-teal">Mots clé : </label>
                        <input type="text" name="motscle" id="motscle" class="w3-input"
                               value="<?php echo $motscle ?>"/>

                    </p>

                    <p>
                        <label for="image" class="w3-text-teal">Image : </label>
                        <input type="file" name="image" id="photo"/>
                    </p>
                    <p>
                        <label for="commentaire" class="w3-text-teal">commentaire</label>
                        <textarea name="commentaire" id="commentaire" class="w3-input" rows="5" cols="33"
                        ><?= $message ?></textarea>

                    </p>
                    <p>

                        <?php

                        if ($id == "") {
                            ?>
                            <input type="submit" value="OK" name="ok">
                            <?php
                        } else {
                            ?>
                            <input type="submit" value="MODIFIER" name="modif">
                            <?php
                        }
                        ?>

                </form>

            </div>

            </p>
            <?php


        } //        recherche
        else if ($_GET['page'] == 'rechercher') {

            ?>


            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="w3-container" id="recherche">

                <p>

                    <label for="Theme" class="w3-text-teal">Theme</label>
                    <select name="Theme" id="Theme" class="w3-select">
                        <option value="Tous" <?php if ((isset($POST['Theme']) && $_POST['Theme'] == '')) echo 'selected'; ?> >
                            Tous
                        </option>
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
                    <label for="motscle" class="w3-text-teal">Mots clé : </label>
                    <input type="text" name="motscle" id="motscle" class="w3-input"
                           value="<?php if (isset($_POST['motscle'])) echo $_POST['motscle']; else echo '' ?>"/>

                </p>

                <p>
                    <input type="submit" value="Chercher" name="ok">

                </p>


            </form>


            <?php


        } else //        affichage par default
        {

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

?>