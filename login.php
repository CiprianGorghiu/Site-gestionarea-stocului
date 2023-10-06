<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php 
        include './includes/conectare.php';
    
        session_start();
        
        // Check if there is an error parameter in the URL
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            $error_message = "Nume de utilizator sau parolă incorecte!";
        }
    ?>
   
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <?php echo $error_message; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="content">
<div class="logare">
  <div class="logo-logare">
   <img src="https://globalcincinnati.org/wp-content/uploads/2017/10/icon_membership_individual.png" alt="logo">
  </div>
    <form method="post"  action="./includes/logare.php">
    <div class="username">
        <input type="text" required placeholder="Username" name="username" id="username">
    </div>
    <div class="password">
        <input type="password" required placeholder="Password" name="password" id="password">
    </div>

<div class="login">
<button class="btn btn-primary"  type="submit">Autentificare</button>
</div>
</form>

</div>

</div>
</body>
</html>