<?php

    session_start();
    
    include_once('top.php');

    if(!isset($_SESSION['id_usuario']))
    {
        header('Location: logout.php');    
    }
    else
    {
    
        include_once('connect.php');
        
        // Iniciando sessão de usuário
        $id = $_SESSION['id_usuario']; 
        
        // Selecionando "id" do usuário e registando frequência com data atual
        $query_cons = $pdo->prepare("SELECT presenca_frequencia FROM score_frequencia WHERE id_usuario_frequencia_fk = :id");
        $query_cons->bindValue(":id", $id);
        $query_cons->execute();
        $presenca_cons = $query_cons->fetch();
        $now = date('Y-m-d');
        
        // Associando "id" de usuário com data e evitando data repetida
        if($presenca_cons['presenca_frequencia'] == $now)
        {
            echo '<label style="display:block; background-color: #ccc; text-align:center; border-radius:5px;">Frequência já registrada</label>';
            echo '<a href="score_card.php"><button>Voltar</button></a>';
        }
        else
        {
            // Registra a frequência com base no ID do aluno.
            $query = $pdo->prepare("INSERT INTO score_frequencia (id_usuario_frequencia_fk, presenca_frequencia) VALUES (:id, NOW())");
            $query->bindValue(":id", $id);
            $query->execute();
            
            //Consulta valor no score_frequencia para ver se é "0".
            $query_pts_score = $pdo->prepare("SELECT acionador_frequencia_aluno FROM score_frequencia WHERE id_usuario_score_fk = :id_score");
            $query_pts_score->bindValue(":id_score", $id);
            $query_pts_score->execute();
            
            $query_pts_ac = $query_pts_score->fetch();
            
            if($query_pts_ac['acionador_frequencia_aluno'] == 0)
            {
              //Altera de "0" para "1" o valor do acionador.
              $query_ac = $pdo->prepare("UPDATE score_frequencia SET acionador_frequencia_aluno = :acionador");
              $query_ac->bindValue(":acionador", '1');
              $query_ac->execute();
              
              //Insere o valor do score de 0.10pts.
              $pts_score = 0.10;
              $query_pts_sc = $pdo->prepare("INSERT INTO score_card (id_usuario_score_fk, score) VALUES (:id_usuario_fk, :score_valor) ");
              $query_pts_sc->bindValue(":id_usuario_fk", $id);
              $query_pts_sc->bindValue(":score_valor", $pts_score);
              $query_pts_sc->execute();
              
              echo "Data: ".date("d-m-Y")."<br>";
              echo "Frequência registrada com sucesso<br>";
              echo '<a href="score_card.php"><button>Voltar</button></a>';
            
            }
            else
            {
              //Se for valor "1".
              //Busca o dado do score_card para somar.
              $query_pts_sc = $pdo->prepare("SELECT score FROM score_card WHERE id_usuario_score_fk = :id_score");
              $query_pts_sc->bindValue(":id_score", $id);
              $query_pts_sc->execute();
              
              $pts_query = $query_pts_sc->fetch();
              $pts_score = $pts_query['score'];
              $pts_freq = 0.10;
              $soma_pts_freq = $pts_score + $pts_freq;
              
              //Altera a pontuação no score da table score_card.
              $query_soma_score = $pdo->prepare("UPDATE score_card SET score = :soma_score");
              $query_soma_score->bindValue(":soma_score", $soma_pts_freq);
              $query_soma_score->execute();
              
              echo "Data: ".date("d-m-Y")."<br>";
              echo "Frequência registrada com sucesso<br>";
              echo '<a href="score_card.php"><button>Voltar</button></a>';
              
            }
    
        }
    
    }
   
    include_once('footer.php');
                    
?>