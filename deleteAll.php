<?php
include 'db.php';
$query="TRUNCATE TABLE tasks";
$db->query($query);
echo "Successfully deleted all records";
?>