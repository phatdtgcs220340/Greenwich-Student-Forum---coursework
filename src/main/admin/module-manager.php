<?php
    session_start();
    if (isset($_SESSION['role'])) {
        echo $_SESSION['role'];
    if ($_SESSION['role'] != 'Admin') {
        header("Location: ../error/access-denied.php");
        exit;
    }
}
?>