<?php
class auth {
		
	/**
	 * 從 cookie 取得會員資料
	 *
	 * @return Array
	 */
    function getCookieData() {
		$cookie = $this->encryptCookie($_COOKIE[WEB_PREFIX . "m"], WEB_COOKIE_KEY, 0);
		$cookie = json_decode($cookie, true);
		
		if( $cookie === FALSE || $cookie === NULL ){
			return false;
		}
		
		return $cookie ;
    }

    /**
     * Clear Auth Data Function
     *
     * This function clears any auth tokens in the currently active session
     * and save system log.
     *
     * @access public
     * @return void
     */
    function clearAuthData(){
        if (!$this->hasLogin()) { return; }
		
		setcookie (WEB_PREFIX . "m", "", time() - 3600, '/', WEB_COOKIE_DOMAIN, 0, 1);
		unset ($_COOKIE[WEB_PREFIX . "m"]);
    }
	
	/**
     * Login Function
     *
     * This function clears any auth tokens in the currently
     * active session and redirects to "login" or other assigned page.
     *
     * @access public
     * @param  string Redirect url.
     * @return void
     */
    function setCookieData($data){
        setcookie(WEB_PREFIX . "m", $this->encryptCookie(json_encode($data), WEB_COOKIE_KEY, 1));
    }

    /**
     * Logout Function
     *
     * This function clears any auth tokens in the currently
     * active session and redirects to "login" or other assigned page.
     *
     * @access public
     * @param  string Redirect url.
     * @return void
     */
    function logout($url = ""){

        $url = trim($url);
        if ("" == $url) { $url = WEB_ROOT_URL; }

		if (!$this->hasLogin()) { $this->haltRedirect($url); }

        // Clears any AuthUser's session data and save system log.
        $this->clearAuthData();
		$this->haltRedirect($url);
    }

    function hasLogin(){
        if(empty($_COOKIE[WEB_PREFIX . "m"])){
            return false;
        }else{
			$_mData = $this->getCookieData();
			if( $_mData["id"] != '' ){
				return true;
			}else{
				return false;
			}
        }
    }
    
    function checkLoginAndRedirect($redirectUrl=PHP_FILE_PATH)
    {
        if(!$this->hasLogin()){
			// require(CLASS_PATH.'/facebook.php');
			// require(CONFIG_PATH."/facebook.inc.php");			//載入facebook 設定
			
			// $config = array();
			// $config['appId'] = $facebook['app_id'];
			// $config['secret'] = $facebook['app_secret'];
			// $config['fileUpload'] = false;
			
			// $fb = new Facebook($config);
			// $facebookId = $fb->getUser();
			
			$facebookId = '100000227597979';

			if($facebookId){
				$user = new user();
				$rows = $user->getByFacebookId($facebookId,'id,nickname');
				if($rows)
					$user->login($rows);
				else
					redirect(WEB_ROOT_URL . "/user/register.php");
			}else{
				$facebook['redirect_uri'] = 'http://'.$_SERVER['HTTP_HOST'].BASE_URL.'/'.$redirectUrl.'?'.$_SERVER['QUERY_STRING'];
				$params = array(
				  'scope' => $facebook['scope'],
				  'redirect_uri' => $facebook['redirect_uri']
				);

				redirect($fb->getLoginUrl($params));
			}
		}
    }

    /**
     * Halt to Alert and Redirect Function
     *
     * Alert message if any and redirect url using "HTTP" Header or "JS".
     *
     * @access public
     * @param  string Redirect url.
     * @param  string The message want to show for user in the frontend.
     * @param  string Redirect mode either "HTTP" Header or "JS".
     * @return void
     */
    function haltRedirect($url = "", $msg = "", $mode = "HTTP")
    {
        $msg = trim($msg);
        $msg = str_replace("'", "\'", $msg);
        if ("" != $msg) { $mode = "JS"; }

        $mode = strtoupper(trim($mode));
        if ("" == $mode || "JS" != $mode) { $mode = "HTTP"; }

        $url = trim($url);
        if ("" == $url && "HTTP" == $mode) { $url = WEB_ROOT . "/"; }

        switch ($mode)
        {
        case "JS":
            if (!headers_sent()) {
                header("Content-Type: text/html; charset=" . WEB_CHARSET . "");
            }

            echo "<script type='text/javascript'>
                  <!-- <![CDATA[\n";

            if ("" != $msg)
            {
                echo "alert('$msg');\n";
            }

            if ("" == $url)
            {
                echo "history.go(-1);\n";
            }
            else
            {
                echo "if (parent != window)
                      {
                          parent.content.window.location.replace('$url').reload();
                      }
                      else
                      {
                          window.location.replace('$url').reload();
                      }\n";
            }

            echo "// ]]> -->
                  </script>";
            break;

        case "HTTP":
            if (!headers_sent()) {
                header("Location: $url");
            }
            break;
        }   // switch

        exit;
    }
	
	/**
	 * 資料編解碼函式
	 * ASCII-table: http://www.asciitable.com/
	 *
	 * @param   string      編解碼字串資料
	 * @param   integer     編解碼用的Key
	 * @return  編解碼後的字串
	 */
	private function encrypt($data, $key)
	{
		$output = "";
		$key = intval($key);
		$len = strlen($data);

		for ($i = 0; $i < $len; $i++) {
			$output .= chr(ord(substr($data, $i, 1)) ^ $key);
		}

		return $output;
	}

	/**
	 * Cookie資料編解碼函式
	 *
	 * 避免非法字元出現在COOKIE中 (非ASCII字元、分號、逗號、空白)
	 *
	 * <samp>
	 * // 將資料編碼後再存入COOKIE
	 * setcookie($cookieName, encryptCookie($data, 10, 1));
	 *
	 * // 從COOKIE取出資料後再解碼
	 * encryptCookie($_COOKIE[$cookieName], 10, 0);
	 * </samp>
	 *
	 * @param   string      編解碼字串資料
	 * @param   integer     編解碼用的Key
	 * @param   integer     0:解碼, 1:編碼
	 * @return  編解碼後的字串
	 */
	private function encryptCookie($data, $key, $mode)
	{
		if ((0 === intval($mode)) && get_magic_quotes_gpc()) { $data = stripslashes($data); }

		return (1 === intval($mode)) ? $this->encrypt(base64_encode(urlencode($data)), $key)
									 : urldecode(base64_decode($this->encrypt($data, $key)));
	}

	/**
	 * HTML ENTITIES 特殊字元編解碼轉換函式
	 *
	 * 避免經過 htmlspecialchars() 處理後，特殊字元失效
	 * 此函式已整合 tohtmlspecialchars() 來使用
	 *
	 * <samp>
	 * // 編碼：將 HTML ENTITIES 特殊字元轉為 {DS_SPECIAL_CHAR_索引值}
	 * $data = DS_SpecialChars($data, 1);
	 *
	 * // Convert special characters to HTML entities
	 * $data = str_replace("&amp;#", "&#", htmlspecialchars($data, ENT_QUOTES));
	 *
	 * // 解碼：將 {DS_SPECIAL_CHAR_索引值} 轉為 HTML ENTITIES 特殊字元
	 * $data = DS_SpecialChars($data, 0);
	 * </samp>
	 *
	 * @param   string      編解碼轉換字串資料
	 * @param   integer     0:解碼, 1:編碼
	 * @return  編解碼轉換後的字串
	 */
	private function specialChars($data, $mode)
	{
		$aSpecialChars = array_values(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES));
		$aSpecialCharsDS = array();
		foreach ($aSpecialChars as $iSpecialIndex => $sSpecialChars) {
			$aSpecialCharsDS['{DS_SPECIAL_CHAR_' . $iSpecialIndex . '}'] = $sSpecialChars;
		}
		unset($aSpecialChars);

		$trans = (1 === intval($mode)) ? array_flip($aSpecialCharsDS) : $aSpecialCharsDS;
		unset($aSpecialCharsDS);

		return strtr($data, $trans);
	}
}
?>
