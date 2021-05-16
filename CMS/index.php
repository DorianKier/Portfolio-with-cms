<!--Plik główny portoflio CMS
Aplikację strorzył Dorian Kiewro (Kier).
Twitter @DKiewro
GitHub https://github.com/DorianKier
E-mail dorian.kiewro@gmail.com-->
<?php
    include('config.php');
    error_reporting(0);
    session_start();
    if($_SESSION['user'] == ''){
        echo '<script>alert("Użytkownik nie został zalogowany!");window.location="login";</script>';
        exit;
    }
    $action = $_GET['action'];
    $id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title>CMS Portfolio</title>
    <meta name="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dorian Kiewro"/>
    <link rel="icon" href="img/icon.png" sizes="16x16" type="image/png">
    <link href="css/fontello.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"/>
    <link href="css/mobile.css" rel="stylesheet"/>
</head>
<body>
    <?php
        require 'header.php';
        require 'nav.php';
    ?>
    <main>
        <!-- Kontent -->
        <?php
            // Edytowanie nazwy zakładek strony
            if($action == 'head'){
                if(!isset($_POST['akceptuj']) == ''){
                    $updateTitle = $dbh -> prepare("UPDATE head SET content=:title WHERE name='title';");
                    $updateTitle -> bindParam(":title", $_POST['titleMyPage'], PDO::PARAM_STR);
                    $updateTitle -> execute();
                    echo '<script>alert("Zmiania tytułu na pasku zakładek powiodła się");window.location="index"</script>';
                }
                else{
                    $titleR = $dbh -> query("SELECT * FROM head WHERE name='title';");
                    $title = $titleR -> fetch();
                    print '<form method="POST"><table>';
                    print '<tr><td>Napis na pasku zakładek (title)</td></tr>';
                    print '<tr><td><input type="text" name="titleMyPage" value="'.$title['content'].'" width="100" required/></td></tr>';
                    print '<tr><td><input type="submit" name="akceptuj" value="Zapisz zmiany"></td></tr>';
                    print '</table></form>';
                }
            }
            // Edytowanie nagłóka głównego strony portfolio
            else if($action == 'body'){
                if(!isset($_POST['akceptuj']) == ''){
                    $updateHeader = $dbh -> prepare("UPDATE body SET content=:header WHERE name='header';");
                    $updateHeader -> bindParam(":header", $_POST['headerMyPage'], PDO::PARAM_STR);
                    $updateHeader -> execute();
                    echo '<script>alert("Zmiania tytułu na pasku zakładek powiodła się");window.location="index"</script>';
                }
                else{
                    $headerR = $dbh -> query("SELECT * FROM body WHERE name='header';");
                    $header = $headerR -> fetch();
                    print '<form method="POST"><table>';
                    print '<tr><td>Nagłówek portfolio (header)</td></tr>';
                    print '<tr><td><input type="text" name="headerMyPage" value="'.$header['content'].'" required/></td></tr>';
                    print '<tr><td><input type="submit" name="akceptuj" value="Zapisz zmiany"></td></tr>';
                    print '</table></form>';
                }
            }
            // Edytowania nawigacji portfolio
            else if($action == 'navigation'){
                if(!isset($_POST['akceptuj']) == ''){
                    $clearMain = "";
                    $addNavigation = $dbh -> prepare("INSERT INTO nav (`nav`) VALUES (:nav)");
                    $addNavigation -> bindParam(":nav", $_POST['navMyPage'], PDO::PARAM_STR);
                    $addNavigation -> execute();
                    $selectNavIDR = $dbh -> query("SELECT * FROM nav ORDER BY id DESC;");
                    $selectNavID = $selectNavIDR -> fetch();
                    $addMain = $dbh -> prepare("INSERT INTO main (`nav`,`content`) VALUES (:idNav, :content)");
                    $addMain -> bindParam(":idNav", $selectNavID['id'], PDO::PARAM_STR);
                    $addMain -> bindParam(":content", $clearMain, PDO::PARAM_STR);
                    $addMain -> execute();
                    echo '<script>alert("Zmiania tytułu na pasku zakładek powiodła się");window.location="index?action=navigation"</script>';
                }
                else{
                    $navigationR = $dbh -> query("SELECT * FROM nav;");
                    print '<form method="POST"><table>';
                    print '<tr><td colspan="100%">Nawigacja (nav)</td></tr>';
                    while($navigation = $navigationR -> fetch()){
                        print '<tr><td>'.$navigation['nav'].'</td><td><a class="updateMain" href="index?action=mainUpdate&id='.$navigation['id'].'">Zawartość</a></td><td><a class="deleteNav" href="index?action=navigationDelete&id='.$navigation['id'].'">X</a></td></tr>';
                    }
                    print '<tr><td><input type="text" name="navMyPage" required/></td><td><input type="submit" name="akceptuj" value="Dodaj"></td></tr>';
                    print '</table></form>';
                }
            }
            // Edytowanie zawartości zakładek z nawigacji
            else if($action == 'mainUpdate'){
                if($id != ''){
                    if(!isset($_POST['akceptuj']) == ''){
                        $updateMain = $dbh -> prepare("UPDATE main SET content=:main WHERE nav='".$id."';");
                        $updateMain -> bindParam(":main", $_POST['mainMyPage'], PDO::PARAM_STR);
                        $updateMain -> execute();
                        echo '<script>alert("Zmiania zawartości zakładki powiodła się");window.location="index?action=navigation"</script>';
                    }
                    else{
                        $navR = $dbh -> query("SELECT * FROM nav WHERE id='".$id."';");
                        $nav = $navR -> fetch();
                        print '<form method="POST"><table>';
                        print '<tr><td>Zawartość: '.$nav['nav'].'</td></tr>';
                        $mainR = $dbh -> query("SELECT * FROM main WHERE nav='".$id."';");
                        $main = $mainR -> fetch();
                        print '<tr><td><textarea name="mainMyPage" style="width: 300px; min-height: 80px;" required>'.$main['content'].'</textarea></td></tr>';
                        print '<tr><td><input type="submit" name="akceptuj" value="Zapisz zmiany"></td></tr>';
                        print '</table></form>';
                    }
                }
                else{
                    echo '<script>alert("Brak identyfikatora navigatora do edytowania!");window.location="index?action=navigation"</script>';
                }
            }
            // Usuwanie navigacji
            else if($action == 'navigationDelete'){
                if($id != ''){
                    $navDeleteR = $dbh -> query("DELETE FROM nav WHERE id='".$id."';");
                    $navDelete = $navDeleteR -> fetch();
                    echo '<script>alert("Usunięto wybraną pozycję!");window.location="index?action=navigation"</script>';
                }
                else{
                    echo '<script>alert("Brak identyfikatora navigatora do usunięcia!");window.location="index?action=navigation"</script>';
                }
            }
            // Edytowanie stópki strony
            else if($action == 'footer'){
                if(!isset($_POST['akceptuj']) == ''){
                    $updateFooter = $dbh -> prepare("UPDATE body SET content=:footer WHERE name='footer';");
                    $updateFooter -> bindParam(":footer", $_POST['footerMyPage'], PDO::PARAM_STR);
                    $updateFooter -> execute();
                    echo '<script>alert("Zmiania zawartości stopki powiodła się");window.location="index"</script>';
                }
                else{
                    $footerR = $dbh -> query("SELECT * FROM body WHERE name='footer';");
                    $footer = $footerR -> fetch();
                    print '<form method="POST"><table>';
                    print '<tr><td>Stópka twojego portfolio (footer)*</td></tr>';
                    print '<tr><td><textarea name="footerMyPage" style="width: 200px; min-height: 80px; max-width: 800px;">'.$footer['content'].'</textarea></td></tr>';
                    print '<tr><td><input type="submit" name="akceptuj" value="Zapisz zmiany"></td></tr>';
                    print '<tr><td><sup>* pole nie jest obowiązkowe na stronie (może zostać puste)</sup></td></tr>';
                    print '</table></form>';
                }
            }
            // Edytowanie kontaktów w stópce
            else if($action == 'kontakt'){
                if(!isset($_POST['akceptuj']) == ''){
                    $updateContact = $dbh -> prepare("UPDATE body SET content=:contact WHERE name='contact';");
                    $updateContact -> bindParam(":contact", $_POST['contactMyPage'], PDO::PARAM_STR);
                    $updateContact -> execute();
                    echo '<script>alert("Zmiania zawartości kontaktu powiodła się");window.location="index"</script>';
                }
                else{
                    $contactR = $dbh -> query("SELECT * FROM body WHERE name='contact';");
                    $contact = $contactR -> fetch();
                    print '<form method="POST"><table>';
                    print '<tr><td>Kontakty w stópce strony</td></tr>';
                    print '<tr><td><textarea name="contactMyPage" style="width: 200px; min-height: 80px; max-width: 800px;">'.$contact['content'].'</textarea></td></tr>';
                    print '<tr><td><input type="submit" name="akceptuj" value="Zapisz zmiany"></td></tr>';
                    print '</table></form>';
                }
            }
            // Edytowanie social mediów w stópce
            else if($action == 'socialmedia'){
                if(!isset($_POST['akceptuj']) == ''){
                    $updateSocialMedia = $dbh -> prepare("UPDATE body SET content=:media WHERE name='social_media';");
                    $updateSocialMedia -> bindParam(":media", $_POST['mediaMyPage'], PDO::PARAM_STR);
                    $updateSocialMedia -> execute();
                    echo '<script>alert("Zmiania zawartości stopki powiodła się");window.location="index"</script>';
                }
                else{
                    $socialMediaR = $dbh -> query("SELECT * FROM body WHERE name='social_media';");
                    $socialMedia = $socialMediaR -> fetch();
                    print '<form method="POST"><table>';
                    print '<tr><td>Social media w stópce strony</td></tr>';
                    print '<tr><td><textarea name="mediaMyPage" style="width: 200px; min-height: 80px; max-width: 800px;">'.$socialMedia['content'].'</textarea></td></tr>';
                    print '<tr><td><input type="submit" name="akceptuj" value="Zapisz zmiany"></td></tr>';
                    print '</table></form>';
                }
            }
            // Edytowanie stylów w całym dokumencie
            // Zmienne z bazy danych odwołują się do pliku wewnątrz html sekcji <head>
            // Mają pierwszeństwo przed dokumentami style.css oraz mobile.css
            else if($action == 'style'){
                if($id == "1"){
                    if(isset($_POST['accept'])){
                        $updateStyle = $dbh -> prepare("UPDATE `style` SET content=:linkToFont WHERE style='link-to-font';
                            UPDATE `style` SET content=:fontFamily WHERE style='font-family';
                            UPDATE `style` SET content=:font WHERE style='font';
                            UPDATE `style` SET content=:background WHERE style='background';");
                        $updateStyle -> bindParam(":linkToFont", $_POST['importFont'], PDO::PARAM_STR);
                        $updateStyle -> bindParam(":fontFamily", $_POST['fontFamily'], PDO::PARAM_STR);
                        $updateStyle -> bindParam(":font", $_POST['font'], PDO::PARAM_STR);
                        $updateStyle -> bindParam(":background", $_POST['background'], PDO::PARAM_STR);
                        $updateStyle -> execute();
                        echo '<script>alert("Zmiania stylów w całym dokumencie się powiodła");window.location="index?action=style"</script>';
                    }
                    else{
                        $selectStyleImportR = $dbh -> query("SELECT * FROM style WHERE style='link-to-font';");
                        $selectStyleImport = $selectStyleImportR -> fetch();
                        $selectStyleFontFamilyR = $dbh -> query("SELECT * FROM style WHERE style='font-family';");
                        $selectStyleFontFamily = $selectStyleFontFamilyR -> fetch();
                        $selectStyleFontColorR = $dbh -> query("SELECT * FROM style WHERE style='font';");
                        $selectStyleFontColor = $selectStyleFontColorR -> fetch();
                        $selectStyleBGColorR = $dbh -> query("SELECT * FROM style WHERE style='background';");
                        $selectStyleBGColor = $selectStyleBGColorR -> fetch();
                        print '<form method="POST"><table>';
                        print '<tr><td colspan="100%">Zmiania stylu dla całej zawartości</td></tr>';
                        print '<tr><td>@import</td><td><textarea name="importFont">'.$selectStyleImport['content'].'</textarea></td></tr>';
                        print '<tr><td>Font-family</td><td><textarea name="fontFamily">'.$selectStyleFontFamily['content'].'</textarea></td></tr>';
                        print '<tr><td>Font-color</td><td><textarea name="font">'.$selectStyleFontColor['content'].'</textarea></td></tr>';
                        print '<tr><td>Background-color</td><td><textarea name="background">'.$selectStyleBGColor['content'].'</textarea></td></tr>';
                        print '<tr><td colspan="100%"><input type="submit" name="accept" value="Zapisz"></td></tr>';
                        print '</table></form>';
                    }
                }
                else if($id == "2"){
                    if(isset($_POST['accept'])){
                        $updateStyle = $dbh -> prepare("UPDATE `style` SET content=:font WHERE id='6';
                            UPDATE `style` SET content=:background WHERE id='5';
                            UPDATE `style` SET content=:fontHover WHERE id='9';");
                        $updateStyle -> bindParam(":font", $_POST['font'], PDO::PARAM_STR);
                        $updateStyle -> bindParam(":background", $_POST['background'], PDO::PARAM_STR);
                        $updateStyle -> bindParam(":fontHover", $_POST['fontHover'], PDO::PARAM_STR);
                        $updateStyle -> execute();
                        echo '<script>alert("Zmiania stylów w nawigacji się powiodła");window.location="index?action=style"</script>';
                    }
                    else{
                        $selectStyleFontColorR = $dbh -> query("SELECT * FROM style WHERE id='6';");
                        $selectStyleFontColor = $selectStyleFontColorR -> fetch();
                        $selectStyleBGColorR = $dbh -> query("SELECT * FROM style WHERE id='5';");
                        $selectStyleBGColor = $selectStyleBGColorR -> fetch();
                        $selectStyleBGColorHR = $dbh -> query("SELECT * FROM style WHERE id='9';");
                        $selectStyleBGColorH = $selectStyleBGColorHR -> fetch();
                        print '<form method="POST"><table>';
                        print '<tr><td colspan="100%">Zmiania stylu dla nawigacji</td></tr>';
                        print '<tr><td>Font-color</td><td><textarea name="font">'.$selectStyleFontColor['content'].'</textarea></td></tr>';
                        print '<tr><td>Background-color</td><td><textarea name="background">'.$selectStyleBGColor['content'].'</textarea></td></tr>';
                        print '<tr><td>Background:hover</td><td><textarea name="fontHover">'.$selectStyleBGColorH['content'].'</textarea></td></tr>';
                        print '<tr><td colspan="100%"><input type="submit" name="accept" value="Zapisz"></td></tr>';
                        print '</table></form>';
                    }
                }
                else if($id == "3"){
                    if(isset($_POST['accept'])){
                        $updateStyle = $dbh -> prepare("UPDATE `style` SET content=:font WHERE id='8';
                            UPDATE `style` SET content=:background WHERE id='7';");
                        $updateStyle -> bindParam(":font", $_POST['font'], PDO::PARAM_STR);
                        $updateStyle -> bindParam(":background", $_POST['background'], PDO::PARAM_STR);
                        $updateStyle -> execute();
                        echo '<script>alert("Zmiania stylów w głownym divie się powiodła");window.location="index?action=style"</script>';
                    }
                    else{
                        $selectStyleFontColorR = $dbh -> query("SELECT * FROM style WHERE id='8';");
                        $selectStyleFontColor = $selectStyleFontColorR -> fetch();
                        $selectStyleBGColorR = $dbh -> query("SELECT * FROM style WHERE id='7';");
                        $selectStyleBGColor = $selectStyleBGColorR -> fetch();
                        print '<form method="POST"><table>';
                        print '<tr><td colspan="100%">Zmiania stylu dla nawigacji</td></tr>';
                        print '<tr><td>Font-color</td><td><textarea name="font">'.$selectStyleFontColor['content'].'</textarea></td></tr>';
                        print '<tr><td>Background-color</td><td><textarea name="background">'.$selectStyleBGColor['content'].'</textarea></td></tr>';
                        print '<tr><td colspan="100%"><input type="submit" name="accept" value="Zapisz"></td></tr>';
                        print '</table></form>';
                    }
                }
                else{
                    print '<div class="buttonStyle"><a href="index?action=style&id=1">all</a></div>';
                    print '<div class="buttonStyle"><a href="index?action=style&id=2">navigation</a></div>';
                    print '<div class="buttonStyle"><a href="index?action=style&id=3">content</a></div>';
                }
            }
            // Głowny napis
            else{
                print '<center><b>(Wybierz akcję z paska nawigacji)</b></center>';
            }
        ?>
    </main>
    <?php
        require 'footer.php';
    ?>
</body>
</html>