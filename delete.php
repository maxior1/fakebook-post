<?php
session_start();
include 'connectdb.php';

$id = $_GET['id'];

$sql = "DELETE FROM `user` WHERE id = $id";
$result = mysqli_query ($conn, $sql);
unlink("images/".$_GET['id'].".".$_GET['ext']);
if($result){
   
    echo "<script>";
    echo "alert('A post was deleted  successfully.');";
    echo "window.location = 'index.php';";
    echo "</script>";

 }
 else {
    echo "Failed: ".mysqli_error($conn);
}


?>