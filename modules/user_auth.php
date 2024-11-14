<?php
include('../db/config.php');

if (isset($_GET['action']) && $_GET['action'] === 'register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
            die("Hasła nie są zgodne.");
        }

        $stmt = $pdo->prepare("SELECT id_uzytkownik FROM uzytkownicy WHERE login = :login");
        $stmt->execute(['login' => $login]);
        if ($stmt->fetch()) {
            die("Użytkownik o takim loginie już istnieje.");
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO uzytkownicy (login, haslo, rola) VALUES (:login, :haslo, 'klient')");
        if ($stmt->execute(['login' => $login, 'haslo' => $hashed_password])) {
            echo "Rejestracja zakończona sukcesem. Możesz się teraz zalogować.";
        } else {
            echo "Wystąpił błąd podczas rejestracji. Spróbuj ponownie.";
        }
    }
}
?>
