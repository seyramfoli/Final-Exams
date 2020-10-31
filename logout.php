<?php
session_start();
unset($_SESSION["sessionId"]);
unset($_SESSION["sessionEmail"]);
unset($_SESSION["sessionFname"]);
unset($_SESSION["sessionLname"]);

header("Location:index.php");
?>
