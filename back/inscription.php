<?php   
    require("navbar.php");
    $firstname = $name = $email = $telephone = $password = $rpassword = "";
    $firstnameError = $nameError = $emailError = $telephoneError = $passwordError = $rpasswordError = "";
    $isSucces = FALSE;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $firstname =  verifyinput($_POST["firstname"]);
        $name =  verifyinput($_POST['name']);
        $email =  verifyinput($_POST['email']);
        $telephone =  verifyinput($_POST['telephone']);
        $password =  $_POST['password'];
        $rpassword =  $_POST['rpassword'];
        $isSucces = TRUE;

        if(!isname($firstname)){
            $firstnameError = "Votre prénom doit avoir de l'alphabêt uniquement.";
            $isSucces = FALSE;
        }
        if(!isname($name)  || empty($name)){
            $nameError = "Votre nom doit avoir de l'alphabêt uniquement.";
            $isSucces = FALSE;
        } 
        if(!isEmail($email)){
            $emailError = "Veuillez saisir votre email !";
            $isSucces = FALSE;
        } else{
            $db = database::connect();
            $user = $db->prepare("SELECT id FROM users WHERE email = ?");
            $user->execute([$email]);
            $req = $user->fetch();
            if($req){
                $emailError = "Cet email est déja utilisé.";
                $isSucces = FALSE;
            }
        } 
        if(!isPhone($telephone)){
            $telephoneError = "Que des chiffres et des espaces.";
            $isSucces = FALSE;
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
            $user = $db->prepare("INSERT INTO users SET firstname= ?, email = ?, password = ?, name  = ?,telephone = ?");
            $user->execute([$firstname,$email,$hash,$name,$telephone]);

            $user = $db->prepare("SELECT * FROM users WHERE email = ?");
            $user->execute(array($email));
            $userinfo = $user->fetch(); 
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['email'] =$email;
            $_SESSION['password'] = $hash;
            $_SESSION['Firstname'] = $firstname;
            $_SESSION['panier'] = [];
            header("location: ../index.php");
        }
    } 
    function isPassword($var1,$var2){
        if ($var1 == $var2)
           return true;
    }
    function isname($var){
        return preg_match("/^[a-zA-Z]+$/", $var);
    }
    function isPhone($var){
        return preg_match("/^[0-9 ]*$/", $var);
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
?>
<!doctype html>
<html>
    <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initia-scale=1">
       <link rel="stylesheet" href="../css/inscription.css" />
       <link rel="stylesheet" href="../css/navbar.css" />
       <link rel="icon" type="images/css" href="../images/logo.png">
       <title> Inscrription</title>
    </head>
    <body>
    <div class="contenu" style="display:<?php if($_SESSION) echo'none'?>" >  
        <div class="container">
            <div class="divider"></div>
            <div class="heading">
                <h2>Inscrivez-vous</h2>
            </div>
            <div class="row">
                <form id="contact_form" method="post" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
                    <div class="col">
                        <p><label for="firstname">Prénom<span class="blue"> *</span></label></p>
                        <input class="form-control" id="firstname" type="text" name="firstname" placeholder="Votre prénom" value="<?php echo $firstname; ?>"> 
                        <p class="comments"><?php  echo $firstnameError; ?></p>
                    </div>
                    <div class="col">
                        <p><label for="name">Nom<span class="blue"> *</span></label></p>
                        <input class="form-control" id="name" type="text" name="name" placeholder="Votre nom" value="<?php echo $name;?>" > 
                        <p class="comments"><?php  echo $nameError; ?></p>
                    </div>
                    <div class="col">
                        <p><label for="email">Email<span class="blue"> *</span></label></p>
                        <input class="form-control" id="email" type="text" name="email" placeholder="Votre Email" value="<?php echo $email; ?>" > 
                        <p class="comments"><?php  echo $emailError; ?></p>
                    </div>
                    <div class="col">
                        <p><label for="tel">Téléphone(Facultatif)<span class="blue"> *</span></label></p>
                        <input class="form-control" id="tel" type="tel" name="telephone" placeholder="Votre numéro" value="<?php echo $telephone ?>"> 
                        <p class="comments"><?php  echo $telephoneError; ?></p>
                    </div>
                    <div class="col">
                        <p><label for="mdp">Mot de pass<span class="blue"> *</span></label></p>
                        <input class="form-control" id="mdp" type="password" name="password" placeholder="Votre mot de pass" value="<?php echo $password;?>" > 
                        <p class="comments"><?php  echo $passwordError; ?></p>
                    </div>
                    <div class="col">
                        <p><label for="reppassword">Confirmation du mot de pass<span class="blue">*</span></label></p>
                       <input class="form-control" id="reppassword" type="password" name="rpassword" placeholder="Confirmer votre mot de pass" value="<?php echo $rpassword; ?>" > 
                        <p class="comments"><?php  echo $rpasswordError; ?></p>
                    </div>
                    <div class="col">
                    </div>
                    <div class="col">
                        <input type="submit" class="boutton1" name="inscrire" value="S'inscrire"> 
                    </div>
                    <p class="inscrit" style="Display:<?php if($isSucces) echo 'block'; else echo 'none'; ?>"> Vous etes inscrit avec succées :) </p>
                </form>
            </div>
    </div>
    </body>
</html>