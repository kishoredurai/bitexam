<?php

//logout.php // source code modified by jacksonsilass@gmail.com +255 763169695 from weblessons

session_start();

session_destroy();

header('location:../login.php');

?>