<?php
	$db = mysqli_connect("localhost","root","zelda2","programacionmultimedia"); //keep your db name
	$sql = "SELECT fotoUsuario FROM usuario WHERE id = 1";
	$sth = $db->query($sql);
	$result=mysqli_fetch_array($sth,MYSQLI_NUM);
//	echo '<body>';
	echo '<img src="data:image/jpeg;base64,'.base64_encode( $result[0] ).'"/>';
//	echo '</body>';
?>