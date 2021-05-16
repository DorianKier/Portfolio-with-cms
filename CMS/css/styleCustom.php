<?php
    print '<style>';
    print 'body{';

    $customFontFamilyR = $dbh -> query("SELECT * FROM style WHERE style='font-family';");
    $customFontFamily = $customFontFamilyR -> fetch();
    print 'font-family:'.$customFontFamily['content'].';';

    $customBackgroundR = $dbh -> query("SELECT * FROM style WHERE style='background';");
    $customBackground = $customBackgroundR -> fetch();
    print 'background-color:'.$customBackground['content'].';';

    $customFontR = $dbh -> query("SELECT * FROM style WHERE style='font';");
    $customFont = $customFontR -> fetch();
    print 'color:'.$customFont['content'].';';

    print '}';
    print '</style>';
?>