<?php
include_once('./includes/databse.php');
$migration = new Database;
$migration->migration_up();
header('Location: /');
