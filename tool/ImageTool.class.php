<?php

class ImageTool{
	 public static function imageInfo($image){
		
		if(!file_exists($image)){
			return false;
		}
		$info = getimagesize($image);

		if($info == false){
			return false;
		}

		$img['width'] = $info[0];
		$img['height'] = $info[1];
		$img['ext']=substr($info['mime'],strpos($info['mime'], '/')+1);

		return $img;

	}


	//加水印功能
	public static function water($dst,$water,$save=NULL,$pos=2,$alpha=50){
		if(!file_exists($dst) || !file_exists($water)){
			echo "aaa";
			return false;
		}

		$dinfo = self::imageInfo($dst);
		$winfo = self::imageInfo($water);

		if($winfo['height']>$dinfo['height'] || $winfo['width'] > $dinfo['width']){
			return false;
		}

		$dfunc = 'imagecreatefrom'.$dinfo['ext'];
		$wfunc = 'imagecreatefrom'.$winfo['ext'];

		if(!function_exists($dfunc) || !function_exists($wfunc)){
			return false;
		}

		$dim = $dfunc($dst);
		$wim = $wfunc($water);


		switch ($pos) {
			case 0:
				$posx=0;
				$posy=0;
				break;
			case 1:
			$posx = $dinfo['width']-$winfo['width'];
			$posy = 0;
			
			case 3:
			$posx = 0;
			$posy = $dinfo['height']-$winfo['height'];

			default:
			$posx=$dinfo['width']-$winfo['width'];
			$posy=$dinfo['height']-$winfo['height'];
		}

		imagecopymerge($dim, $wim, $posx, $posy, 0, 0, $winfo['width'], $winfo['height'],$alpha);

		if(!$save){
			$save=$dst;
			unlink($dst);
		}
		$createfunc = 'image'.$dinfo['ext'];
		$createfunc($dim,$save);

		imagedestroy($dim);
		imagedestroy($wim);

		return true;
		}


		public static function thumb($dst,$save=null,$width=200,$height=200){
			$dinfo = self::imageInfo($dst);
			if($dinfo == false){
				return false;
			}

			//
			//$width/$dinfo['width'],$height/$dinfo['height'];

			$calc = min($width/$dinfo['width'],$height/$dinfo['height']);

			$dfunc='imagecreatefrom'.$dinfo['ext'];

			$dim=$dfunc($dst);

			$tim=imagecreatetruecolor($width, $height);

			$white = imagecolorallocate($tim, 255, 255, 255);

			imagefill($tim, 0, 0, $white);

			$dwidth=(int)$dinfo['width']*$calc;
			$dheight=(int)$dinfo['height']*$calc;

			$panddingx=(int)($width - $dwidth)/2;
			$panddingy=(int)($height - $dheight)/2;

			imagecopyresampled($tim,$dim,$panddingx,$panddingy, 0, 0, $dwidth,$dheight,$dinfo['width'], $dinfo['height']);

			if(!$save){
				$save = $dst;
				unlink($dst);
			}

			$createfunc = 'image'.$dinfo['ext'];
			$createfunc($tim,$save);

			imagedestroy($dim);
			imagedestroy($tim);
			return true;
		}
}
?>