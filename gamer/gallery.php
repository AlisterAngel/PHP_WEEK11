<?php
$title_of_page = "Gallery";
$register_required = "true";
require_once("header.php");
require("auth.php");

require("db.php");

$sql = "Select gamer_id, firstName, photo from gamer where photo is not null;";
$cmd = $db->prepare($sql);
$cmd->execute();
$gamer = $cmd->fetchAll();
echo  '<h1>Gamer Image</h1><main>' ;


foreach ($gamer as $value){
    echo '<div>
        <a href="gamer.php?gamer_id='. $value['gamer_id'].'" title="Gamer Details">
        <img src="images/'. $value['photo'] . '" title="'.$value['firstName'] . '"/>
        </a></div>';
}
echo  '</main>' ;
$conn = null;
require_once("footer.php");