<?php

$user = unserialize(file_get_contents('./users/2deb000b57bfac9d72c14d4ed967b572.txt'));

echo $user->login;