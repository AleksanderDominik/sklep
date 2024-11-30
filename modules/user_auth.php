<?php
session_start();
include('../db/config.php'); // Połączenie z bazą danych

// Obsługa logowania
if (isset($_GET['action']) && $_GET['action'] === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['haslo'])) {
            $_SESSION['user_id'] = $user['id_uzytkownik'];
            $_SESSION['role'] = $user['rola'];
            $_SESSION['login'] = $user['login'];
            header("Location: ../index.php?success=Zalogowano pomyślnie");
            exit;
        } else {
            header("Location: ../index.php?section=login&error=Niepoprawne dane logowania");
            exit;
        }
    }
}

// Obsługa rejestracji
if (isset($_GET['action']) && $_GET['action'] === 'register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']); // Usunięcie białych znaków
        $confirm_password = $_POST['confirm_password'];

        // Sprawdzenie zgodności haseł
        if ($password !== $confirm_password) {
            header("Location: ../index.php?section=register&error=Hasła nie są zgodne");
            exit;
        }

        // Walidacja hasła (minimum 8 znaków, 1 wielka litera, 1 cyfra)
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/', $password)) {
            header("Location: ../index.php?section=register&error=Hasło musi mieć co najmniej 8 znaków, zawierać 1 wielką literę, 1 cyfrę i 1 znak specjalny.");
            exit;
        }
        

        // Sprawdzenie unikalności loginu
        $stmt = $pdo->prepare("SELECT id_uzytkownik FROM uzytkownicy WHERE login = :login");
        $stmt->execute(['login' => $login]);
        if ($stmt->fetch()) {
            header("Location: ../index.php?section=register&error=Użytkownik o takim loginie już istnieje");
            exit;
        }

        // Hashowanie hasła
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Wstawianie nowego użytkownika do bazy danych
        $stmt = $pdo->prepare("INSERT INTO uzytkownicy (login, haslo, rola) VALUES (:login, :haslo, 'klient')");
        if ($stmt->execute(['login' => $login, 'haslo' => $hashed_password])) {
            header("Location: ../index.php?section=login&success=Rejestracja zakończona sukcesem! Możesz się zalogować.");
            exit;
        } else {
            header("Location: ../index.php?section=register&error=Wystąpił błąd podczas rejestracji.");
            exit;
        }
    }
}