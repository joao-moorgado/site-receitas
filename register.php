<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
</head>
<body>
    <h2>Registro de Usuário</h2>
    <form action="register_processa.php" method="post">
        <label for="username">Usuário:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Senha:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
