        <div class="collonne1">
    <div class="nav">
        <?php 
            require("database.php");
            session_start();
            echo '<style>
        .nav-text{';
        if($_SESSION)
                echo 'width: 14.8%;';
                else
                    echo 'width: 18.5%;';
            echo '}</style>';
            echo '<header>
                        <ul> 
                            <li class="logo"><img src="../images/logo.png">  Kooseyl phone  </li>';
            $db = Database::connect();
            $statement = $db->query('SELECT * FROM categories');
            $categories = $statement->fetchAll();
            foreach($categories as $category){
                if($category['id'] == '1'){  
                    echo '<li class="nav-text"><a href="../index.php">'.$category['name'].'</a> </li>';   
                }
                else{
                    if($category['id'] == '2') {
                    echo '<li class="nav-text"><a>Nos produits</a>
                           <ul>';
                    }
                    echo '<li class="nav-text"><a href="'.$category['name'].'.php">'.$category['name'].'</a> </li>';
                }
            }
            echo '</ul>
            <li class="nav-text"><a href="about.php"> A propos </a></li>';
            if($_SESSION)
            echo '<li class="nav-text"><a href="panier.php"><img src="../images/panier.png"> Panier </a></li>
                  <li class="nav-text"><a href="deconnexion.php">Deconnexion </a></li>';         
            else 
                echo '<li class="nav-text"><a href="connexion.php">Connexion</a></li>';      
            echo '</ul>
            </header> 
    </div> ';                
        ?>
