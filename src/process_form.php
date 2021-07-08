<?php
require("./includes/bookings.php");
$bookings = new Bookings;
$bookings->uploadData($_POST, $_FILES);
header('Location: /view');
