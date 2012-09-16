<?php
defined('DS') ? null : define('DS', '/');
defined('WEB_ROOT') ? null : define('WEB_ROOT', $_SERVER['DOCUMENT_ROOT']);
defined('LIB') ? null : define('LIB', WEB_ROOT . 'lib' . DS);
defined('LAYOUT') ? null : define('LAYOUT', WEB_ROOT . 'themes' . DS);
defined('CONTENT') ? null : define('CONTENT', WEB_ROOT . 'modules' . DS);
defined('COMMON') ? null : define('COMMON', WEB_ROOT . 'common' . DS);
defined('THEME') ? null : define('THEME', 'basic');

defined('INSTITUTE') ? null : define('INSTITUTE', 'GA');

defined('MAX_IMAGES_SIZE') ? null :define('MAX_IMAGES_SIZE',2097152);//2MB

defined('PATH_DEFAULT') ? null : define('PATH_DEFAULT', WEB_ROOT . 'images' . DS);
defined('PATH_OUT_DEFAULT') ? null : define('PATH_OUT_DEFAULT', "/images/");
defined('PATH_INIT_DEFAULT') ? null : define('PATH_INIT_DEFAULT', 'img_');

defined('PATH_STUDENT') ? null : define('PATH_STUDENT', WEB_ROOT . 'images' . DS . 'student' . DS);
defined('PATH_OUT_STUDENT') ? null : define('PATH_OUT_STUDENT', "/images/student/");
defined('PATH_INIT_STUDENT') ? null : define('PATH_INIT_STUDENT', 'stu_');

defined('DOMAIN') ? null : define("DOMAIN", "http://localhost:5500/");
defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
defined('DB_NAME') ? null : define("DB_NAME", "institute");
defined('DB_USER') ? null : define("DB_USER", "root");
defined('DB_PASS') ? null : define("DB_PASS", "");

?>