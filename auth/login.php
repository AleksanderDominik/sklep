<?php 
$pageTitle = "Logowanie"; // Ustawienie tytułu strony
// include('../templates/header.php'); 
//  include('../templates/navigation.php'); 
?>

<h2 style="margin-top: 80px;">Logowanie</h2>

<form action="modules/user_auth.php?action=login" method="post">
    <label for="login">Login:</label>
    <input type="text" id="login" name="login" required><br>

    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Zaloguj się</button>
</form>

 <?php // include('../templates/footer.php'); ?>