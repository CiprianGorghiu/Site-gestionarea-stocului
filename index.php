    <?php
    include './includes/conectare.php';
    session_start();

    // Verifică dacă utilizatorul este autentificat
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: /login.php");
        exit();
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <title>Mega-Pixel</title>
    </head>
    <body>

    <div class="modal" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-fullscreen" role="document">
        <div class="modal-content">
        <div class="modal-header p-3 mb-2 bg-dark text-white">
            <h5 class="modal-title " id="exampleModalLabel">Add Stock</h5>
            <span class="close" onclick="closeAddStockModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form action="/includes/procesare_adaugare_stoc.php" method="POST">
            <div class="form-group">
                <label for="productInput">Product Name</label>
                <input type="text" class="form-control" name="nume_produs" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label for="quantityInput">Quantity</label>
                <input type="number" class="form-control" name="cantitate" placeholder="Enter quantity" required>
            </div>
            <div class="form-group">
                <label for="priceInput">Price</label>
                <input type="number" class="form-control" name="pret" placeholder="Enter price" required>
            </div>
            <div class="modal-footer border-top-0 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
    <div class="modal" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-fullscreen" role="document">
        <div class="modal-content">
        <div class="modal-header p-3 mb-2 bg-dark text-white">
            <h5 class="modal-title " id="exampleModalLabel">Ștergere produs</h5>
        
            <span class="close" onclick="closeStergereProdusModal()">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="/includes/procesare_stergere_produs.php" method="POST">
                <div>
                    <label for="productId">ID Produs:</label>
                
                    <input type="text" class="form-control" id="productId" name="productId" placeholder="Introduceți ID-ul produsului" required>
                </div>
                <button type="submit" class="btn btn-danger">Șterge</button>
            </form>
        </div>
        </div>
    </div>
    </div>
    <?php
$result = isset($_GET['result']) ? $_GET['result'] : "";

if ($result === "asuccess") {
    echo'<div class="notificare alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-icon">
        <i class="far fa-fw fa-bell"></i>
    </div>
    <div class="alert-message">
        <strong>Success! </strong> Product added successfully!.
    </div>
    </div>';
} elseif ($result === "a1error") {
    echo'<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-icon">
        <i class="far fa-fw fa-bell"></i>
    </div>
    <div class="alert-message">
        <strong>Error! </strong> Product is already in stock!.
    </div>
    </div>';
} elseif ($result === "a2error") {
        echo'<div class="notificare alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-icon">
            <i class="far fa-fw fa-bell"></i>
        </div>
        <div class="alert-message">
            <strong>SucceErrorss! </strong>Try again later!.
        </div>
        </div>';
        
} elseif ($result === "ssuccess") {
    echo'<div class="notificare alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-icon">
        <i class="far fa-fw fa-bell"></i>
    </div>
    <div class="alert-message">
        <strong>Success! </strong> Product has been deleted with successfully!.
    </div>
    </div>';
} 
?>

    <div class="content">
        
        <div class="tabel-stoc">
            
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) : ?>
            <div class="admin-panel">
        
            <div class="div-header p-3 mb-2 bg-dark text-white">
            <h4><i class="fas fa-users-cog"></i> Admin Panel<h4> 
        </div>
            <div class="comenzi">
                <button type="button" class="btn btn-primary" onclick="openAddStockModal()"><i class="far fa-edit"></i> Adauga Stoc</button>
                <a href="logs.php" class="btn btn-success"><i class="fas fa-history"></i> Loguri </a>
                <a href="raport.php" class="btn btn-dark  "><i class="fas fa-chart-bar"></i> Raport </a>
                <button type="button" class="btn btn-warning" onclick="openStergereProdusModal()"><i class="fas fa-trash"></i> Sterge produs din stoc</button>
                <hr>
                <form action="/includes/logout.php" method="POST">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-door-open"></i> Log Out</button>
                </form>
            </div>
        </div>



        <?php

// Interogare pentru a obține datele din tabela "stocfinal"
$sql = "SELECT * FROM stocfinal";
$result = mysqli_query($conn, $sql);

$totalPriceSold = 0;
?>

<table class="tabelul table table-dark table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th><i class="fas fa-sort-alpha-down"></i> Nume Produs</th>
            <th><i class="fas fa-user"> Nume Barman</th>
            <th>Stoc Precedent</th>
            <th>Stoc Actual</th>
            <th>Pret * cantitate vanduta</th>
        </tr>
    </thead>
    <tbody>
            
    <?php
   
    while ($row = mysqli_fetch_assoc($result)) {
        $productName = $row['NumeProdus'];
        $barmanName = $row['numebarman'];
        $previousStock = $row['StocPrecedent'];
        $newStock = $row['StocActual'];
        $productPrice = $row['PretProdus'];
        $id = $row['ID'];
        
        // Calculează prețul produsului vândut
        $productQuantitySold = $previousStock - $newStock;
        $productPriceSold = $productPrice * $productQuantitySold;

        // Calculează prețul total al produselor vândute
        $totalQuantitySold = $newStock;
        $totalPriceSold += $productPriceSold;

        // Actualizează valorile în tabela "stocfinal"
        $sqlUpdate = "UPDATE stocfinal SET Pret = $productPriceSold, PretTotal = $totalPriceSold WHERE NumeProdus = '$productName' AND numebarman = '$barmanName'";
        mysqli_query($conn, $sqlUpdate);

          // Verifică dacă StocActual este 0 și adaugă clasa "danger" în rândul produsului
    $rowClass = ($newStock == 0) ? "table table-danger" : "";
    ?>
         <tr class="<?php echo $rowClass; ?>">
            <td><?php echo  $id ?></td>
            <td><?php echo $productName; ?></td>
            <td><?php echo $barmanName; ?></td>
            <td><?php echo $previousStock; ?></td>
            <td><?php echo $newStock; ?></td>
            <td><?php echo $productPriceSold; ?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
    <?php if (mysqli_num_rows($result) > 0) : ?>
    <tfoot class="table table-success">
        <tr>
            <td></td>
            <td class="info" colspan="2"><i>Stoc actualizat de <b><?php echo $barmanName; ?></b> la data de <b><?php echo date('d/m/Y'); ?><b><i></td>
            <td></td>
            <td><i>Pret Total:</i></td>
            <td><b><?php echo $totalPriceSold; ?> RON<b></td>
        </tr>
    </tfoot>
    <?php endif; ?>
</table>
    </div>


<?php endif; ?> 
<?php if (isset($_SESSION['barman']) && $_SESSION['barman'] === true) : ?>
<div class="barman-panel">
    <form action="/includes/update_stock.php" method="POST">
    <table class="tabel-bar table table-hover table-dark">
    <thead class="table-danger">
        <tr>
            <th scope="col"><i class="fas fa-sort-alpha-up-alt"></i> Nume Produs</th>
            <th scope="col"><i class="fas fa-database"></i> Stoc</th>
        </tr>
    </thead>
            <tbody>
                <?php
                $sql = "SELECT id, numeprodus, StocProdus FROM stoc";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['numeprodus'] . "</td>";
                    echo "<td><input type='number' required name='stock_" . $row['id'] . "'</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
            $sql = "SELECT COUNT(*) as count FROM barmanstoc";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];

            $isTableEmpty = ($count == 0);
            ?>
            <button type="submit" class="btn btn-success" <?php if ($isTableEmpty) echo "disabled"; ?>>Preda stocul <i class="fas fa-paper-plane"></i></button>
        </form>
    </form>
    <hr>
    <div class="action">
                <form action="/includes/logout.php" method="POST">
               
                    <button type="submit" class="btn btn-danger"><i class="fas fa-door-open"></i> Log Out</button>
                </form>
</div>
</div>

<?php endif; ?> 
            </div>    

    </div>
 
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="javascript.js"></script>
    </body>
    </html>
