
<div class="container">
<!--    todo afficher connexion réussite ou non !-->
    <h1>
        <?php
            if (!empty($_SESSION['content']['connected']) ) {
                echo '<h2>' . $_SESSION['content']['connected'] . '</h2>';
                echo "<br/>";
            }
            echo '<a href="./index.php?action=home">Retour à la page préscédante</a>';
        ?>
    </h1>
</div>
