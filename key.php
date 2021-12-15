<?php
    include_once('connect.php');
    $matricula = $_POST["matricula"];
    $senha = $_POST["senha"];
    
    $query = $pdo->prepare("SELECT id_usuario FROM score_usuario WHERE matricula_usuario = :matricula AND senha_usuario = :senha");
    $query->bindValue(":matricula", $matricula);
    $query->bindValue(":senha", $senha);
    $query->execute();
    
    if($query->rowCount() > 0)
    {
        session_start();
        
        $dado = $query->fetch();
        $_SESSION['id_usuario'] = $dado['id_usuario'];
        header('Location: score_card.php');
    }
    else
    {        
        header('Location: error-login.php');
    }

?>