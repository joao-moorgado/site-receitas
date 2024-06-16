<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
</head>
<body>

    <h1>ESTOURO<BR>DE PILHA</h1>

    <br>

    <?php

    require_once "form-post.php";
    require_once "banco.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $ttl = $_POST['ttl'];
        $bdy = $_POST['bdy'];
        $usr_id = 1;

        echo $ttl . $bdy . $usr_id;

        registerPost($ttl, $bdy, $usr_id);
    }

    ?>

</body>
</html>