<?php
session_start();
unset($_SESSION['admin_id']);
header('Location: ../../page/admin/login_admin.php');
exit;
?>