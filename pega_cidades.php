<?php
    $conexao = new PDO("mysql:host=localhost;dbname=cidades-estados","root","100812");
    $conexao->exec('SET CHARACTER SET utf8');

    $pegaCidades = $conexao->prepare("SELECT nome,id,uf FROM cidade WHERE uf='".$_POST['id']."'");
    $pegaCidades->execute();
    $fetchAll = $pegaCidades->fetchAll();

    foreach($fetchAll as $cidade){
        echo'<option>'.$cidade['nome'].'</option>';
    }