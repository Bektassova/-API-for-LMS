<?php

// This first sets up the core API structure
defined('DS') ? null :define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Applications'.DS.'MAMP'.DS.
 'htdocs'.DS.'-API-for_LMS');

 defined('CORE_PATH')
?null:define(CORE_PATH, SITE_ROOT.DS.'core');
require_once("config.php");
require_once(CORE_PATH.DS.'user.php');



?>