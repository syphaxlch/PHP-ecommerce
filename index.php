<?php 
    require 'back/Database.php';
    session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">        
        <title> Kooseyl phone </title>
        <link rel="stylesheet" type="text/css" href="css/acceuil.css">
        <meta name="viewport" content="width=device-width, initia-scale=1">
        <link rel="icon" type="images/css" href="images/logo.png">
    </head>
    <style>
    .nav-text{
       <?php if($_SESSION)
                echo 'width: 14.8%;';
                else
                    echo 'width: 18.5%;';
        ?>
        }
    </style>
    <body>
    <div class="contenu">  
            <div class="collonne1">
                <div class="nav" >
                    <?php 
                        echo '<header>
                            <ul> ';
                        $db = Database::connect();
                        $statement = $db->query('SELECT * FROM categories');
                        $categories = $statement->fetchAll();
                        echo '<li class="logo"><img src="images/logo.png">  Kooseyl phone  </li>';
                        foreach($categories as $category){
                            if($category['id'] == '1'){
                                echo '<li class="nav-text"><a href="index.php">'.$category['name'].'</a></li>';
                            }
                            else{
                                if($category['id'] == '2') {
                                echo '<li class="nav-text"><a href="#">Nos produits</a><ul>';
                                }
                                echo '<li class="nav-text"><a href="back/'.$category['name'].'.php">'.$category['name'].'</a> </li>';
                            }
                        }  
                        echo'</ul>
                            </li>';
                            echo '<li class="nav-text"><a href="back/about.php"> A propos </a></li>';
                            if($_SESSION)
                                echo'<li class="nav-text"><a href="back/panier.php"><img src="images/panier.png"> Panier</a></li>
                                     <li class="nav-text"><a href="back/deconnexion.php">Deconnexion</a></li>';         
                            else 
                                echo '<li class="nav-text"><a href="back/connexion.php">Connexion</a></li>';
                        echo '

                        </ul> 

                        </header> 
                </div>
                <div class="head">';
                if($_SESSION)
                echo 'Bienvenue '.Strtoupper($_SESSION['Firstname']); 
                else  echo 'Veuillez vous connecter ou vous inscrire pour decouvrir nos produits';
                   
       echo '</div>  
        </div> 
        <div class="collonne2">     
            <div class="nouveau">
                    <span> Les nouveautés </span>
            </div>
            <div class="row"> ';
            $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
            $statement->execute(array(1));
            while ($item = $statement->fetch()){       
            echo ' <div class="colon">        
                        <img src="images/'.$item['image'].'">
                            <strong> '.$item['name'].' </strong> 
                            <br>
                            '.$item['description'].'
                        <br>
                        <h1> '.$item['price'].'DA</h1>
                        <br>
                        <p><a href="back/addpanier.php?id_item='.$item['id'].'">Ajouter au panier</a></p>
                        <br>
                    </div>';
            }
            Database::disconnect();
            ?> 
        </div>
        </div>
        <footer >
            <div class=footer_container>
                <div class="footer_horaire">
                    <h3>Horaires :</h3>
                    <p>✅ Sam: 10h-19h</p>
                    <p>✅ Dim: 8h-19h</p>
                    <p>✅ Lun: 8h-19h</p>
                    <p>✅ Mar: 8h-19h</p>
                    <p>✅ Mer: 8h-19h</p>
                    <p>✅ Jeu: 8h-19h</p>
                    <p>❌ Ven: Fermé</p>
                </div>
                <div class="footer_media">
                    <h3>Nos reseaux :</h3>
                    <p><a href="http://www.facebook.com/kooseylphone/" target="_blank">Facebook</a></p>
                    <p><a href="http://www.instagram.com/kooseylphone/" target="_blank">Instagram</a></p>
                </div>
                <div class="footer_services :">
                    <h3>Nos services :</h3>
                    <p>Smartphones</p>
                    <p>Ordinateurs</p>
                    <p>Accessoires</p>
                </div>
            </div> 
            <div class="copyright">
                <p>©2022 Copyright - Tous droits réservés</p>
            </div>   
        </footer>
    </div>
</body>
</html>
