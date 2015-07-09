<?php
class FileDeal {
	var $FILE;
	###################
	# 文件上傳函數
	# $filename post框名
	# $path 上傳文件得路徑
	# $newfilename 文件新名
	# $max_size 允許文件最大容量
	###################
	var $FileMsg="";
	var $PicType = array("JPG","GIF","PNG");
	function UpLoad( $filename,$path="",$newfilename="",$max_size="1024000" ) {
		if( !is_uploaded_file($_FILES[$filename]['tmp_name']) ) {
			$this->FileMsg .= "cannt found file:".$_FILES[$filename]['name']."\n";
		}
		else {
			$this->FILE['FILE_SIZE']		= $_FILES[$filename]['size'];
			$this->FILE['FILE_NAME']		= $_FILES[$filename]['name'];
			$this->FILE['FILE_TYPE']		= strtoupper(substr(strrchr($this->FILE['FILE_NAME'],"."),1));
			$this->FILE['FILE_NAME_ONLY']	= substr($this->FILE['FILE_NAME'],0,strrpos($this->FILE['FILE_NAME'],"."));
			$this->FILE['FILE_NAME_NEW']	= $newfilename==""?$this->FILE['FILE_NAME']:urlencode($newfilename.".".$this->FILE['FILE_TYPE']);
			$this->FILE['FILE_URL']			= $path==""?$this->FILE['FILE_NAME_NEW']:$path."/".$this->FILE['FILE_NAME_NEW'];
			
			
			if( $max_size!="" && $this->FILE['FILE_SIZE'] > $max_size ) {
				$this->FileMsg .= "上傳失敗，文件容量超過".$max_size."\n";
			}
			if( $path!="" && !is_dir($path) ) {
				if( !mkdir($path) ) {
					$this->FileMsg .= "上傳失敗,目錄非法\n";
				}
			}
			if( move_uploaded_file($_FILES[$filename]['tmp_name'],$this->FILE['FILE_URL']) ) {
				if(in_array($this->FILE['FILE_TYPE'],$this->PicType)){
					$size = getimagesize($this->FILE['FILE_URL']);
					$this->FILE['IMG_WIDTH'] = $size[0];
					$this->FILE['IMG_HEIGHT'] = $size[1];
				}
				return TRUE;
			}
			else {
				return $this->FileMsg;
			}
		}
	}

	######################
	#		刪除文件函數
	#		$filename 要刪除的文件名+路徑
	######################
	function DeleteFile($filename) {
		if( file_exists($filename) ) {
			if( unlink($filename) ) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		else {
			echo "no file";
		}
	}

	############################
	#		####文件下載類######
	#		$file_old_add 要下載的文件
	#		$file_new_name 文件要存的名字
	#		$is_delete 下載後是否刪除源文件
	############################
	function Download($file_old_add,$file_new_name,$is_delete="0") {
		$FILE = fopen($file_old_add,"r");
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: ".filesize($file_old_add));
		Header("Content-Disposition: attachment; filename=".$file_new_name); #下載時顯示的文件名
		echo fread($FILE,filesize($file_old_add));
		fclose($FILE);
		if( $is_delete == "1" ) {
			$this->DeleteFile($file_old_add);
		}
	}
}
$filedeal=new FileDeal;
?>
