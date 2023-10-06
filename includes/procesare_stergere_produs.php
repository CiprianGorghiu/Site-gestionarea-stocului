<?php
include 'conectare.php';
session_start();

// Verifică dacă utilizatorul este autentificat și este admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: /login.php");
    exit();
}

// Verifică dacă au fost trimise date prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia valoarea ID-ului produsului din formular
    $productId = $_POST['productId'];

    // Verifică dacă ID-ul introdus este un număr valid
    if (!is_numeric($productId)) {
        // ID-ul introdus nu este un număr valid
        header("Location: /index.php?result=error");
        exit();
    }

    // Verifică dacă ID-ul produsului există în baza de date
    $sqlCheck = "SELECT ID, NumeProdus FROM stoc WHERE ID = '$productId'";
    $resultCheck = mysqli_query($conn, $sqlCheck);
    if (mysqli_num_rows($resultCheck) === 0) {
        // ID-ul produsului nu există în baza de date
        header("Location: /index.php?result=serror");
        exit();
    }

    // Preia numele produsului pentru înregistrarea în tabela "logs"
    $row = mysqli_fetch_assoc($resultCheck);
    $numeProdus = $row['NumeProdus'];

    // Efectuează operațiile de ștergere din baza de date
    $sqlDeleteStoc = "DELETE FROM stoc WHERE ID = '$productId'";
    $sqlDeleteBarmanStoc = "DELETE FROM barmanstoc WHERE ID = '$productId'";
    $sqlDeleteStocFinal = "DELETE FROM stocfinal WHERE ID = '$productId'";

    if (mysqli_query($conn, $sqlDeleteStoc) && mysqli_query($conn, $sqlDeleteBarmanStoc) && mysqli_query($conn, $sqlDeleteStocFinal)) {
        // Produsul a fost șters cu succes din stoc, barmanstoc și stocfinal

        // Adaugă înregistrarea în tabela "logs"
        $username = $_SESSION['username'];
        $actiune = "a sters produsul $numeProdus din stoc";
        $data = date('Y-m-d H:i:s');

        $sqlLogs = "INSERT INTO logs (nume, actiune, data) VALUES ('$username', '$actiune', '$data')";
        mysqli_query($conn, $sqlLogs);

        header("Location: /index.php?result=ssuccess");
        exit();
    } else {
        // A apărut o eroare la ștergerea produsului din stoc, barmanstoc sau stocfinal
        header("Location: /index.php?result=serror");
        exit();
    }

    // Încheierea conexiunii cu baza de date
    mysqli_close($conn);
}
?>
