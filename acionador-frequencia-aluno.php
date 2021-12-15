<?php

    session_start();
    


    if(!isset($_SESSION['id_usuario']))
    {
        header('Location: logout.php');    
    }
    
    else
    
    {
        
        include_once('connect.php');
    
        $id = $_SESSION['id_usuario'];
        
        $query_acionador = $pdo->prepare("SELECT acionador FROM acionador_frequencia WHERE id_acionador = :id_ac");
        $query_acionador->bindValue(":id_ac", 1);
        $query_acionador->execute();
        $acionador = $query_acionador->fetch();
                        
        if($acionador['acionador'] == 1)
        {
    
            echo '<a href="frequencia.php"><button>Lançar Frequência</button></a>';
    
        }
        else
        {
            echo '<label style="display:block; background-color: #ccc; text-align:center; border-radius:5px; padding:10px; margin-top:10px; margin-botton:10px;">Aguardando liberação de frequência</label>';
        
        }
             
    }
?>