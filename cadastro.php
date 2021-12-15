<?php
    include_once('top.php');
    
?>
<form method="POST">
    <input type="text" name="matricula" placeholder="Digite sua matrícula" maxlenght="12"><br>
    <button name="consultar_matricula">Consultar Matrícula</button>
</form>
<?php
    if(isset($_POST['consultar_matricula']))
    {
        include_once('connect.php');
        $matricula = $_POST['matricula'];
        $query_cad = $pdo->prepare("SELECT id_usuario FROM score_usuario WHERE matricula_usuario = :matricula");
        $query_cad->bindValue(":matricula", $matricula);
        $query_cad->execute();
        
        
        if($query_cad->rowCount() > 0)
        {
            $cons['id_usuario'] = $user['id_usuario'];
            echo $cons['id_usuario'];
        }
            else
        {
            echo "Deu algo errado!";
        
        }
    }
    
    include_once('footer.php');
?>