<?php
// Se inițializează sau se reia sesiunea
session_start();

// Se importă fișierul de conectare la baza de date
include 'conectare.php';

// Verifică dacă utilizatorul este autentificat
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Obține numele utilizatorului conectat
    $username = $_SESSION['username'];

    // Adaugă înregistrarea de log pentru deconectare
    $actiuneLog =" s-a deconectat de pe cont!";
    $dataLog = date('Y-m-d H:i:s');
    $sqlLog = "INSERT INTO logs (nume, actiune, data) VALUES ('$username', '$actiuneLog', '$dataLog')";
    mysqli_query($conn, $sqlLog);
}

// Se distrug toate variabilele de sesiune
$_SESSION = array();

// Se distrug cookie-urile de sesiune
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Se distrug sesiunea
session_destroy();

// Redirecționare către pagina de autentificare sau altă pagină dorită
header("Location: /login.php");
exit();
?>
