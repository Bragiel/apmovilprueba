<?php

if(file_put_contents('/var/www/uploads/file.txt', 'text')){
    die('yes');
} else {
    die('no');
}

echo file_get_contents('/var/www/uploads/file.txt');

?>