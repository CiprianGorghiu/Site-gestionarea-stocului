<?php
//conectare la baza de date
$conn = mysqli_connect("localhost", "root", "", "test");

//verifică conexiunea
if (!$conn) {
    die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
}
?>