<?php 
    session_start();
     require '../Database.php';
     if(!empty($_GET['id'])){
         $id = checkinput($_GET['id']);
     }
    $db = Database::connect();
    $statement = $db->prepare('SELECT items.id, items.name, items.description,items.image, items.price, categories.name As category
                              FROM items LEFT JOIN categories ON items.category = categories.id
                              WHERE items.id = ? ');
    $statement->execute(array($id));
    $item = $statement->fetch();
    Database::Disconnect();
    function checkinput($data){
        $data = trim($data); 
        $data = stripslashes($data); 
        $data = htmlspecialchars($data);
        return $data; 
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/admin-view.css" >
        <link rel="icon" type="images/css" href="images/logo.png">
    </head>   
    <body> 
    <div class="contenu" style="display:<?php if($_SESSION)if($_SESSION['id_admin']) echo'block';else echo'none'  ?>" >  
        <div class="text-logo"><h1>ADMIN</h1></div>
        <div class="row">
            <div class="colon">  
                <div class="text">
                    <div style="display: block; width: 100%;">
                        <form action="">
                            <h1> Voir un produit </h1>
                            <p><label> <strong>Nom  : </strong></label> <?php echo ' '.$item['name']; ?></p>
                            <p><label><strong>Prix : </strong></label><?php echo ' '.number_format((float)$item['price'],2,"."," "). 'DA'; ?></p> 
                            <p><label><strong>Description  : </strong></label> <?php echo ' '.$item['description']; ?></p>
                            <p><label><strong>Category  : </strong></label> <?php echo ' '.$item['category']; ?></p> 
                        </form>  
                        <a href="admin.php"><button  class="btn-retour"> &#10149; Retour</button></a>            
                    </div> 
                    <img src="<?php echo '../../images/'.$item['image'] ;?>">
                </div> 
            </div> 
        </div>  
    </div> 
    <?php if(($_SESSION) && (!$_SESSION['id_admin'])) echo '<h2 > Vous n\'avez pas accées a cette page.  </h2>'  ?> 
</body>
</html>                        