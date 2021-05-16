<?php
    // Plik główny portoflio
    // Aplikację strorzył Dorian Kiewro (Kier).
    // Twitter @DKiewro
    // GitHub https://github.com/DorianKier
    // E-mail dorian.kiewro@gmail.com

    include('config.php');
    error_reporting(0);
    if($_GET['content'] == NULL){
        echo '<script>document.location="index?content=home";</script>';
    }
    else{
        $content = $_GET['content'];
    }
    $idContentR = $dbh -> query("SELECT * FROM nav WHERE nav='".$content."';");
    $idContent = $idContentR -> fetch();
    $idNav = $idContent['id'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title>
        <?php
            $titleR = $dbh -> query("SELECT * FROM head WHERE name='title';");
            $title = $titleR -> fetch();
            print $title['content'];
        ?>
    </title>
    <meta name="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Witam, jestem zaczynającym programistą! Przedstawiam moje portfolio z moimi social mediami oraz dostępem do projektów."/>
    <meta name="keywords" content="portfolio, webmaster, programista, html, php, css, js, javascript, jqeury, arduino, github, twitter, back, edn, back-end, back-endowiec"/>
    <meta name="author" content="Dorian Kiewro"/>
    <link rel="icon" href="img/icon.png" sizes="16x16" type="image/png">
    <link href="css/fontello.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"/>
    <link href="css/mobile.css" rel="stylesheet"/>
    <?php
        require 'css/styleCustom.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("*").css({ opacity: "0.95" });
            $("*").animate({ opacity: "1" }, 500);
        });
    </script>
</head>
<body>
    <header>
        <!-- Nagłówek -->
        <h1>
            <?php
                $headerR = $dbh -> query("SELECT * FROM body WHERE name='header';");
                $header = $headerR -> fetch();
                print $header['content'];
            ?>
        </h1>
    </header>
    <nav>
        <!-- Nawigacja -->
        <ul>
            <?php
                $navR = $dbh -> query("SELECT * FROM nav;");
                while($nav = $navR -> fetch()){
                    print '<li><a href="index?content='.$nav['nav'].'">'.$nav['nav'].'</a></li>';
                }
            ?>
        </ul>
    </nav>
    <main>
        <!-- Kontent -->
        <?php
            $mainR = $dbh -> query("SELECT * FROM main WHERE nav='".$idNav."';");
            $main = $mainR -> fetch();
            print $main['content'];
        ?>
    </main>
    <footer>
        <!-- Stopka -->
        <?php
            $footerR = $dbh -> query("SELECT * FROM body WHERE name='footer';");
            $footer = $footerR -> fetch();
            print $footer['content'];
        ?>
        <div id="footer-container">
            <div id="contact">
                <!-- miejsce na kontakt -->
                <?php
                    $contactR = $dbh -> query("SELECT * FROM body WHERE name='contact';");
                    $contact = $contactR -> fetch();
                    print $contact['content'];
                ?>
            </div>
            <div id="social_media">
                <!-- miejsce na social media -->
                <?php
                    $socialMediaR = $dbh -> query("SELECT * FROM body WHERE name='social_media';");
                    $socialMedia = $socialMediaR -> fetch();
                    print $socialMedia['content'];
                ?>
            </div>
        </div>
        <!-- sprostowanie float: left; -->
        <div style="clear: both; margin-bottom: 15px;"></div>
        <span style="opacity: 0.5;">Stronę wykonał: Dorian Kiewro &nbsp;<br id="brhiddenmobile" /> dorian.kiewro@gmail.com &nbsp;<br id="brhiddenmobile" /> tel.kom. 885 211 808</span>
    </footer>
</body>
</html>