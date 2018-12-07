<?php
//error_reporting(0);
$GLOBALS['db_addr']='localhost';
$GLOBALS['db_user']='root';
$GLOBALS['db_pass']='root';
$GLOBALS['db_name']='search';
$GLOBALS['index'] = '主页';







/*function OpenDB(){
	$GLOBALS['con']=mysqli_connect($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
	if (!$con){
		echo mysqli_error();
	}
}

function CloseDB(){
	mysqli_close($GLOBALS['con']);
}

function RunDB($sql_query){
	mysqli_query("SET NAMES UTF-8");
	$result=mysqli_query($sql_query);
	return result;
}
*/

?>