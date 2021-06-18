<?php
    session_start();

    $mysqli = new mysqli('localhost', 'root', '', 'dsw_phpcrud') or die(mysqli_error($mysqli));

    $name = '';
    $state = '';
    $city = '';
    $update = false;
    $id = 0;

    if(isset($_POST['save'])){
        $name = $_POST['name'];
        $state = $_POST['state'];
        $city = $_POST['city'];

        $mysqli->query("INSERT INTO data (name,state,city)VALUES('$name',$state,'$city')") or die($mysqli->error);

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
            $state = $row['state'];
            $city = $row['city'];
            $update = true;
        }    
    }

    if (isset($_POST['update'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $state = $_POST['state'];
        $city = $_POST['city'];

        $mysqli->query("UPDATE data SET name='$name', state='$state', city='$city' where id=$id")
        or die($mysqli->error);

        $_SESSION['message'] = "Os dados foram atualizados!";
        $_SESSION['msg_type'] = "warning";

        header("Location: index.php");
    }

    ?>