<?php
    require ("../database.php");
    $Firstname = $email = $password = "";
    $emailError = $passwordError = $connexionError = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email =  verifyinput($_POST['email']);
        if($_POST['password'])
        $password =  $_POST['password'];
        $isSucces = TRUE;
        if(!isEmail($email)){
            $emailError = "Veuillez saisir votre email !";
            $isSucces = FALSE;
        }    
        if(empty($password)){
            $passwordError = "Le mot de pass est incorrecte !";
            $isSucces = FALSE;
        }   
        if($isSucces){
            $db = database::connect();
            $user = $db->prepare("SELECT * FROM admins WHERE email = ?");
            $user->execute(array($email));
            $userinfo = $user->fetch(); 
            $userexist = $user->rowCount();
            if($userexist == 1){
                $hash = $userinfo['password'];
                $id_admin = $userinfo['id_admin'];
                $Firstname = $userinfo['Firstname'];
                
            if(password_verify($password,$hash)){   
                $_SESSION['id_admin'] = $userinfo['id_admin'];
                $_SESSION['email'] = $userinfo['email'];
                $_SESSION['password'] = $userinfo['password'];
                $_SESSION['Firstname'] = $userinfo['Firstname'];
                   header("location: admin.php");
            } else
            $connexionError = "Il y a aucun compte correspondant a vos informations";
        }
    }

    }
    function isEmail($var){
         return filter_var($var, FILTER_VALIDATE_EMAIL);

    }
    function verifyinput($var){
        $var = trim($var);
        $var = stripcslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }
    function login(): bool {
        if(!session_id()){
            session_start();
            session_regenerate_id();
            return true;
        }
        else 
            return false;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../css/connexion.css">
        <link rel="icon" type="images/css" href="../images/logo.png">
    </head>
    <body style="display:<?php if($_SESSION) echo'none'?>"> 
        <div class="container">
            <form  method="POST" action="authenadmin.php">
                <div class="imagesprofil">
                    <img src="../../images/profil.png"> 
                </div>
                <div class="contenu">
                    <h2 style="text-align:center; color:red">ADMIN</h2>
                    <div class="coln">
                        <label for="utilisateur">Email :</label>
                        <input id="utilisateur" class="zonetxt" name="email" type="text" placeholder="Votre Email">
                        <p class="comments"><?php  echo $emailError; ?></p>
                    </div>
                   
                    <div class="coln">
                        <label for="mdp">Mot de pass :</label>
                        <input id="mdp" class="zonetxt" type="password" name="password" placeholder="Votre mot de pass">
                        <p class="comments"><?php  echo $passwordError; ?></p>
                    </div>
                    <div class="valide" style="display:<?php if($connexionError =="")echo 'none';else echo 'block'; ?>"><?php echo $connexionError ?> </div>
                    <div class="coln-connexion">
                        <button type="submit" class="btn-connexion" name="connexion">Connexion</button> 
                        <a class="btn-inscription" href="inscadmin.php">Créer un compte</a>         
                    </div>      
                </div>
            </form>
        </div> 
    </body>
</html>