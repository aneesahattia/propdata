<?php

function urlenc($str) {
    return preg_replace(array("/%2[fF]/","/\+/"), array("/","%20"), urlencode($str));
}

?>