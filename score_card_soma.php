<?php
        session_start();
        $id = $_SESSION['id_usuario'];
    
        $cons = $pdo->prepare("SELECT * FROM score_card WHERE id_usuario_score_fk = :id_fk");
        $cons->bindValue(":id_fk", $id);
        $cons->execute();
        
        $pts_res = $cons->fetch();
        
        $pts = $pts_res['score'];
        $pts_soma = 0.10;
        $soma = $pts + $pts_soma;
        
        $query_soma = $pdo->prepare("UPDATE socre_card SET score = :soma_score)");
        //$query_soma->bindValue(":id_score", $id);
        $query_soma->bindValue(":soma_score", $soma);
        $query_soma->execute();
        
?>