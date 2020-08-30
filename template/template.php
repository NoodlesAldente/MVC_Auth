<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <?php
    echo isset($linkScript) ? $linkScript : ''; // Affichage des script
    ?>
    <script>
        <?php
        if (isset($_SESSION['rsa'])) {
            echo "var rsaPublicKey = `" . $_SESSION["rsa"] . "`;"; // Create the js variable for the public key
        }
        ?>
    </script>
    <title>Authentication App</title>
</head>
<body>
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark  bg-primary">
    <a class="navbar-brand" href="./index.php?action=home">Home</a>
    <?php
    if (!empty($_SESSION['user'])) {
    ?>
    <a class="navbar-brand" href="./index.php?action=deconnexion">deconnexion</a>
    <?php
    }
    ?>
</nav>

<!--/.Navbar -->
<div class="jumbotron bg-light">
    <h1 class="display-4">Secure Your authentication</h1>
    <p class="lead">What's 99% secure is not secure.</p>
    <hr class="my-4">
    <p>this application is only used in the context of learning how to secure user authentication</p>
    <p> Mot de passe par défaut : 1xxxxxX! </p>
</div>
<?php
    if (!empty($total_link_view)) {
        require_once $total_link_view;
    }
?>
<!-- Footer -->
<!-- Footer -->
<footer class="page-footer font-small bg-primar fixed-bottom">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3 bg-primary">© 2020 Copyright:
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->
<!-- Footer -->
</body>
</html>