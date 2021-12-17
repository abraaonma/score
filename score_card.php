<?php
session_start();
    
include_once('top.php');
include_once('connect.php');

    if(!isset($_SESSION['id_usuario']))
    {
        header('Location: logout.php');
    }
    else
    {
        $id = $_SESSION['id_usuario'];
        
        $sql = $pdo->prepare("SELECT su.nome_usuario, su.matricula_usuario, scr.nome_curso, scr.disciplina_curso 
        FROM score_usuario AS su 
        INNER JOIN score_curso AS scr 
        ON su.id_usuario = scr.id_usuario_curso_fk
        WHERE id_usuario = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        while($cons = $sql->fetch()) 
        {
            echo "<p>".$cons['nome_curso']."</p>";
            
            echo "<p>".$cons['disciplina_curso']."</p>";
            
            echo "<p>Prof. Abraão Azevedo</p>";
            
            echo "<p>".$cons['nome_usuario']."</p>";
            
            echo "<p>".$cons['matricula_usuario']."</p>";
            
            //Inclui o índice de produtividade
            include_once('ip.php');
            echo "<br>";
            
            include_once('acionador-frequencia-aluno.php');
            
            echo '<a href="logout.php"><button>Sair</button></a>';
        
        } 
        include_once('footer.php');
    }

?>