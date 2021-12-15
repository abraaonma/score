<?php

    session_start();

    if(!isset($_SESSION['id_usuario']))
    {
        header('Location: logout.php');    
    }
    else
    {
    
    $id = $_SESSION['id_usuario'];
    
    include_once('connect.php');
    
    $query = $pdo->prepare("SELECT score FROM score_card WHERE id_usuario_score_fk = :id");
    $query->bindValue(":id", $id);
    $query->execute();
    
    $score = $query->fetch();
    
    echo '<b>IP:</b> <label style="background-color: #ff8000; padding:5px; border-radius:5px; color:white;" >'. $score['score'] .'</label>';
    
    }

?>