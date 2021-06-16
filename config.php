<?php
defined('CORE') or defined('CORE_ACP') or exit;
define('CONFIG', true);

$config['team'] = 'Spotnime Fansub';
$config['pass'] = 'spotnime';
$config['accro'] = 'spotnime';
$config['path'] = 'http://localhost/PHP/Spotnime-Fansub/';
$config['cracksparpage'] = 20;
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'php_fansub';

$db_link = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass);?>