<?php
session_start(); // Rozpoczęcie sesji

// Usunięcie wszystkich zmiennych sesji
session_unset();

// Zniszczenie sesji
session_destroy();

// Przekierowanie na stronę główną (index.php)
header("Location: ../index.php");
exit;
?>
