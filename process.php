<?php
    session_start();

    $mysqli = new mysqli('localhost', 'root', '100812', 'dsw_phpcrud') or die(mysqli_error($mysqli));

    $name = '';
    $location = '';
    $update = false;
    $id = 0;
    $distance = false;

    if(isset($_POST['save'])){
        $name = $_POST['name'];
        $location = $_POST['location'];

        $mysqli->query("INSERT INTO data(name, location) VALUES('$name','$location')") or die($mysqli->error);

        $_SESSION['message'] = "Os dados foram salvos no sistema!";
        $_SESSION['msg_type'] = "success";

        header("Location: index.php");
        die();
    }

    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error);

        $_SESSION['message'] = "Os dados foram excluídos do sistema!";
        $_SESSION['msg_type'] = "danger";

        header("Location: index.php");
        die();
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];

        $result = $mysqli->query("SELECT * FROM data WHERE id = $id") or die($mysqli->error);
        if($result->num_rows){
            $row = $result->fetch_array();
            $name = $row['name'];
            $location = $row['location'];
            $update = true;
        }    
    }

    if (isset($_POST['update'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $location = $_POST['location'];

        $mysqli->query("UPDATE data SET name='$name', location='$location' where id=$id")
        or die($mysqli->error);

        $_SESSION['message'] = "Os dados foram atualizados!";
        $_SESSION['msg_type'] = "warning";

        header("Location: index.php");
    }

    if(isset($_GET['distanceFrom'])){
        $id = $_GET['distanceFrom'];

        $result = $mysqli->query("SELECT * FROM data WHERE id = $id") or die($mysqli->error);
        if($result->num_rows){
            $row = $result->fetch_array();
            $name = $row['name'];
            $location = $row['location'];
            $distance = true;
        }
       
        echo($name);
        echo($location);
    }
        
       
    if (isset($_GET['distanceTo'])){
        $id2 = $_GET['distanceTo'];
        $result2 = $mysqli->query("SELECT * FROM data WHERE id = $id2") or die($mysqli->error);
        if($result2->num_rows2){
            $row2 = $result2->fetch_array();
            $name2 = $row2['name'];
            $location2 = $row2['location'];
        }
       
        echo($name);
        echo($location);
        
        
        $response = file_get_contents("https://murmuring-mountain-13087.herokuapp.com/distances/by-points?from=16&to=26");
        $response = json_decode($response);
        $miles = number_format($response, 2, '.', ',');
        $_SESSION['message'] = "distancia do usuário '$name1' para o usuário '$name2' é: '$miles' milhas";
        $_SESSION['msg_type'] = "success";
    }

  
        // '$name1' para o usuário '$name2' é: '$response' milhas local1 '$originLocation' local2 '$destinyLocation' 
    

    ?>