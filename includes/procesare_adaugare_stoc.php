<?php
include 'conectare.php';
session_start();

// Verifică dacă au fost trimise date prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia valorile din formular
    $numeProdus = $_POST['nume_produs'];
    $cantitate = $_POST['cantitate'];
    $pret = $_POST['pret'];

    // Verifică dacă produsul există deja în tabela "Stoc"
    $sqlCheck = "SELECT * FROM stoc WHERE NumeProdus='$numeProdus'";
    $resultCheck = mysqli_query($conn, $sqlCheck);
    if (mysqli_num_rows($resultCheck) > 0) {
        // Produsul există deja în tabela "Stoc", afișează eroarea
        header("Location: /index.php?result=a1error&message=Produsul există deja în stoc");
        exit();
    }

    // Efectuează operațiile de adăugare în baza de date
    $sqlStoc = "INSERT INTO stoc (NumeProdus, StocProdus, Pret) VALUES ('$numeProdus', '$cantitate', '$pret')";
    $sqlbarmanstoc = "INSERT INTO barmanstoc (NumeProdus, StocProdus, Pret, numebarman) VALUES ('$numeProdus', '$cantitate', '$pret', 'Admin')";

    if (mysqli_query($conn, $sqlStoc) && mysqli_query($conn, $sqlbarmanstoc)) {
        // Produsul a fost adăugat cu succes în tabela "Stoc" și "barmanstoc"

        // Inserează înregistrarea în tabela "stocfinal" și actualizează prețul
        $sqlStocFinal = "INSERT INTO stocfinal (NumeProdus, numebarman, StocPrecedent, StocActual, Pret,PretProdus, PretTotal) VALUES ('$numeProdus', 'Admin', 0, '$cantitate', 0,'$pret', 0)";
        mysqli_query($conn, $sqlStocFinal);

        // Adaugă înregistrarea în tabela "logs"
        $username = $_SESSION['username'];
        $actiune = "a adaugat $cantitate bucati din produsul $numeProdus în stoc";
        $data = date('Y-m-d H:i:s');

        $sqlLogs = "INSERT INTO logs (nume, actiune, data) VALUES ('$username', '$actiune', '$data')";
        mysqli_query($conn, $sqlLogs);

        header("Location: /index.php?result=asuccess");
        exit();
    } else {
        // A apărut o eroare la adăugarea produsului în stoc
        echo "Eroare la adăugarea produsului în stoc: " . mysqli_error($conn);
    exit();
    }

    // Încheierea conexiunii cu baza de date
    mysqli_close($conn);
}
?>
