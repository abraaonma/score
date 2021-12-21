<?php
    include_once("top.php");
    include_once('connect.php');
?>

    <form method="POST">

        <input type="text" placeholder="Sua matrícula" name="matricula" required><br>

        <input type="password" placeholder="Sua senha" name="senha" required><br>

        <button type="submit" name="login">Login</button><br>

        <div class="footer">® 2017-2021</div>
    </div>
</form>
<?php

if(isset($_POST['login']))
{
    $matricula = addslashes($_POST["matricula"]);
    $senha = addslashes($_POST["senha"]);

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

}
?>

    <?php include_once("footer.php"); ?>
