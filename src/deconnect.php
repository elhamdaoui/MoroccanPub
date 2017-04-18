<?php

session_start();
$_SESSION = array();
session_destroy();
/*
setcookie('ps','');
setcookie('mp','');
setcookie('nom','');
setcookie('pnom','');
setcookie('fct','');
setcookie('id_f','');
 */
/* Redirect to a different page in the current directory that was requested */
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php';
//header("Location: http://$host$uri/$extra");
//header("Location: http://".$host.$uri);
?>
