<?php
session_start();
include('db/config.php'); // Połączenie z bazą danych

// Sprawdzanie połączenia z bazą
try {
    $pdo->query("SELECT 1");
    $dbStatus = "Połączono z bazą danych.";
} catch (Exception $e) {
    $dbStatus = "Błąd połączenia z bazą danych: " . $e->getMessage();
}

// Sprawdzenie, czy użytkownik jest zalogowany
$isLoggedIn = isset($_SESSION['user_id']);
$pageTitle = "Strona Główna";

// Dynamiczne przełączanie sekcji
$section = isset($_GET['section']) ? $_GET['section'] : 'home'; // Domyślnie 'home'

// Obsługa komunikatów
$errorMessage = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;
$successMessage = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : null;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function switchSection(section) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(sec => sec.style.display = 'none');
            document.getElementById(section).style.display = 'block';
        }

        function showAlert(type, message) {
            if (message) {
                alert((type === 'error' ? "Błąd: " : "Sukces: ") + message);
            }
        }
    </script>
</head>
<body onload="showAlert('<?php echo $errorMessage ? 'error' : 'success'; ?>', '<?php echo $errorMessage ?? $successMessage; ?>');">
    <header class="main-header">
        <div class="container">
            <h1 class="logo"><a href="index.php">Sklep Internetowy</a></h1>
            <nav class="main-nav">
                <a href="index.php?section=home" onclick="switchSection('home'); return false;">Strona Główna</a>
                <?php if (!$isLoggedIn): ?>
                    <a href="index.php?section=login" onclick="switchSection('login'); return false;">Logowanie</a>
                    <a href="index.php?section=register" onclick="switchSection('register'); return false;">Rejestracja</a>
                <?php else: ?>
                    <a href="auth/logout.php">Wyloguj</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <!-- Informacja o połączeniu z bazą danych -->
        <p><?php echo $dbStatus; ?></p>

        <!-- Powitanie -->
        <?php if ($isLoggedIn): ?>
            <h2>Witaj, <?php echo htmlspecialchars($_SESSION['login']); ?>!</h2>
        <?php else: ?>
            <h2>Witaj na stronie</h2>
        <?php endif; ?>

        <!-- Dynamiczne sekcje -->
        <div id="home" class="section" style="<?php echo $section === 'home' ? '' : 'display: none;'; ?>">
            <p>To jest strona główna sklepu internetowego.</p>
        </div>

        <div id="login" class="section" style="<?php echo $section === 'login' ? '' : 'display: none;'; ?>">
            <h2>Logowanie</h2>
            <form action="modules/user_auth.php?action=login" method="post">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required><br>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit">Zaloguj się</button>
            </form>
        </div>

        <div id="register" class="section" style="<?php echo $section === 'register' ? '' : 'display: none;'; ?>">
            <h2>Rejestracja</h2>
            <form action="modules/user_auth.php?action=register" method="post">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required><br>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required><br>
                <label for="confirm_password">Potwierdź hasło:</label>
                <input type="password" id="confirm_password" name="confirm_password" required><br>
                <button type="submit">Zarejestruj się</button>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <p>© 2024 Sklep Internetowy</p>
    </footer>

    <script>
        // Ustawienie odpowiedniej sekcji po załadowaniu strony
        document.addEventListener('DOMContentLoaded', function () {
            switchSection('<?php echo $section; ?>');
        });
    </script>
</body>
</html>
