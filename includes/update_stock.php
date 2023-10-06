<?php
include 'conectare.php';

// Verifică dacă s-a trimis formularul
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obține numele barmanului din sesiune
    session_start();
    $barmanName = $_SESSION['barman_name'];

    // Obține ora curentă
    date_default_timezone_set('Europe/Bucharest');
    $currentHour = date('H');

    // Stabilește tura în funcție de ora curentă
    $tour = '';
    if (($currentHour >= 7 && $currentHour < 19) || ($currentHour >= 0 && $currentHour < 7)) {
        $tour = 'Tura de dimineata';
    } elseif ($currentHour >= 19 && $currentHour < 24) {
        $tour = 'Tura de seara';
    }

    // Parcurge toate câmpurile trimise prin POST
    foreach ($_POST as $key => $value) {
        // Verifică dacă câmpul începe cu "stock_"
        if (strpos($key, 'stock_') === 0) {
            // Extrage ID-ul produsului din numele câmpului
            $productId = substr($key, strlen('stock_'));

            // Obține vechiul stoc și numele produsului din tabela "stocfinal"
            $sqlGetPreviousStock = "SELECT StocActual, NumeProdus, PretProdus FROM stocfinal WHERE id = $productId";
            $resultPreviousStock = mysqli_query($conn, $sqlGetPreviousStock);

            if ($resultPreviousStock !== false && mysqli_num_rows($resultPreviousStock) > 0) {
                $rowPreviousStock = mysqli_fetch_assoc($resultPreviousStock);
                $previousStock = $rowPreviousStock['StocActual'];
                $productName = $rowPreviousStock['NumeProdus'] ?? '';
                $productPrice = $rowPreviousStock['PretProdus'];

                // Actualizează stocul precedent în tabela "stocfinal"
                $sqlUpdatePreviousStock = "UPDATE stocfinal SET StocPrecedent = $previousStock WHERE id = $productId";
                mysqli_query($conn, $sqlUpdatePreviousStock);

                // Actualizează stocul produsului în tabela "barmanstoc"
                $newStock = intval($value); // Asigură-te că este un număr întreg
                $sqlUpdateStock = "UPDATE barmanstoc SET StocProdus = $newStock, NumeBarman = '$barmanName', Tura = '$tour' WHERE id = $productId";
                mysqli_query($conn, $sqlUpdateStock);

                // Actualizează numele barmanului în tabela "stocfinal"
                $sqlUpdateBarmanName = "UPDATE stocfinal SET NumeBarman = '$barmanName' WHERE id = $productId";
                mysqli_query($conn, $sqlUpdateBarmanName);

                // Verifică dacă există deja o înregistrare pentru acest produs în tabela "stocfinal"
                $sqlCheck = "SELECT * FROM stocfinal WHERE id = $productId";
                $resultCheck = mysqli_query($conn, $sqlCheck);

                if ($resultCheck !== false && mysqli_num_rows($resultCheck) > 0) {
                    // Actualizează stocul produsului în tabela "stocfinal"
                    $sqlUpdate = "UPDATE stocfinal SET StocActual = $newStock WHERE id = $productId";
                    mysqli_query($conn, $sqlUpdate);
                } else {
                    // Inserează o nouă înregistrare în tabela "stocfinal"
                    $sqlInsert = "INSERT INTO stocfinal (id, NumeProdus, NumeBarman, StocPrecedent, StocActual, PretProdus, Tura) VALUES ($productId, '$productName', '$barmanName', $previousStock, $newStock, $productPrice, '$tour')";
                    mysqli_query($conn, $sqlInsert);
                }

                // Inserează înregistrare în tabela "raportbarman"
                $sqlInsertRaport = "INSERT INTO raportbarman (NumeProdus, StocInitial, StocPredat, NumeBarman, PretProdus, Tura) VALUES ('$productName', $previousStock, $newStock, '$barmanName', $productPrice, '$tour')";
                mysqli_query($conn, $sqlInsertRaport);
            }
        }
    }

    // Verifică erorile la nivelul bazei de date
    if (mysqli_error($conn)) {
        echo "Eroare MySQL: " . mysqli_error($conn);
    }

    // Adaugă înregistrare în tabela "logs"
    $action = "predat stocul";
    $sqlLogs = "INSERT INTO logs (nume, actiune) VALUES ('$barmanName', '$action')";
    mysqli_query($conn, $sqlLogs);

    // Redirecționează către pagina principală după actualizare
    header("Location: /index.php");
    exit();
}
?>
