<?php 
require ("../database.php");
$firstname = $name = $email = $password = $rpassword ="";
$FirstError = $NameError = $EmailError = $passwordError = $rpasswordError = "";
$isSucces = FALSE;
if($_POST){
    $firstname =  verifyinput($_POST["firstname"]);
    $name =  verifyinput($_POST['name']);
    $email =  verifyinput($_POST['email']);
    $password =  $_POST['password'];
    $rpassword =  $_POST['rpassword'];
    $isSucces = true;
    if(!isname($firstname)){
        $FirstError = "Votre prénom doit avoir de l'alphabêt uniquement.";
        $isSucces = FALSE;
    }
    if(!isname($name)  || empty($name)){
        $NameError = "Votre nom doit avoir de l'alphabêt uniquement.";
        $isSucces = FALSE;

    } 
    if(!isEmail($email)){
        $EmailError = "Veuillez saisir votre email !";
        $isSucces = FALSE;
    } else{
        $db = database::connect();
        $admin = $db->prepare("SELECT id_admin FROM admins WHERE email = ?");
        $admin->execute([$email]);
        $req = $admin->fetch();
        if($req){
            $emailError = "Cet email est déja utilisé.";
            $isSucces = FALSE;
        }
    } 
    if(empty($password)){
        $passwordError = "Veuillez saisir un mot de pass !";
        $isSucces = FALSE;
    }  
    if(!isPassword($rpassword,$password) || empty($rpassword)){
        $rpasswordError = "Veuillez entrer le même mot de pass !";
        $isSucces = FALSE;
    }  
    if($isSucces){
        $db = database::connect();
        $hash = password_hash($password,PASSWORD_DEFAULT);
        $user = $db->prepare("INSERT INTO admins SET prenom= ?, email = ?, password = ?, nom  = ?");
        $user->execute([$firstname,$email,$hash,$name]);
        $req = $db->prepare("SELECT * FROM admins WHERE email= ?");
        $req->execute([$email]);
        $admin = $req->fetch();
        session_start();
        $_SESSION['id_admin'] = $admin['id_admin'];
        $_SESSION['email'] = $admin['email'];
        $_SESSION['password'] = $admin['password'];
        $_SESSION['Firstname'] = $admin['prenom'];
        header("location: admin.php");
    }
}

function verifyinput($var){
    $var = trim($var);
    $var = stripcslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}
function isPassword($var1,$var2){
    if ($var1 == $var2)
       return true;
}
function isname($var){
    return preg_match("/^[a-zA-Z]+$/", $var);
}
function isEmail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inscription</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/admin-inscription.css'>
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <div class="row">
            <form id="contact_form" action="inscadmin.php" method="post">
                <p><label for="nom">Nom:</label></p>
                <input class="inp" type="text" id="nom" placeholder="Votre nom" name="name">
                <p class="comments"><?php  echo $NameError; ?></p>
                <p><label for="prenom">Prenom:</label></p>
                    <input class="inp" type="text" id="prenom" placeholder="Votre prenom" name="firstname">
                    <p class="comments"><?php  echo $FirstError; ?></p>
                <p><label for="email">Email: </label> </p>
                    <input class="inp" name="email" type="text" id="email" placeholder="votre email">
                    <p class="comments"><?php  echo $EmailError; ?></p>
                <p><label for="mdp">Mot de pass:</label></p>
                    <input class="inp" type="password" id="mdp" name="password">
                    <p class="comments"><?php  echo $passwordError; ?></p>
                <p><label for="cmdp">Confirmer votre mot de pass:</label></p>
                    <input class="inp" type="password" id="cmdp" name="rpassword">
                    <p class="comments"><?php  echo $rpasswordError; ?></p>                   
                    <div class="submit">
                        <input class="boutton1" type="submit" value="Inscription">
                    </div> 
                    <div class="retour"><a href="authenadmin.php">Retour</a></div>
            </form>
        </div>
    </div>
</body>
</html>