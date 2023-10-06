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

// Variabilele pentru căutare
$searchDate = '';
$searchShift = '';

// Verifică dacă s-au trimis date prin metoda POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preia valorile din formular
    $searchDate = $_POST['searchDate'];
    $searchShift = $_POST['searchShift'];
}

// Variabile pentru paginare
$perPage = 10; // Numărul de înregistrări afișate pe pagină
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1; // Pagina curentă

// Construiește clauza WHERE în funcție de opțiunile de căutare
$whereClause = '';
if (!empty($searchDate)) {
    $whereClause .= " AND DATE_FORMAT(data, '%Y-%m-%d') = '$searchDate'";
}
if (!empty($searchShift)) {
    $whereClause .= " AND Tura = '$searchShift'";
}

// Interogare pentru a obține numărul total de înregistrări conform opțiunilor de căutare
$sqlCount = "SELECT COUNT(*) AS total FROM raportbarman WHERE 1 $whereClause";
$resultCount = mysqli_query($conn, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalRecords = $rowCount['total'];

// Calculează numărul total de pagini
$totalPages = ceil($totalRecords / $perPage);

// Verifică și ajustează pagina curentă dacă este în afara intervalului valid
if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

// Calculează offset-ul pentru interogarea principală
$offset = ($currentPage - 1) * $perPage;

// Interogare pentru a obține informațiile din tabela raportbarman conform opțiunilor de căutare și paginare
$sqlLogs = "SELECT NumeProdus, StocInitial, StocPredat, PretProdus, Tura, data FROM raportbarman WHERE 1 $whereClause LIMIT $offset, $perPage";
$resultLogs = mysqli_query($conn, $sqlLogs);

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
        <form method="POST" class="search-form">
                <div class="inputuri">
           
                    <input type="date" id="searchDate" name="searchDate" class="form-control" value="<?php echo $searchDate; ?>">
                    <br>
                    <select id="searchShift" name="searchShift" class="form-select">
                        <option value="">Toate</option>
                        <option value="Tura de dimineata" <?php if ($searchShift === 'Tura de dimineata') echo 'selected'; ?>>Tura de dimineata</option>
                        <option value="Tura de seara" <?php if ($searchShift === 'Tura de seara') echo 'selected'; ?>>Tura de seara</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Cauta</button>
                </div>
                
            </form>

        </div>
        
            <table class="table table-dark table-hover">
                
                <thead class="table table-danger">
                    <tr>
                        <th><i class="fas fa-cube"></i> Nume Produs</th>
                        <th><i class="fas fa-sort-amount-up"></i> Stoc Initial</th>
                        <th><i class="fas fa-sort-amount-down"></i> Stoc Predat</th>
                        <th><i class="fas fa-dollar-sign"></i> Pret Produs</th>
                        <th><i class="fas fa-clock"></i> Tura</th>
                        <th><i class="fas fa-calendar"></i> Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verifică dacă există înregistrări în tabela raportbarman pentru opțiunile de căutare
                    if ($resultLogs !== false && mysqli_num_rows($resultLogs) > 0) {
                        while ($rowLogs = mysqli_fetch_assoc($resultLogs)) {
                            $numeProdus = $rowLogs['NumeProdus'];
                            $stocInitial = $rowLogs['StocInitial'];
                            $stocPredat = $rowLogs['StocPredat'];
                            $pretProdus = $rowLogs['PretProdus'];
                            $tura = $rowLogs['Tura'];
                            $data = $rowLogs['data'];
                            ?>
                            <tr>
                                <td><?php echo $numeProdus; ?></td>
                                <td><?php echo $stocInitial; ?></td>
                                <td><?php echo $stocPredat; ?></td>
                                <td><?php echo $pretProdus; ?></td>
                                <td><?php echo $tura; ?></td>
                                <td><?php echo $data; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6">Nu există înregistrări în tabela raportbarman pentru opțiunile de căutare selectate.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <div class="pagination">
            <ul class="pagination-list">
                <?php
                // Afiseaza link-urile de paginare
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i === $currentPage) ? 'active' : '';
                    echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                ?>
            </ul>
        </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
