<?php 
    
    if ($_SERVER['PHP_SELF'] == '/Proggetto_BB/index.php'){
        echo '<div class="footer">';
        echo '<br>';

        echo '<img src="./img/insta.png">';
        echo '<img src="./img/fb.jpg">';
        echo '<img src="./img/yt.png">';
        echo '<br>';
        echo '<br>';
        echo '<em>Engineered Powered by Marta Biella & Valentina Brescia</em>';
        echo '</div>';

    } else {

        echo '<div class="footer">';
        echo '<br>';
    
        echo '<img src="../img/insta.png">';
        echo '<img src="../img/fb.jpg">';
        echo '<img src="../img/yt.png">';
        echo '<br>';
        echo '<br>';
        echo '<em>Engineered & Powered by Marta Biella & Valentina Brescia</em>';
        echo '</div>';

    }

?>

<!-- background-color: #CC1020;
}

.main-tabs>.main-tab.active,
.a-teamviewer:hover
{
	color: #990C18; -->