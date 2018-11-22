<?php

namespace Wagento\SearchModified\Helper;
use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
	protected $searchFiles;

	public function searchContent($string, $dir, $extensions)
	{
		$extArray = array();
		if($extensions != ""){ $extArray = explode(",",$extensions); }
		$this->searchList($string, $dir, $extArray);
		return $this->searchFiles;

	}
	function searchList($string, $dir, $extArray){
		if(!$dir){ $dir = getcwd(); }
		$ffs = scandir($dir);

		foreach($ffs as $ff){
			if($ff != '.' && $ff != '..'){
				if(is_dir($dir.'/'.$ff)){
					$this->searchList($string, $dir.'/'.$ff, $extArray);
				}else{
					$extension = pathinfo($dir.'/'.$ff, PATHINFO_EXTENSION);
					if(!empty($extArray)){
						if(in_array($extension,$extArray)){
							$content = file_get_contents($dir.'/'.$ff);
							if (strpos($content, $string) !== false) {
								$this->searchFiles[] =  date ("F d Y H:i:s", filemtime($dir.'/'.$ff)) ." = ". $dir.'/'.$ff;
							}
						}
					}
					else{
						$content = file_get_contents($dir.'/'.$ff);
						if (strpos($content, $string) !== false) {
							$this->searchFiles[] =  date ("F d Y H:i:s", filemtime($dir.'/'.$ff)) ." = ". $dir.'/'.$ff;
						}
					}
					
				}
			}
		}
	}
	public function searchModified($noOfdays, $directory, $extensions)
	{
		$dir = ($directory)?$directory:getcwd();
		$findInDays = 0;
		$extArray = array();
		if($extensions != ""){ $extArray = explode(",",$extensions);}

		$_SESSION = $this->listFolderFiles( $dir, $extArray, $noOfdays);
		krsort($_SESSION);
		$result = array();
		foreach($_SESSION as $days => $filePath){
			$result[] =  date('d/m/Y h:i:s',$days). "  -  " . $filePath;
		}
		return $result;
	}
	public function listFolderFiles($dir, $extArray, $noOfdays){
		if (!isset($_SESSION)) {
			$_SESSION = array();
		}
		$ffs = scandir($dir);
		foreach($ffs as $ff){
			if($ff != '.' && $ff != '..'){
				if(is_dir($dir.'/'.$ff)){
					$this->listFolderFiles( $dir.'/'.$ff, $extArray,$noOfdays);
				}else{
					$extension = pathinfo($dir.'/'.$ff, PATHINFO_EXTENSION);
					if(!empty($extArray)){
						if(in_array($extension,$extArray)){
							$content = file_get_contents($dir.'/'.$ff);
							$modifiedDate = filemtime($dir.'/'.$ff);
							$currentDate = strtotime("now");
							$seconds_diff = $currentDate - $modifiedDate;
							$passedTimeInDays = floor($seconds_diff/3600/24);

							if ($passedTimeInDays <= $noOfdays) {
								if(!array_key_exists($modifiedDate,$_SESSION)){
									$_SESSION[$modifiedDate] = $dir.'/'.$ff;
								}else{
									$modifiedDate++;
									$_SESSION[$modifiedDate] = $dir.'/'.$ff;
								}
							}
						}
					}
					else{
						$content = file_get_contents($dir.'/'.$ff);
						$modifiedDate = filemtime($dir.'/'.$ff);
						$currentDate = strtotime("now");
						$seconds_diff = $currentDate - $modifiedDate;
						$passedTimeInDays = floor($seconds_diff/3600/24);
						
						if ($passedTimeInDays <= $noOfdays) {
							if(!array_key_exists($modifiedDate,$_SESSION)){
								$_SESSION[$modifiedDate] = $dir.'/'.$ff;
							}else{
								$modifiedDate++;
								$_SESSION[$modifiedDate] = $dir.'/'.$ff;
							}
						}
					}
				}
			}
		}
		return $_SESSION;
	}
}
