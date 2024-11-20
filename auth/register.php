<?php
$pageTitle = "Rejestracja"; // Ustawienie tytułu strony
include('../templates/header.php'); 
include('../templates/navigation.php'); 
?>

<h2 style="margin-top: 80px;">Rejestracja</h2> <!-- Duży napis Rejestracja -->

<form id="registerForm" action="../modules/user_auth.php?action=register" method="post">
    <label for="login">Login:</label>
    <input type="text" id="login" name="login" required><br>

    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="confirm_password">Potwierdź hasło:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>

    <button type="submit">Zarejestruj się</button>
</form>

<script src="../js/validation.js"></script>
<?php include('../templates/footer.php'); ?>
</body>
</html>
