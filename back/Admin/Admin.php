<?php
require '../database.php'; 
session_start();
?>
<!doctype HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title> Site E-commerce </title>
        <link rel="stylesheet" type="text/css" href="../../css/Admin.css">
        <link rel="icon" type="images/css" href="../../images/logo.png">
    </head>
      <body>
      <div class="contenu" style="display:<?php if($_SESSION)if($_SESSION['id_admin']) echo'block';else echo'none'  ?>" > 
        <div class="text-logo"><h1>ADMIN</h1></div>
        <?php 
              if($_SESSION)
              echo '<div class="text-logo"><h1>Bonjour '.$_SESSION['Firstname'].'</h1></div>';
        ?>
        <div class="container">
            <div class="row">
                <h1><strong> Liste des produits </strong> <a href="insert.php"><button class="btn-ajouter"> &#10010; Ajouter</button></a> 
                <?php if($_SESSION) echo '<a href="deconnexion_admin.php"><button class="btn-deconnexion">Deconnecter</button></a>';else echo '<a href="../../index.php"><button class="btn-acceuil">Acceuil</button></a>' ?> </h1> 
                <table width="100%" height="100%" border="1 solid black" cellspacing=0>
                   <thead>
                         <tr>
                             <th><strong>Nom</strong></th>
                             <th><strong>Description</strong></th>
                             <th><strong>Prix</strong></th>
                             <th><strong>Categories</strong></th>
                             <th><strong>Action</strong></th>
                         </tr>
                    </thead>
                    <tbody>  
                    <?php

                      $db = Database::connect();
                      $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name As category
                                               FROM items LEFT JOIN categories ON items.category = categories.id
                                                ORDER BY items.id DESC');
                      while($item = $statement->fetch()){
                        echo '<tr>';
                        echo '<td>'.$item['name'] . '</td>';
                        echo '<td>' .$item['description']. '</td>';
                        echo '<td>' .number_format((float)$item['price'],2,"."," ").'DA</td>';
                        echo '<td>'.$item['category'].'</td>';
                        echo '<td width="600px">';
                        echo '<a href=" view.php?id='.$item['id'].' "><button  class="btn-voir">&#9787; Voir</button></a>';
                        echo '<a href="update.php?id='.$item['id'].'"><button  class="btn-modifier"> &#9998; Modifier</button></a>';
                        echo '<a href="delete.php?id='.$item['id'].'"><button  class="btn-supprimer"> &#10006; Supprimer</button></a>';
                        
                        echo '</td>';
                        echo '</tr>';
                      } 
                    Database::Disconnect();                  
                      ?>  
                        </tbody>      
                </table>
            </div>
        </div>
     </div> 
    <?php if(($_SESSION) && (!$_SESSION['id_admin'])) echo '<h2 > Vous n\'avez pas accées a cette page.  </h2>';  ?> 
    </body>
</html>