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
            // Edytowanie imienia użytkownia CMS 
            if($action == "editUserName"){
                if(isset($_POST['acceptEdit'])){
                    $updateName = $dbh -> prepare("UPDATE `user` SET imie=:newName WHERE id='".$_SESSION['id']."';");
                    $updateName -> bindParam(":newName", $_POST['newName'], PDO::PARAM_STR);
                    $updateName -> execute();
                    echo '<script>alert("Zmieniono imię użytkownika!");window.location="editAccount";</script>';
                }
                else{
                    print '<form method="POST"><table>';
                    print '<tr><td colspan="100%"><h3>Dane konta</h3></td></tr>';
                    print '<tr><td>Imię:</td><td><input type="text" name="newName" required/></td><td><input type="submit" name="acceptEdit" value="Zapisz"/></td></tr>';
                    print '</table></form>';
                }
            }
            // Edytowanie loginu użytkonika CMS
            else if($action == "editLogin"){
                if(isset($_POST['acceptEdit'])){
                    $updateLogin = $dbh -> prepare("UPDATE `user` SET login=:newLogin WHERE id='".$_SESSION['id']."';");
                    $updateLogin -> bindParam(":newLogin", $_POST['newLogin'], PDO::PARAM_STR);
                    $updateLogin -> execute();
                    echo '<script>alert("Zmieniono login użytkownika!");window.location="editAccount";</script>';
                }
                else{
                    print '<form method="POST"><table>';
                    print '<tr><td colspan="100%"><h3>Dane konta</h3></td></tr>';
                    print '<tr><td>Login:</td><td><input type="text" name="newLogin" required/></td><td><input type="submit" name="acceptEdit" value="Zapisz"/></td></tr>';
                    print '</table></form>';
                }
            }
            // Edytowanie hasła użytkownia CMS 
            else if($action == "editPassword"){
                if(isset($_POST['acceptEdit'])){
                    // Sprawdznie poprawności haseł;
                    if($_POST['newPassword'] == $_POST['newPasswordMatch']){
                        $newHashPass = hash_hmac("sha256", $_POST['newPassword'], HASH_KEY);
                        $updatePassword = $dbh -> prepare("UPDATE `user` SET haslo=:haslo WHERE id='".$_SESSION['id']."';");
                        $updatePassword -> bindParam(":haslo", $newHashPass, PDO::PARAM_STR);
                        $updatePassword -> execute();
                        echo '<script>alert("Hasło zostało zmienione!");window.location="login?a=logout";</script>';
                    }
                    else{
                        echo '<script>alert("Hasła do siebie nie pasują!");window.location="editAccount?action=editPassword";</script>';
                    }
                }
                else{
                    print '<form method="POST"><table>';
                    print '<tr><td colspan="100%"><h3>Dane konta</h3></td></tr>';
                    print '<tr><td>Hasło:</td><td><input type="password" name="newPassword" required/></td></tr>';
                    print '<tr><td>Powtórz hasło:</td><td><input type="password" name="newPasswordMatch" required/></td></tr>';
                    print '<tr><td colspan="100%"><input type="submit" name="acceptEdit" value="Zmień hasło"/></td></tr>';
                    print '</table></form>';
                }
            }
            // Wypisanie danych użytkownia CMS 
            else{
                $showAccountR = $dbh -> query("SELECT * FROM user WHERE id='".$_SESSION['id']."'");
                $showAccount = $showAccountR -> fetch();
                print '<table id="editAccount">';
                print '<tr><td colspan="100%"><h3>Dane konta</h3></td></tr>';
                print '<tr><td>Imię:</td><td>'.$showAccount['imie'].'</td><td><a href="editAccount?action=editUserName">Edit</a></td></tr>';
                print '<tr><td>Login:</td><td>'.$showAccount['login'].'</td><td><a href="editAccount?action=editLogin">Edit</a></td></tr>';
                print '<tr><td>Hasło:</td><td>********</td><td><a href="editAccount?action=editPassword">Edit</a></td></tr>';
                print '</table>';
            }
        ?>
    </main>
    <?php
        require 'footer.php';
    ?>
</body>
</html>