<?php
$host = 'localhost';
$dbname = 'sklep';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sprawdzanie, czy alert był już wyświetlony
    if (!isset($_SESSION['db_connected'])) {
        $_SESSION['db_connected'] = true;
        $_SESSION['db_alert'] = "Połączenie z bazą danych zakończone pomyślnie!";
    }
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}
?>
