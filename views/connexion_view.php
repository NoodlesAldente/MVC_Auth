
<div class="container">
<!--    todo afficher connexion réussite ou non !-->
    <h1>
        <?php
            if (!empty($_SESSION['user'])) {
                echo '<h1>Vous êtes connecté en tant que:</h1><br/>';
                echo '<h1 style="color: #ff0000;">' . $_SESSION['user']->pseudo_user . '</h1>';
            } else if (!empty($_SESSION['content']['connected']) ) {
                echo $_SESSION['content']['connected'];
                echo "<br/>";
                echo '<a href="./index.php?action=home">Retour à la page de connexion</a>';
            }
        ?>
    </h1>
</div>
