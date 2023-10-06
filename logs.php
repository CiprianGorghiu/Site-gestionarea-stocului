<?php
include './includes/conectare.php';
session_start();

// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /login.php");
    exit();
}

// Verifică dacă utilizatorul este administrator
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: /login.php"); // Redirecționează utilizatorii non-admin către o pagină de restricție
    exit();
}

// Verifică dacă a fost trimisă o cerere de căutare
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $searchDate = isset($_GET['date']) ? $_GET['date'] : '';

    // Interogare pentru a obține datele din tabela "logs" filtrate după nume sau dată
    if (!empty($searchTerm) && !empty($searchDate)) {
        $sql = "SELECT nume, actiune, data FROM logs WHERE nume LIKE '%$searchTerm%' OR data LIKE '%$searchDate%'";
    } elseif (!empty($searchTerm)) {
        $sql = "SELECT nume, actiune, data FROM logs WHERE nume LIKE '%$searchTerm%'";
    } elseif (!empty($searchDate)) {
        $sql = "SELECT nume, actiune, data FROM logs WHERE data LIKE '%$searchDate%'";
    } else {
        // Afiseaza doar log-urile din ziua curenta
        $currentDate = date('Y-m-d');
        $sql = "SELECT nume, actiune, data FROM logs WHERE DATE(data) = '$currentDate'";
    }
} else {
    // Interogare pentru a obține toate datele din tabela "logs"
    $sql = "SELECT nume, actiune, data FROM logs";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Adaugă stilurile Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <title>Mega-Pixel</title>
</head>
<body>
    <div class="log">
        <div class="tabel-log">
            <div class="cautare">
                <form method="GET" action="">
                    <div class="inputuri">
                        <input type="text" class="form-control" placeholder="Caută nume barman" name="search">
                        <input type="date" class="form-control" placeholder="Caută după dată" name="date">
                        <button class="btn btn-primary" type="submit">Caută <i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <table class="table table-dark table-hover">
                
                <thead class="table table-danger">
                    <tr>
                        <th><i class="fas fa-user"></i> Nume</th>
                        <th><i class="fas fa-cog"></i> Acțiune</th>
                        <th><i class="fas fa-clock"></i> Data</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $nume = $row['nume'];
                    $actiune = $row['actiune'];
                    $data = $row['data'];
                ?>
                    <tr>
                        <td><?php echo $nume; ?></td>
                        <td><?php echo $actiune; ?></td>
                        <td><?php echo $data; ?></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="javascript.js"></script>
</body>
</html>
