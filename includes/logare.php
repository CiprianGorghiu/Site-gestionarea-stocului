<?php
include 'conectare.php';
session_start();

// Verifică dacă utilizatorul este deja autentificat
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Utilizatorul este deja autentificat, redirecționează către pagina protejată
    header("Location: /index.php");
    exit();
}

// Preluare date din formular
$username = $_POST['username'];
$password = $_POST['password'];

// Interogare baza de date pentru a verifica existența utilizatorului și a parolei
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

// Verifică dacă există utilizatorul și parola în baza de date
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Utilizatorul este autentificat, setează variabila de sesiune "logged_in"
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $row['ID'];

    // Adaugă înregistrarea de log pentru logare
    $actiuneLog = " s-a autentificat!";
    $dataLog = date('Y-m-d H:i:s');
    $sqlLog = "INSERT INTO logs (nume, actiune, data) VALUES ('$username', '$actiuneLog', '$dataLog')";
    mysqli_query($conn, $sqlLog);

    // Verifică dacă utilizatorul are rolul de "admin" sau "barman"
    if ($row['admin'] == 1) {
        // Utilizatorul are rolul de "admin", setează sesiunea "admin"
        $_SESSION['admin'] = true;
        // Redirecționează către pagina pentru administratori
        header("Location: /index.php");
        exit();
    } elseif ($row['barman'] == 1) {
        // Utilizatorul are rolul de "barman", setează sesiunea "barman"
        $_SESSION['barman'] = true;
        $_SESSION['barman_name'] = $row['username']; // Salvează numele barmanului în sesiune
        $_SESSION['user_id'] = $row['ID'];

        // Redirecționează către pagina pentru barmeni
        header("Location: /index.php");
        exit();
    } else {
        // Utilizatorul nu are niciun rol valid, afișăm un mesaj de eroare
        header("Location: /login.php?error=1");
        exit();
    }
} else {
    // Utilizatorul sau parola sunt incorecte, deci afișăm un mesaj de eroare
    header("Location: /login.php?error=1");
    exit();
}

// Închidere conexiune la baza de date
mysqli_close($conn);
?>
