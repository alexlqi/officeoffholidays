<?php
//funciones generales
function fechaMysql2Full($fecha,$delimiter="/"){
	//formato dd / Mes con letra /aaaa
	$mes=array(
		"01"=>"Enero",
		"02"=>"Febrero",
		"03"=>"Marzo",
		"04"=>"Abril",
		"05"=>"Mayo",
		"06"=>"Junio",
		"07"=>"Julio",
		"08"=>"Agosto",
		"09"=>"Septiembre",
		"10"=>"Octubre",
		"11"=>"Noviembre",
		"12"=>"Diciembre",
	);
	return date("d",strtotime($fecha)).$delimiter.$mes[date("m",strtotime($fecha))].$delimiter.date("Y",strtotime($fecha));
}
?>