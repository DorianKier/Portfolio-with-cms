<!-- Plik główny portoflio CMS
Aplikację strorzył Dorian Kiewro (Kier).
Twitter @DKiewro
GitHub https://github.com/DorianKier
E-mail dorian.kiewro@gmail.com -->
<?php
    include('config.php');
    error_reporting(0);
    $a = $_GET['a'];
    session_start();
    // Wylogowywanie z sesji
    // Usuwanie sesji
    if($a == 'logout'){
        unset($_SESSION['user']);
        unset($_SESSION['id']);
        session_destroy();
        header("Location: login");
    }
    // Logowanie
    if(isset($_POST['loginCMS'])){
        // Spawrdzanie czy dany użytkownik istnieje w bazie danych
        $searchUserR = $dbh -> query("SELECT * FROM user WHERE login='".$_POST['loginCMS']."';");
        $searchUser = $searchUserR -> fetch();
        // Sprawdzanie hasła
        $hasloCms = hash_hmac('sha256', $_POST['hasloCMS'], HASH_KEY);
        if($hasloCms == $searchUser['haslo']){
            // Utworzenie sesji z danym użytkownikiem
            $_SESSION['user'] = $searchUser['imie'];
            $_SESSION['id'] = $searchUser['id'];
            header('Location: index');
        }
        else{
            echo '<script>alert("Błędne dane, spróbuj ponownie!");window.location="login";</script>';
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title>Logowanie Portfolio CMS</title>
    <meta name="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dorian Kiewro"/>
    <link rel="icon" href="img/icon.png" sizes="16x16" type="image/png">
    <link href="css/style.css" rel="stylesheet"/>
    <link href="css/mobile.css" rel="stylesheet"/>
</head>
<body>
    <form method="POST">
        <table id="logWindow">
            <tr><td colspan="100%">Logowanie do panelu portfolio</td></tr>
            <tr><td>Login:</td><td><input type="text" name="loginCMS" required/></td></tr>
            <tr><td>Hasło:</td><td><input type="password" name="hasloCMS" required/></td></tr>
            <tr><td colspan="100%"><input type="submit" name="zalogujSie" value="Zaloguj się"/></td></tr>
        </table>
    </form>
</body>
</html>