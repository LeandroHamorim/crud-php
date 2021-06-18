<?php
    $conn = new PDO("mysql:host=localhost;dbname=cidadesEstados","root","");
    $conn->exec('SET CHARACTER SET utf8');

    $getCities = $conn->prepare("SELECT nome,id,uf FROM cidade WHERE uf='".$_POST['id']."'");
    $getCities->execute();
    $fetchAll = $getCities->fetchAll();

    foreach($fetchAll as $cities){
        echo'<option>'.$cities['nome'].'</option>';
    }