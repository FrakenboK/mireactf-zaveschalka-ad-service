<?php
$asd = 'asd';
$secret = getenv('SECRET');
//echo `echo -n '$asd$secret' | md5sum`;


echo md5((string)microtime());