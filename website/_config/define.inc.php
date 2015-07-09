<?php

define("WEB_NAME",          	"Final Empire");                            // 網站名稱
define("WEB_ROOT_URL",			"http://".$_SERVER['HTTP_HOST'].BASE_URL);    // 網站網址
define("WEB_PREFIX",        	"");                           // 網站變數前綴名稱，用來串接變數名 Ex: Session OR Cookie etc...
define("WEB_COOKIE_DOMAIN", 	NULL);                                    // 網站 Cookie 網域設定
define("WEB_COOKIE_KEY",    	strlen(WEB_COOKIE_DOMAIN));               // Cookie 資料編解碼用的 Key
define("WEB_CHARSET",       	"utf-8");                                 // WEB charset 設定

define("DB_PREFIX",          	"");	//db前綴名稱
define("DB_SUFFIX",          	"");	//db後綴名稱

define('PAGEBREAK_REQUEST_NAME','page');	//分頁的參數名稱
define('RESULT_PER_PAGE',20);				//每頁幾筆資料

define('LANGUAGE', 'zh_tw');			//預設語言


# memcache
define('IS_MEMCACHE', false);			//是否開啟memcache
define('MEMCACHE_HOST', 'localhost');			//是否開啟memcache
define('MEMCACHE_PORT', 11211);			//是否開啟memcache

define('FILE_EXPIRATION', 86400);		//檔案過期的時間