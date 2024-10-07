<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/prod.css" >
        <link rel="stylesheet" type="text/css" href="../css/navbar.css" >
        <title>Accessoires</title>
        <link rel="icon" type="images/css" href="../images/logo.png">
    </head>
    <body>
    <?php     require("navbar.php");
        $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
        $statement->execute(array(4));
        echo '<div class="row">' ; 
                foreach($statement as $item){
                    echo '  <div class="colon">    
                                <div class="image">
                                    <img src="../images/'.$item['image'].'">
                                </div>    
                                <div class="text" style="display: block; width: 100%;">
                                    <h1>'.$item['price'].'DA</h1>
                                    <h2>'.$item['name'].'</h2> 
                                    <p class="descriptif" >Descriptif : </p>
                                    <strong>'.$item['description'].'</strong>
                                    <br>
                                </div> 
                            </div>'; 
            }
                echo'</div>';
            Database::disconnect();
        ?>


</body>
</html>