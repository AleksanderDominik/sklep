<?php
session_start();
include('../db/config.php'); // Połączenie z bazą danych

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?error=Musisz być zalogowany, aby edytować dane.");
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $errors = [];

    // Walidacja loginu
    if (empty($login)) {
        $errors[] = "Login nie może być pusty.";
    }

    // Walidacja hasła (jeśli jest wypełnione)
    if (!empty($password) || !empty($confirmPassword)) {
        if ($password !== $confirmPassword) {
            $errors[] = "Hasła nie są zgodne.";
        }
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            $errors[] = "Hasło musi mieć co najmniej 8 znaków, zawierać 1 wielką literę i 1 cyfrę.";
        }
    }

    // Jeśli są błędy, przekieruj z powrotem z komunikatem
    if (!empty($errors)) {
        $errorString = implode(", ", $errors);
        header("Location: ../index.php?section=account&error=" . urlencode($errorString));
        exit;
    }

    try {
        // Sprawdzenie, czy login jest unikalny (jeśli zmieniony)
        $stmt = $pdo->prepare("SELECT id_uzytkownik FROM uzytkownicy WHERE login = :login AND id_uzytkownik != :user_id");
        $stmt->execute(['login' => $login, 'user_id' => $userId]);
        if ($stmt->fetch()) {
            header("Location: ../index.php?section=account&error=Login jest już zajęty.");
            exit;
        }

        // Aktualizacja danych użytkownika
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE uzytkownicy SET login = :login, haslo = :haslo WHERE id_uzytkownik = :user_id");
            $stmt->execute(['login' => $login, 'haslo' => $hashedPassword, 'user_id' => $userId]);
        } else {
            $stmt = $pdo->prepare("UPDATE uzytkownicy SET login = :login WHERE id_uzytkownik = :user_id");
            $stmt->execute(['login' => $login, 'user_id' => $userId]);
        }

        // Usuwanie sesji po pomyślnej aktualizacji
        session_unset();
        session_destroy();

        // Przekierowanie na stronę logowania z komunikatem
        header("Location: ../index.php?section=login&success=Dane zostały zmienione poprawnie, teraz możesz się zalogować.");
        exit;
    } catch (PDOException $e) {
        header("Location: ../index.php?section=account&error=Błąd aktualizacji danych: " . $e->getMessage());
        exit;
    }
} else {
    header("Location: ../index.php?error=Nieprawidłowe żądanie.");
    exit;
}
