<?php

if ($_SERVER['PHP_SELF'] == '/Proggetto_BB/index.php') {
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

<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.1/flickity.min.css" integrity="sha512-ztsAq/T5Mif7onFaDEa5wsi2yyDn5ygdVwSSQ4iok5BPJQGYz1CoXWZSA7OgwGWrxrSrbF0K85PD5uLpimu4eQ==" crossorigin="anonymous" />
<script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>

<script>
    ScrollReveal().reveal('.reveal', {
        distance: '100px',
        duration: 1500,
        easing: 'cubic-bezier(.215, .61, .355, 1)',
        interval: 600
    });
    ScrollReveal().reveal('.oom', {
        duration: 1500,
        easing: 'cubic-bezier(.215, .61, .355, 1)',
        interval: 200,
        scale: 0.65,
        mobile: false
    });
</script>

<!-- background-color: #CC1020;
}

.main-tabs>.main-tab.active,
.a-teamviewer:hover
{
	color: #990C18; -->