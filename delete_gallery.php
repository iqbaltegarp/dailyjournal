<?php
$conn = new mysqli('localhost', 'root', '', 'webdailyjournal');
$id = $_GET['id'];
$conn->query("DELETE FROM gallery WHERE id = $id");
header('Location: gallery.php');
?>
