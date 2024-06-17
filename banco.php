<?php

// Configuração do banco de dados
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "db_estouro_de_pilha";

$banco = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Função para buscar usuário
function buscarUsuario(string $usr) {
    global $banco;
    $sql = "SELECT usr_id, usr_name, usr_password FROM db_usr WHERE usr_name = ?";
    $stmt = $banco->prepare($sql);
    $stmt->bind_param("s", $usr);
    $stmt->execute();
    return $stmt->get_result();
}

// Função para registrar usuário
function registerUser(string $username, string $password) {
    global $banco;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO db_usr (usr_name, usr_password) VALUES (?, ?)";
    $stmt = $banco->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        echo "Usuário registrado com sucesso.";
    } else {
        echo "Erro ao registrar o usuário: " . $stmt->error;
    }
}

// Função para registrar post
function registerPost(string $ttl, string $bdy, int $usr_id) {
    global $banco;
    $sql = "INSERT INTO db_post (post_tittle, post_body, usr_id) VALUES (?, ?, ?)";
    $stmt = $banco->prepare($sql);
    $stmt->bind_param("ssi", $ttl, $bdy, $usr_id);
    if ($stmt->execute()) {
        echo "Post registrado com sucesso.";
    } else {
        echo "Erro ao registrar o post: " . $stmt->error;
    }
}

// Função para curtir post
function LikePost(int $post_id, int $usr_id): bool {
    global $banco;
    
    // Verifica se o usuário já curtiu o post
    $sql_check_like = "SELECT * FROM db_likes WHERE post_id = ? AND usr_id = ?";
    $stmt_check_like = $banco->prepare($sql_check_like);
    $stmt_check_like->bind_param("ii", $post_id, $usr_id);
    $stmt_check_like->execute();
    $result_check_like = $stmt_check_like->get_result();
    
    if ($result_check_like->num_rows > 0) {
        // Usuário já curtiu o post, remove o like
        $sql_unlike = "DELETE FROM db_likes WHERE post_id = ? AND usr_id = ?";
        $stmt_unlike = $banco->prepare($sql_unlike);
        $stmt_unlike->bind_param("ii", $post_id, $usr_id);
        return $stmt_unlike->execute();
    } else {
        // Usuário ainda não curtiu o post, insere o like
        $sql_like = "INSERT INTO db_likes (post_id, usr_id) VALUES (?, ?)";
        $stmt_like = $banco->prepare($sql_like);
        $stmt_like->bind_param("ii", $post_id, $usr_id);
        return $stmt_like->execute();
    }
}

// Função para contar curtidas
function countLikes(int $post_id) {
    global $banco;
    $sql = "SELECT COUNT(*) AS likes FROM db_likes WHERE post_id = ?";
    $stmt = $banco->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_object()->likes;
}

// Função para registrar comentário
function registerComment(string $comm_body, int $usr_id, int $post_id): bool {
    global $banco;
    $sql = "INSERT INTO db_comm (comm_body, usr_id, post_id) VALUES (?, ?, ?)";
    $stmt = $banco->prepare($sql);
    $stmt->bind_param("sii", $comm_body, $usr_id, $post_id);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Erro ao registrar o comentário: " . $stmt->error);
        return false;
    }
}

?>
