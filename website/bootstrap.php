<?php 
header('P3P: CP="NOI ADM DEV PSAi NAV OUR STP IND DEM"');
header('Content-type: text/html; charset=utf-8'); 
ini_set('display_errors','on');
date_default_timezone_set("Asia/Taipei");	//設定時區

$docRoot = $_SERVER['DOCUMENT_ROOT'];
if($docRoot{strlen($docRoot)-1} == '/')	
	$docRoot = substr($docRoot,0,strlen($docRoot)-1);

//網站設定
define("ROOT_PATH",$docRoot);
define("BASE_URL",'');
define("LIBRARY_PATH",ROOT_PATH.BASE_URL."/lib");				//設定library路徑
define("CONFIG_PATH",ROOT_PATH.BASE_URL."/_config");				//設定config檔路徑
define("CLASS_PATH",LIBRARY_PATH."/class");				//設定通用class檔路徑
define("FUNC_PATH",LIBRARY_PATH."/function");			//設定通用function檔路徑

define("PHP_FILE",str_replace("/","",strrchr($_SERVER['SCRIPT_NAME'], '/')));
define("PHP_PATH",strstr($_SERVER['SCRIPT_NAME'], "/" . PHP_FILE, true));
define('PHP_FILE_PATH',str_replace(BASE_URL,"",$_SERVER['SCRIPT_NAME']));
define("PHP_FILE_NAME",substr(PHP_FILE,0,strpos(PHP_FILE, '.')));

//set_include_path：下require時會先去models找，若找不到則去跟目錄層級找，故若引入檔並非放在跟目錄或models內，require時則須下路徑
set_include_path(implode(PATH_SEPARATOR, array(
	ROOT_PATH . BASE_URL . '/model',
    get_include_path()	//根目錄
)));

//載入
require(CONFIG_PATH."/define.inc.php");			//定義檔
require(CONFIG_PATH."/game_define.inc.php");	//遊戲定義檔
require(CONFIG_PATH."/mysql.inc.php");			//載入mysql連結檔
require(CLASS_PATH."/class.DB.php");			//載入資料庫class
require(CLASS_PATH."/class.View.php");
require(CLASS_PATH."/class.System.php");
require(CLASS_PATH."/class.File.php");
require(CLASS_PATH."/class.PageBreak.php");
require(FUNC_PATH."/functions.php");			//載入通用function

$userId = 1;
$playerId = 1;
?>