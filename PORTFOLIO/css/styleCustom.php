<?php
    print '<style>';
    $customLinkToFontsR = $dbh -> query("SELECT * FROM style WHERE style='link-to-font';");
    $customLinkToFonts = $customLinkToFontsR -> fetch();
    print $customLinkToFonts['content'];

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
    print 'nav{';

    $customBackgroundNavR = $dbh -> query("SELECT * FROM style WHERE style='background-nav';");
    $customBackgroundNav = $customBackgroundNavR -> fetch();
    print 'background-color:'.$customBackgroundNav['content'].';';

    print '}';
    print 'nav > ul a:link, ul a:visited{';
    
    $customFontNavR = $dbh -> query("SELECT * FROM style WHERE style='font-nav';");
    $customFontNav = $customFontNavR -> fetch();
    print 'color:'.$customFontNav['content'].';';
    
    print '}';
    print 'nav > ul a:hover{';
    
    $customBackgroundNavHR = $dbh -> query("SELECT * FROM style WHERE style='background-navh';");
    $customBackgroundNavH = $customBackgroundNavHR -> fetch();
    print 'color:'.$customBackgroundNavH['content'].';';
        
    print '}';
    print 'main{';
        
    $customBackgroundMainR = $dbh -> query("SELECT * FROM style WHERE style='background-main';");
    $customBackgroundMain = $customBackgroundMainR -> fetch();
    print 'background-color:'.$customBackgroundMain['content'].';';
        
    $customFontMainR = $dbh -> query("SELECT * FROM style WHERE style='font-main';");
    $customFontMain = $customFontMainR -> fetch();
    print 'color:'.$customFontMain['content'].';';
        
    print '}';
    print '</style>';
?>