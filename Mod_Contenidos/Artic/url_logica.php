<?php

    if(($rowb['myurl']=="NULL")||(strlen(@trim($rowb['myurl'])) == 0)){
        global $myurl;
        //$myurl = '<h7 style=\'display:block;\'><a href="#">SIN URL...</a></h7>';
        $myurl = '<h7 style=\'display:block;\'>&nbsp;</h7>';

    } else {
        global $myurl;
        $myurl = '<h7 style=\'display:block;\'><a href="'.$rowb['myurl'].'" target="_blanck">LINK EXTERNO</a></h7>';
    }

?>