<?php
    // Plik konfiguracyjny do lączenia strony z bazą danych

    DEFINE('DB_NAME', 'portfolio'); // nazwa bazy w bazie danych (np. portfolio)
    DEFINE('DB_HOST', 'localhost'); // nazwa hosta w bazie dancyh (np. localhost, 127.0.0.1)
    DEFINE('DB_USER', 'root'); // nazwa użytkownika (np. root, jan, 1234567_uzytkownik)
    DEFINE('DB_PASS', ''); // hasło do bazy danych aby umożliwić połączenie

    // Łączenie z bazą danych za pomocą podancyh zmiennych
    try{
        $dbh = new PDO ('mysql:dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS);
    }
    catch( PDOException $e){
        // Powiadomienie o błędnym połączeniu bazy danych lub jej nie możliwości połączenia
        print("<center><h1>Bład połączenia do bazy danych!</h1></center><hr>");
        print $e;
        exit;
    }
?>