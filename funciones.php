<?php
//parametros y variables
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
$estado=array(
	"Pendiente",
	"Autorizada",
	"Rechazada",
);

//funciones generales
function fechaMysql2Full($fecha,$delimiter="/"){
	global $mes;
	//formato dd / Mes con letra /aaaa
	return date("d",strtotime($fecha)).$delimiter.$mes[date("m",strtotime($fecha))].$delimiter.date("Y",strtotime($fecha));
}

function fechaInversa($fecha,$delimiter="-"){
	$fecha=explode($delimiter,$fecha);
	$fecha=array_reverse($fecha);
	return implode($delimiter,$fecha);
}

function dateDiff($i,$f){
	return date("z",strtotime($f))*1-date("z",strtotime($i))*1+1;
}
?>