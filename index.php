<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Jquery -->
  <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

  <title>CRUD em PHP!</title>
</head>

<body>

  <!-- Exibe alerta se existir -->
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
    $mysqli = new mysqli('localhost', 'root', '', 'dsw_phpcrud') or die(mysqli_error($mysqli));
    $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
    ?>
    <form action="process.php" method="POST">

      <input type="hidden" name="id" value="<?php echo $id; ?>">

      <div class="form-control bg-dark text-white">
        <label>Nome</label>
        <input type="text" name="name" value="<?php echo $name;  ?>" placeholder="Digite seu nome">

        <label>Estado</label>
        <select name="state" value="<?php echo $state;  ?>" id="estado">
          <?php
          //conecta e busca no bd a lista de estados
          $conn = new PDO("mysql:host=localhost;dbname=cidadesEstados", "root", "");
          $conn->exec('SET CHARACTER SET utf8');
          $select = $conn->prepare("SELECT id,nome FROM estado ORDER BY nome ASC");
          $select->execute();
          $fetchAll = $select->fetchAll();
          //pega cada elemento da lista de estados e coloca como option do select
          foreach ($fetchAll as $state) {
            echo '<option value="' . $state['id'] . '">' . $state["nome"] . '</option>';
          }
          ?>
        </select>

        <label>Cidade</label>
        <!-- Inicia vazio e será preenchido dinâmicamente pelo Ajax -->
        <select name="city" value="<?php echo $city;  ?>" id="cidade"></select>

        <?php
        if ($update == true) :
        ?>
          <button type="submit" class="btn btn-info" name="update">Atualizar dados</button>
        <?php else : ?>
          <button type="submit" class="btn btn-success" name="save">Salvar dados</button>
        <?php endif; ?>
      </div>
    </form>

    <table class="table table-light table-hover">

      <thead>
        <tr>
          <th>Nome</th>
          <th>Cidade</th>

          <th scope="col" colspan="2">Ação</th>
        </tr>
      </thead>
      <!-- Exibe todos os dados cadastrados -->
      <?php while ($row = $result->fetch_assoc()) : ?>
        <tbody>
          <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['city']; ?></td>
            <td>
              <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
              <a href="process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Excluir</a>
            </td>
          </tr>
        </tbody>
      <?php endwhile; ?>

    </table>
  </div>
</body>

</html>
<!-- Carrega dinâmicamente uma lista de cidades a partir do estado selecionado -->
<script>
  $("#estado").on("change", function() {

    $.ajax({
      url: 'get_cities.php',
      type: 'POST',
      data: {
        id: $("#estado").val()
      },
      beforeSend: function() {
        $("#cidade").css({
          'display': 'inline'
        });
        $("#cidade").html("Carregando...");
      },
      success: function(data) {
        $("#cidade").css({
          'display': 'inline'
        });
        $("#cidade").html(data);
      },
      error: function(data) {
        $("#cidade").css({
          'display': 'inline'
        });
        $("#cidade").html("houve um erro ao carregar");
      }

    });

  });
</script>