<?php 
require 'database.php';
session_start();
if($_GET){
	$db = Database::connect();
	$id_item = $_GET['id_item'];
	$qte=1;
	$s=$db->prepare('SELECT quantite FROM panier WHERE id_user = ? AND id_item = ?');
	$s->execute([$_SESSION['id'],$id_item]);
    $panier=$s->fetch();
    if($panier['quantite'] == 0){
	$statement = $db->prepare('INSERT INTO panier(id_item,id_user,quantite) values(?,?,?)');
	$statement->execute([$id_item,$_SESSION['id'],$qte]);    	
    }
	else{
		$qte+=$panier['quantite'];
        $statement = $db->prepare('UPDATE panier SET quantite=? WHERE id_user= ? AND id_item = ?');
		$statement->execute([$qte,$_SESSION['id'],$id_item]);		
    }

	header("location: ../index.php");
	}

?>