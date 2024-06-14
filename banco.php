<pre>
  <?php

  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "db_estouro_de_pilha";

  $banco = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

  function buscarUsuario(string $usuario, bool $debug=false) {
    global $banco;

    $q = "SELECT usuario, nome, senha FROM usuarios WHERE usuario='$usuario'";

    $busca = $banco->query($q);

    return $busca;
  }

  ?>
</pre>