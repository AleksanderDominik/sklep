<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"> <!-- Poprawna ścieżka do CSS -->
    <title><?php echo isset($pageTitle) ? $pageTitle : "Sklep Internetowy"; ?></title> <!-- Dynamiczny tytuł -->
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1 class="logo"><a href="index.php">Sklep Internetowy</a></h1>
            <nav class="main-nav">
                <a href="index.php">Strona Główna</a>
                <a href="index.php?page=login">Logowanie</a>
                <?php if (isset($pageTitle) && $pageTitle === "Logowanie"): ?>
                    <a href="auth/register.php">Rejestracja</a>
                <?php else: ?>
                    <a href="auth/logout.php">Wyloguj</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
