<?php
class Customize{

	Public $CheckCode='Chinatrustshow';
	//設定值為imagemagick參數
	Public $ImgSize=Array(
		's'=>'100x100',		//小圖：{圖檔名稱}_s.{副檔名}
		't'=>'150x150',	//縮圖：{圖檔名稱}_t.{副檔名}
		'm'=>'320x320',	//中等：{圖檔名稱}_m.{副檔名}
		'o'=>'640x640',	//大圖：{圖檔名稱}_o.{副檔名}
	);
	Public $Quality='100';
	Public $ImgTypeArray=Array('1'=>'gif','2'=>'jpg','3'=>'png');

	Public function BodayEncode($Code){
		$BodayCodeArray=Array($Code,$this->CheckCode);
		$BodayCode=join('Σ',$BodayCodeArray);
		$BodayCode=preg_replace('/(.)/es',"str_pad(dechex(ord('\\1')),2,'0',STR_PAD_LEFT)",$BodayCode);
		return $BodayCode;
	}

	Public function BodayDecode($BodayCode){
		$BodayCode=preg_replace('/(\w{2})/e',"chr(hexdec('\\1'))",$BodayCode);
		$BodayCodeArray=explode('Σ',$BodayCode);
		if($BodayCodeArray['1']==$this->CheckCode){
			return $BodayCodeArray['0'];
		}
		return false;
	}


	//UploadImage By Boday
	/*
	SrcFiles=來源檔案
	Path=目的路徑
	FilesName=新的檔案名稱
	DelFile=是否刪除檔案(true:刪除)
	*/
	Public function UploadImage($SrcFiles,$Path,$FilesName,$DelFile=false){
		//如果沒有上傳檔案
#		echo $SrcFiles;
#		echo '<br>';
#		var_dump(file_exists($SrcFiles));
#		echo '<hr>';

		if(!file_exists($SrcFiles)){
			return false;
		}
		//取得來源圖檔格式
		$ImageType=GetImageSize($SrcFiles);
		$ExtensionArr=Array(1=>'gif',2=>'jpg',3=>'png');
		$Extension=$ExtensionArr[$ImageType['2']];
		//檢查上傳路徑是否存在
		if(!is_dir($Path)){
			$returns=mkdir($Path,0777,true);
		}
		else{
			//刪除舊圖檔
			$FileList=opendir($Path);
			while($DirFiles=readdir($FileList)){
				if($DirFiles!="." && $DirFiles!=".."){
					$FullPath="{$Path}/{$DirFiles}";
					//刪除檔案
					if(ereg("{$FilesName}[^\.]*.",$DirFiles)){
						Unlink($FullPath);
					}
				}
			}
			closedir($FileList);
			unset($DirFiles);
		}
		
		//準備縮圖
		while(list($Keys,$Vars)=each($ImgSize)){
			$NewFiles="{$Path}/{$FilesName}_{$Keys}.{$Extension}";
			//置換JPEG圖檔
			//$Convert='/usr/bin/convert';
			$Convert='convert.exe';
			//$Option="-quality {$this->Quality} +profile '*' -resize '{$Vars}' "; //參數
			$Option="-quality {$this->Quality} +profile '*' -resize ".$Vars; //參數
			$ScriptCode="{$Convert} {$Option} {$SrcFiles} {$NewFiles}";
			shell_exec($ScriptCode);
			//壓縮圖檔
			//$Mogrify='/usr/bin/mogrify';
			$Mogrify='mogrify.exe';
			$ScriptCode="{$Mogrify} -strip {$NewFiles}";
			shell_exec($ScriptCode);
		}
		//複製原圖
		copy($SrcFiles,"{$Path}/{$FilesName}.{$Extension}");

		//刪除暫存檔案
		if(!empty($DelFile)){
			unlink($SrcFiles);
		}
		return true;
	}

	Public function UploadImage2($SrcFiles,$Path,$FilesName,$DelFile=false){
		//如果沒有上傳檔案
		if(!file_exists($SrcFiles)){
			return false;
		}
		//取得來源圖檔格式
		$ImageType=GetImageSize($SrcFiles);
		$ExtensionArr=Array(1=>'gif',2=>'jpg',3=>'png');
		$Extension=$ExtensionArr[$ImageType['2']];
		//檢查上傳路徑是否存在
		if(!is_dir($Path)){
			$returns=mkdir($Path,0777,true);
		}
		else{
			//刪除舊圖檔
			$FileList=opendir($Path);
			while($DirFiles=readdir($FileList)){
				if($DirFiles!="." && $DirFiles!=".."){
					$FullPath="{$Path}/{$DirFiles}";
					//刪除檔案
					if(ereg("{$FilesName}[^\.]*.",$DirFiles)){
						Unlink($FullPath);
					}
				}
			}
			closedir($FileList);
			unset($DirFiles);
		}
		//準備縮圖
		while(list($Keys,$Vars)=each($this->ImgSize)){
			$NewFiles="{$Path}/{$FilesName}_{$Keys}.{$Extension}";
			//置換JPEG圖檔
			$Convert='/usr/bin/convert';
			$Option="-quality {$this->Quality} +profile '*' -resize '{$Vars}' "; //參數
			$ScriptCode="{$Convert} {$Option} {$SrcFiles} {$NewFiles}";
			shell_exec($ScriptCode);
			//紀錄一下
			error_log(date('Y-m-d H:i:s')."-{$ScriptCode}\n",3,'data/CutImg.log');
			//壓縮圖檔
			$Mogrify='/usr/bin/mogrify';
			$ScriptCode="{$Mogrify} -strip {$NewFiles}";
			shell_exec($ScriptCode);
		}
		//複製原圖
		copy($SrcFiles,"{$Path}/{$FilesName}.{$Extension}");

		//刪除暫存檔案
		if(!empty($DelFile)){
			unlink($SrcFiles);
		}
		return true;
	}

	//UploadImage By Boday
	/*
	Path=目的路徑
	FilesName=檔案名稱
	Size=是否指定Size 預設沒有
	*/
	Public function ToGetImage($Path,$FilesName,$Size=''){
		//如果目錄不存在
		if(!is_dir($Path)){
			return false;
		}
		//準備取檔案
		$FileList=opendir($Path);
		while($DirFiles=readdir($FileList)){
			if($DirFiles!="." && $DirFiles!=".."){
				$FullPath="{$Path}/{$DirFiles}";
				//取得檔案
				if(ereg("{$FilesName}([^\.]*).",$DirFiles,$Out)){
					//處理圖檔屬性資訊
					$Image=getimagesize($FullPath);
					$Image=Array(
						'width'=>$Image['0'],
						'height'=>$Image['1'],
						'simply'=>$Image['3'],
						'type'=>$this->ImgTypeArray[$Image['2']],
						'src'=>"/{$FullPath}?t=".filectime($FullPath)
						);
					if(empty($Size) && !empty($Out)){
						//圖檔KeysIndex
						$KeysIndex=empty($Out['1'])?'d':str_replace('_','',$Out['1']);
						$ImageFiles[$KeysIndex]=$Image;
					}
					else{
						if(strstr($DirFiles,"_{$Size}")){
							$ImageFiles=$Image;
						}
					}
				}
			}
		}
		closedir($FileList);
		unset($DirFiles);
		return empty($ImageFiles)?false:$ImageFiles;
	}

	Public function RemoveImage($Path,$Id){
		//如果目錄不存在
		if(!is_dir($Path)){
			return false;
		}
		$FilesName=substr(md5($Id),0,8);
		//準備取得圖檔
		$FileList=opendir($Path);
		while($DirFiles=readdir($FileList)){
			if($DirFiles!="." && $DirFiles!=".."){
				$FullPath="{$Path}/{$DirFiles}";
				//取得檔案
				if(strstr($DirFiles,"{$FilesName}")){
					unlink($FullPath);
					//break;
				}
			}
		}
		closedir($FileList);
		unset($DirFiles);
	}

	//日期下拉選單
	Public function ListboxDate ($Def=0){
		for ($d=1;$d<=31;$d++) {
			$Selected=($Def==$d)?'selected="selected"':'';
			$result.="<option value=\"{$d}\" {$Selected}>{$d}</option>\n";
		}
		return $result;
	}

	//月份下拉選單
	Public function ListboxMonth ($Def=0){
		for ($m=1;$m<=12;$m++) {
			$Selected=($Def==$m)?'selected="selected"':'';
			$result.="<option value=\"{$m}\" {$Selected}>".date(M, mktime(0,0,0,$m,1,2000))."</option>\n";
		}
		return $result;
	}

	//年份下拉選單
	Public function ListboxYear($StartYear,$EndYear,$Def=0) {
		$StartYear=$StartYear?$StartYear:'2000';
		$EndYear=$EndYear?$EndYear:date('Y')+3;
		for ($y=$EndYear;$y>=$StartYear;$y--) {
			$Selected=($Def==$y)?'selected="selected"':'';
			$result.="<option value=\"{$y}\" {$Selected}>{$y}</option>\n";
		}
		return $result;
	}

	//過濾style和script
	Public function ScriptFliter($Text){
		if(empty($Text))
			return false;
		$KeyWord=Array("<style[^>]*>.*</style>","<script[^>]*>.*</script>");
		while(list($Keys,$Vars)=each($KeyWord)){
			$Text=ereg_replace($Vars, "", $Text);
		}
		return $Text;
	}
}
?>