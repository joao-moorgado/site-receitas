<pre>
  <?php

  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "db_estouro_de_pilha";

  $banco = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

  function buscarUsuario(string $usr) {
    global $banco;
    $sql = "SELECT usr_id, usr_name, usr_password FROM db_usr WHERE usr_name = ?";
    $stmt = $banco->prepare($sql);
    $stmt->bind_param("s", $usr);
    $stmt->execute();
    return $stmt->get_result();
}

  function registerUser(string $username, string $password) {
    global $banco;
  
      // Criptografa a senha (recomendado usar password_hash() para segurança)
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
      // Insere os dados na tabela db_usr
      $sql = "INSERT INTO db_usr (usr_name, usr_password) VALUES ('$username', '$hashed_password')";
  
      if ($banco->query($sql)) {
          echo "Usuário registrado com sucesso.";
      } else {
          echo "Erro ao registrar o usuário: " . mysqli_error($banco);
      }
    }

    function registerPost(string $ttl, string $bdy, int $usr_id) {
      global $banco;
    
        // Insere os dados na tabela db_usr
        $sql = "INSERT INTO db_post (post_ttl, post_bdy, usr_id) VALUES ('$ttl', '$bdy', '$usr_id')";
    
        if ($banco->query($sql)) {
            echo "Post registrado com sucesso.";
        } else {
            echo "Erro ao registrar o post: " . mysqli_error($banco);
        }
      }

      function likePost(int $post_id, int $usr_id) {
        global $banco;
        $sql = "INSERT INTO db_likes (post_id, usr_id) VALUES (?,?)";
        $stmt = $banco->prepare($sql);
        $stmt->bind_param("ii", $post_id, $usr_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
      }

      function countLikes(int $post_id) {
        global $banco;
        $sql = "SELECT COUNT(*) AS likes FROM db_likes WHERE post_id =?";
        $stmt = $banco->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object()->likes;
      }

  ?>
</pre>