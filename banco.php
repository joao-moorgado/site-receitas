<pre>
  <?php

  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "db_estouro_de_pilha";

  $banco = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

  function buscarUsuario(string $usr) {
    global $banco;

    $q = "SELECT usr_id, usr_name, usr_password FROM db_usr WHERE usr_name ='$usr'";

    $busca = $banco->query($q);

    return $busca;
  }

  ?>
</pre>