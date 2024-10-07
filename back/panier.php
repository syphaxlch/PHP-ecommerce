<!doctype HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title> Site E-commerce </title>
        <link rel="stylesheet" type="text/css" href="../css/navbar.css">
        <link rel="stylesheet" type="text/css" href="../css/panier.css">
        <link rel="icon" type="images/css" href="../../images/logo.png">
        <script type="text/javascript" src="../js/main.js"></script>
    </head>
    <body>
      <?php 
        require 'navbar.php';
        echo '<div class="container">';
        if($_SESSION)
        echo '<div class="text-logo" style="text-align:center"><h1>PANIER</h1></div>';
      ?>
 
        <div class="row">
          <table width="100%" height="100%" border="1 solid black" cellspacing=0>
            <thead>
              <tr>
                <th><strong>Nom</strong></th>
                <th><strong>Prix</strong></th>
                <th><strong>Quantité</strong></th>
                <th><strong>Action</strong></th>
              </tr>
            </thead>
            <tbody>
              <?php
              if($_SESSION){
                $db = Database::connect();
                $statement = $db->query('SELECT panier.id_panier, panier.id_item,panier.quantite
                                          FROM panier
                                          WHERE panier.id_user = '.$_SESSION['id']);
                while($panier = $statement->fetch()){
                  $s = $db->query('SELECT name,price FROM items WHERE id = '.$panier['id_item']);
                  $item = $s->fetch();
                  $id_qte = "qte".(string)$panier['id_panier'];
                  $id_prix = "prix".(string)$panier['id_panier'];
                  $prix = $item['price']*$panier['quantite'];
                  if(!empty($_POST[$id_qte])){
                    $stat = $db->prepare('UPDATE panier SET quantite=? WHERE id_panier=?');
                    $stat->execute([$_POST[$id_qte],$panier['id_panier']]);
                       header('location: panier.php'); 
                  }     
                    echo '<tr>';
                    echo '<td>'.strtoupper($item['name']) . '</td>';
                    echo '<form method="POST" action="" >';
                    echo '<td><p style="color:green">'.number_format((float)$prix,2,"."," ").'DA</p></td>';
                        echo '<td><input id="qte'.$panier['id_panier'].'" name="qte'.$panier['id_panier'].'" type="number" max="4" value="'.$panier['quantite'].'"></td>';
                        echo '<td width="500px">';
                        echo '<a href="commander.php?id='.$panier['id_panier'].'">
                                <button class="btn-commander">&#9787;Commander</button>
                              </a>';
                        echo '<a href="delete.php?id='.$panier['id_panier'].'"><button  class="btn-supprimer"> &#10006; Supprimer</button></a>';
                        echo '</td>';
                        echo '</tr>';
                    echo'</form>';  

                } 

                Database::Disconnect(); 
                
              }    
                ?>  
              </tbody>      
          </table>
        </div>
     </div> 

    </body>
</html>