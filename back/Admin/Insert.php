<?php 
    session_start();
    require '../Database.php';
    $nameError = $descriptionError = $priceError = $QdispError =$categoryError= $imageError = $name = $description = $price =$category= $image =""; 
    if($_POST){
        $name = checkinput( $_POST['name']);
        $description = checkinput( $_POST['description']);
        $price = checkinput( $_POST['price']);
        $category = checkinput( $_POST['category']);
        $image = checkinput( $_FILES['image']['name']);
        $imagePath = '../../images/'.basename($image);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $Qdisp = checkinput( $_POST['Qdisp']); 
        $isSucees = true;
        $isUploadSucces = false;
        if(empty($name)){
            $nameError = 'Ce champ ne peut pas etre vide.';
            $isSucees = false;
        }
        if(empty($description)){
            $descriptionError = 'Ce champ ne peut pas etre vide.';
            $isSucees = false;
        }
        if(empty($price)){
            $priceError = 'Ce champ ne peut pas etre vide.';
            $isSucees = false;
        }
        if(empty($Qdisp)){
            $QdispError = 'Ce champ ne peut pas etre vide.';
            $isSucees = false;
        }
        if(empty($category)){
            $priceError = 'Ce champ ne peut pas etre vide.';
            $isSucees = false;
        }
        if(empty($image)){
            $imageError = 'Ce champ ne peut pas etre vide.';
            $isSucees = false;
        }
        else{
            $isUploadSucces = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
            {
                $imageError = "Les fichiers autorisés sont : .jpg, .png, .jpeg, .gif";
                $isUploadSucces = false;
            }
            if($_FILES["image"]["size"]> 1000000){
                $imageError = "Le fichier ne doit pas depasser 1Mo.";
                $isUploadSucces = false;
            }
            if(file_exists($imagePath)){
                $imageError = "Ce fichier existe déja.";
                $isUploadSucces = false;
            }
            if($isUploadSucces){
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)){
                    $imageError = "Il y a eu une erreur lors de l'upload.";
                    $isUploadSucces = false; 
                }
            }
        }
        if($isSucees && $isUploadSucces){
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (name,description,price,category,image,Qdisp) values(?,?,?,?,?,?)");
            $statement->execute(array($name,$description,$price,$category,$image,$Qdisp));
            Database::disconnect();
        }
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
        <link rel="stylesheet" type="text/css" href="../../css/admin-insert.css" >
        <link rel="icon" type="images/css" href="../../images/logo.png">
        <title> Ajouter un produit </title>
    </head>   
    <body> 
    <div class="contenu" style="display:<?php if($_SESSION)if($_SESSION['id_admin']) echo'block';else echo'none'  ?>" >     
        <div class="text-logo"><h1>ADMIN</h1></div>
        <div class="container">
        <div class="row">
                <h1> Ajouter un produit </h1>
                <form action="insert.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name"> <strong>Nom  : </strong></label> 
                        <input type="text" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                        <span class="help-inline"><?php echo $nameError; ?></span>    
                    </div>
                    <div class="form-group">
                        <label for="description"> <strong>Description : </strong></label> 
                        <input type="text" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                        <span class="help-inline"><?php echo $descriptionError; ?></span>    
                    </div>
                    <div class="form-group">
                        <label for="price"> <strong>Prix (€) : </strong></label> 
                        <input type="number" step="0.01" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                        <span class="help-inline"><?php echo $priceError; ?></span>    
                    </div>
                        <div class="form-group">
                        <label for="price"> <strong>Quantité : </strong></label> 
                        <input type="number" id="Qdisp" name="Qdisp" placeholder="Quantité" value="<?php echo $Qdisp; ?>">
                        <span class="help-inline"><?php echo $QdispError; ?></span>    
                    </div>
                    <div class="form-group">
                        <label for="Category"> <strong>Category : </strong></label> 
                        <select class="select" id="category" name="category" >
                            <?php
                            $db = Database::connect();
                            foreach($db->query('SELECT  * FROM categories') AS $row){
                                    echo '<option value="'.$row['id'].'"> '.$row['name']. '</option>'; 
                            }
                            Database::disconnect();
                            ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>    
                    </div>
                    <div class="form-group">
                        <label for="image"> <strong>Selection une image : </strong></label> 
                        <input type="file" id="image" name="image">
                        <span class="help-inline"><?php echo $imageError; ?></span>    
                    </div> 
                    <button type="submit" class="btn-ajouter"> &#9997; Ajouter</button></a>
                    <a href="admin.php" class="btn-retour"> &#10149; Retour</a>  
                </form> 
        
            </div> 
        </div>  
    </div>
    <?php if(($_SESSION) && (!$_SESSION['id_admin'])) echo '<h2 > Vous n\'avez pas accées a cette page.  </h2>'  ?> 
</body>
</html>                        