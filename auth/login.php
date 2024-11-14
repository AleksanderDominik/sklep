<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('templates/header.php'); ?>
    <?php include('templates/navigation.php'); ?>

    <h2>Logowanie</h2>
    <form action="modules/user_auth.php?action=login" method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br>

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Zaloguj się</button>
    </form>

    <?php include('templates/footer.php'); ?>
</body>
</html>
