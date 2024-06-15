<pre>
  <?php

  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "db_estouro_de_pilha";

  $banco = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

  function buscarUsuario(string $usr) {
    global $banco;

    $sql = "SELECT * FROM db_usr WHERE usr_name = '$usr'";

    $busca = $banco->query($sql);
    echo var_dump($busca);

    return $busca;
  }

  ?>
</pre>