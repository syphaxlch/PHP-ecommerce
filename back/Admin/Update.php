<?php 
    session_start();
    require '../Database.php';
    if(!empty($_GET['id'])){
        $id = checkinput($_GET['id']);
    }
    $nameError = $QdispError=$descriptionError = $priceError = $categoryError= $imageError = $name = $description = $price =$category= $image =""; 
    if(!empty($_POST)){
        $name = checkinput( $_POST['name']);
        $description = checkinput( $_POST['description']);
        $price = checkinput( $_POST['price']);
        $Qdisp = checkinput( $_POST['Qdisp']);
        $category = checkinput( $_POST['category']);
        $image = checkinput( $_FILES['image']['name']);
        $imagePath = '../../images/'.basename($image);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
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
            $isImageUpdated = false;
        }
        else{
            $isImageUpdated = true;
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
        if(($isSucees && $isUploadSucces && $isImageUpdated) || ($isSucees && !$isImageUpdated) ){
            $db = Database::connect();
            if($isImageUpdated){
                $statement = $db->prepare("Update items SET name= ?,description= ?,price= ?,category= ?,image= ? WHERE id= ? ");
                $statement->execute(array($name,$description,$price,$category,$image,$id));
            }
            else{
                $statement = $db->prepare("Update items SET name= ?,description= ?,price= ?,Qdisp= ?,category= ? WHERE id= ? ");
                $statement->execute(array($name,$description,$price,$Qdisp,$category,$id));
            }
            Database::disconnect();
            header("location: admin.php");  
        }
        else if($isImageUpdated && !$isUploadSucces){
            $db = Database::connect();
            $statement =$db->prepare("SELECT image FROM items WHERE id = ? ");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image = $item['image'];
            Database::disconnect();   

        }
    }
    else{
        $db = Database::connect();
        $statement =$db->prepare("SELECT * FROM items WHERE id = ? ");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name = $item['name'];
        $description = $item['description'];
        $price = $item['price'];
        $Qdisp = $item['Qdisp'];
        $category = $item['category'];
        $image = $item['image'];
        Database::disconnect();  
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
        <link rel="stylesheet" type="text/css" href="../../css/admin-update.css" >
        <link rel="icon" type="images/css" href="images/logo.png">
    </head>   
    <body> 
    <div class="contenu" style="display:<?php if($_SESSION)if($_SESSION['id_admin']) echo'block';else echo'none'  ?>" >   
        <div class="text-logo"><h1>ADMIN</h1></div>
        <div class="container">
        <div class="row">
                <div class="coln1">  
                    <h1> Modifier un produit </h1>  
                    <br>
                    <form action="<?php  echo 'update.php?id='.$id ; ?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name"> <strong>Nom : </strong></label> 
                            <input type="text" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                            <span class="help-inline"><?php echo $nameError; ?></span>    
                        </div>
                        <div class="form-group">
                            <label for="description"> <strong>Description : </strong></label> 
                            <input type="text" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                            <span class="help-inline"><?php echo $descriptionError; ?></span>    
                        </div>
                        <div class="form-group">
                            <label for="price"> <strong>Prix (DA) : </strong></label> 
                            <input type="number" step="0.01" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                            <span class="help-inline"><?php echo $priceError; ?></span>    
                        </div>      
                        <div class="form-group">
                            <label for="Category"> <strong>Category : </strong></label> 
                            <br>
                            <br>
                            <select class="select" id="category" name="category" >
                                <?php
                                    $db = Database::connect();
                                    foreach($db->query('SELECT  * FROM categories') as $row){
                                        if($row['id'] == $category)
                                            echo '<option selected="selected" value="'.$row['id'].'"> '.$row['name']. '</option>';  
                                        else
                                            echo '<option value="'.$row['id'].'"> '.$row['name']. '</option>';
                                        }
                                
                                Database::disconnect();
                                ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError; ?></span>    
                        </div>
                    
                        <div class="form-group">
                            <label> <Strong>Image : </strong></label>
                            <?php  echo $image; ?>
                            <br>
                            <label for="image"> <strong>Selection une image : </strong></label> 
                            <input type="file" id="image" name="image">
                            <span  class="help-inline"><?php echo $imageError; ?></span>    
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-modifier"> &#9997; Modifier</button></a>  
                            <a href="admin.php" class="btn-retour"> &#10149; Retour</a>
                        </div>  
                    </form>
                
                </div> 
                <div class="coln2">
                <img  src="<?php echo '../../images/' . $image ; ?>">
                </div>           
            </div> 
        </div>    
    </div>
    <?php if(($_SESSION) && (!$_SESSION['id_admin'])) echo '<h2 > Vous n\'avez pas accées a cette page.  </h2>'  ?> 
</body>
</html>                        