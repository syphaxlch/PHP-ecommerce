<?php 
    session_start();
    require '../Database.php';
    if (!empty($_GET['id'])){
        $id = checkinput($_GET['id']);
    }
    if (!empty($_POST)){
        $id = checkinput($_POST['id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM items WHERE id = ?") ; 
        $statement->execute(array($id));
        Database::disconnect();  
        header("Location: admin.php");
    }
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
        <title> Supprimer un produit</title>
        <link rel="stylesheet" type="text/css" href="../../css/admin-Delete.css" >
        <link rel="icon" type="images/css" href="images/logo.png">
    </head>   
    <body> 
    <div class="contenu" style="display:<?php if($_SESSION)if($_SESSION['id_admin']) echo'block';else echo'none'  ?>" >         
        <div class="text-logo"><h1>ADMIN</h1></div>
        <div class="container">
            <div class="row">
                <h1> Supprimer un produit </h1>
                <form action="Delete.php" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id ; ?>"> 
                    <div class="form-group">
                        <p>Etes vous sur de vouloir supprimer ? </p>
                    </div>              
                    <button type="submit" class="btn-Oui">Oui</button></a>
                    <a href="admin.php" class="btn-Non">Non</a>  
                </form> 
            
            </div> 
        </div> 
    </div>      
    <?php if(($_SESSION) && (!$_SESSION['id_admin'])) echo '<h2 > Vous n\'avez pas accées a cette page.  </h2>'  ?>   
</body>
</html>                        