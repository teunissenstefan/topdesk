<?php
session_unset();
header("Location:?controller=pages&action=home");
echo "U bent uitgelogd";
?>