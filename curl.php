<?php
require '/data/webroot/classes/Artron/Load.php';
Artron_Load::autoload();
require '/data/webroot/classes/Artron/ErrorHandle.php';
echo '<pre>';
echo 9/0;
echo 'Hello World';