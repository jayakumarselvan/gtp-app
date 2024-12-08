<?php
    require_once("src/config.php");
    require 'src/auth.php';
    require_once("src/middleware.php");
    authenticate();
    require_once("header.php");
?>
<div class="container">
<?php

$currentUserName = $_SESSION['user']["name"]

?>

<h4>Hello <?=$currentUserName;?></h4>

</div>
<?php
require_once("footer.php");
?>