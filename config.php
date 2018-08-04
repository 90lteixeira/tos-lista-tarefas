<?php
error_reporting(1);
define("VP_DB_HOST", "localhost");
define("VP_DB_HOST_NAME", "admin_tos");
define("VP_DB_HOST_USER", "admin_jogo");
define("VP_DB_HOST_PASS", "tos");
if (!defined('SISDB_HOST_PASS'))
    define("SISDB_HOST_PASS", "tos");

define('DB', __DIR__ . '/models/db.php');
define('HDO', __DIR__ . '/models/hdo.php');
define('ESSENCIAIS', __DIR__ . '/lib/essenciais.php');

define('HEADER', __DIR__ . '/views/inc/header.php');
define('FOOTER', __DIR__ . '/views/inc/footer.php');

if (!defined('SERVIDOR'))
    define('SERVIDOR', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT'));

