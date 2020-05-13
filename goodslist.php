<?php
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$sql='select * from goods where is_delete=0';
$goodslist=mysqli_query($con,$sql);
include('./view/admin/templates/goodslist.html');
?>