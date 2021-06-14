<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script type="text/javascript" src="jquery-3.6.0.min.js"></script>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

  <title>CRUD em PHP!</title>
</head>

<body>
  <?php require_once 'process.php'; ?>
  <?php if (isset($_SESSION['message'])) : ?>
    <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
      <?php
      echo $_SESSION['message'];
      unset($_SESSION['message']);
      ?>
    </div>
  <?php endif ?>

  <div class="container">
    <?php
    $mysqli = new mysqli('localhost', 'root', '100812', 'dsw_phpcrud') or die(mysqli_error($mysqli));
    $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
    ?>
      <form action="process.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-control bg-dark text-white">
          <label>Nome</label>
          <input type="text" name="name" value="<?php echo $name;  ?>" placeholder="Digite seu nome">
          <label>Estado</label>
          <select name="estado" value="<?php echo $name;  ?>" id="estado">
      <?php
      $conexao = new PDO("mysql:host=localhost;dbname=cidades-estados","root","100812");
      $conexao->exec('SET CHARACTER SET utf8');
    
          $select = $conexao->prepare("SELECT id,nome FROM estado ORDER BY nome ASC");
          $select->execute();
          $fetchAll = $select->fetchAll();
          
          foreach($fetchAll as $estado)
          {
              echo '<option value="'.$estado['id'].'">'.$estado["nome"].'</option>';
          }
          ?>
    
    </select>
    <label>Cidade</label>
    <select id="cidade"></select>
          
          <?php
          if($update == true):
          ?>
            <button type="submit" class="btn btn-info" name="update">Atualizar dados</button>
            <?php else: ?>
          <button type="submit" class="btn btn-success" name="save">Salvar dados</button>
          <?php endif; ?>
        </div>
      </form>
    
      <table class="table table-light table-hover">
      
        <thead>
          <tr>
            <th>Nome</th>
            <th>Cidade</th>
            <th scope="col" colspan="3">Ação</th>
          </tr>
        </thead>

        <?php while ($row = $result->fetch_assoc()) : ?>
          <tbody>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['location']; ?></td>
              <td>
              <?php if ($distance == false) : ?>
                <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                <a href="process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Excluir</a>
                <a href="index.php?distanceFrom=<?php echo $row['id']; ?>" class="btn btn-secondary">Distância</a>
                <a href="#" class="btn btn-outline-secondary">Selecionar</a>
                
                <?php else: ?>
                  <a href="#" class="btn btn-outline-secondary">Editar</a>
                  <a href="#" class="btn btn-outline-secondary">Excluir</a>
                  <a href="#" class="btn btn-outline-secondary">Distância</a>
              
                  <a href="index.php?distanceTo=<?php echo $row['id']; ?>" class="btn btn-primary">Selecionar</a>
                  <?php endif?>
                </td>
            </tr>
          </tbody>
        <?php endwhile; ?>

      </table>
  </div>
</body>

</html>

<script>
$("#estado").on("change",function(){

    $.ajax({
        url: 'pega_cidades.php',
        type: 'POST',
        data: {id:$("#estado").val()},
        beforeSend: function(){
            $("#cidade").css({'display':'inline'});
            $("#cidade").html("Carregando...");
        },
        success: function(data){
            $("#cidade").css({'display':'inline'});
            $("#cidade").html(data);
        },
        error: function(data){
            $("#cidade").css({'display':'inline'});
            $("#cidade").html("houve um erro ao carregar");
        }
    });
});
</script>