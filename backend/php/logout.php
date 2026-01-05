<?php
session_start();
session_destroy();
header("Location: index.php"); // Променено от login.php на index.php
exit;