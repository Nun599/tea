<?php
session_start();
session_unset();
session_destroy();
header('Location: index.php?success=' . urlencode('Logged out.'));
exit;
