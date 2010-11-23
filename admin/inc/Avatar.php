<?php
/**
	handle image uploading
**/

function aspect_ratio ($width, $height, $max_width) {
	return abs ($height / ($width / $max_width));
}
		
		
class Avatar {
	//Folder where images are stored
	private $_UploadDir		= '../uploads/';
	
	//Folder where thumbs are stored
	private $_ThumbsDir		= '../uploads/thumbs/';
	
	//Picture filetype
	private $_FileExt 		= '.jpg';
	
	//Thumb prefix. E.g. "thumbs_"
	private $_ThumbPrefix	= '';
	
	//Picture max file size. Default: 6MB
	private $_MaxFilesize 	= 6144;
	
	
	//Whether we want to create thumbs
	private $_Makethumb		= true;
	
	//Whether we shall resize images
	private $_ResizeImg		= true;
	
	//Max width of image
	private $_MaxImageWidth	= 140;
	
	//Max height of image
	private $_MaxImageHeight= 160;
	
	//Desired width of thubmnails
	private $_MaxThumbWidth	= 60;
	
	//Desired height of thumbnails
	private $_MaxThumbHeight= 60;
	
	//Whether we shall add waterwark
	private $_Watermark	= true;
	
	//Text on images, if watermark is true
	private $_WatermarkText	= 'dProfile';
	
	//Whether we want to add a logo to the image
	//If this is true, watermark will automatically be set to false
	private $_AddLogo		= false;
	
	//Id addLogo is true, specify SRC of logo
	//Best result: GIF transparent
	//Supports JPG, PNG and GIF
	private $_LogoSRC		= '../logo.gif';
	
	//Desired color on watermark text
	private $_WatermarkColor= '#ffffff';
	
	//Which font the watermark will be using
	//If the server don't have Freetype installed, you have to upload the font
	//onto the server
	private $_WatermarkFont	= '../fonts/arial.ttf';
	
	//Maximum width of the uploaded image
	private $_MaxWidth		= 4000;
	
	//Maximum height of uploaded image
	private $_MaxHeight		= 4000;
	
	//Picture quality
	//Value from 0-100
	private $_JPGQuality	= 100;
	
	
	/**
		
		--- Dont edit below, thanks
		
	**/
	
	public function set_vars ($uploaddir, $thumbsdir, $image_w = 600, $image_h = 450, $watermark = false) {
		$this->_UploadDir = $uploaddir;
		$this->_ThumbsDir = $thumbsdir;
		$this->_Watermark = $watermark;
		$this->_MaxImageWidth = $image_w;
		$this->_MaxImageHeight = $image_h;
	}
	
	function validPictureExt ($Temp) { 
		$exif_imagetype = exif_imagetype ($Temp); 
			 
		switch ($exif_imagetype) { 
			case IMAGETYPE_GIF :  
			case IMAGETYPE_JPEG :  
			case IMAGETYPE_PNG :  
				return true; 
				 
			default :  
				return false; 
		} 
	}
	
	private function deletePicture ($del) {
			unlink ($del);
	}
	
	private function validPicture ($fil) {
		$imgInfo = getimagesize ($fil);
		
		if ($imgInfo[2] <= 3 && $imgInfo[2] > 0 && $imgInfo[0] <= $this->_MaxWidth || $imgInfo[1] <= $this->_MaxHeight && filesize ($fil) <= $this->_MaxFilesize && $this->rgb () != false) {
			return true;	
		}
		
		return false;	
	}
	
	public function move ($temp_name, $new_name) {
		if (!$this->validPicture ($temp_name)) {
			return false;
		}
		
		if (!$this->resize  ($temp_name, $this->_ThumbPrefix . $new_name . $this->_FileExt, $this->_MaxThumbWidth, $this->_MaxThumbHeight, $this->_ThumbsDir, true))
			return false;
			
		$this->resize  ($temp_name, $new_name . $this->_FileExt, $this->_MaxImageWidth, $this->_MaxImageHeight, $this->_UploadDir, false);
			
		$this->deletePicture  ($temp_name);	
			
		return true;
	}
	
	private function resize  ($img_name, $bildenavn, $picsize, $max_height, $dir, $thumb = false) {
	    $bildetekst = $this->_WatermarkText;
	    $fontsize = ceil ($picsize / 17);
	    $fontfile = $this->_WatermarkFont;
		
		$imgInfo = getimagesize ($img_name);
		$imgType = $imgInfo[2];
		
		
		switch  ($imgType) {
			case 2:
				$src_img = @imagecreatefromjpeg ($img_name);
			break;	
			case 3:
				$src_img = @imagecreatefrompng ($img_name);
				break;
			case 1:
				$src_img = @imagecreatefromgif ($img_name);
			break;
			default:
				return false;
		}
		
		if (!$src_img) {
			return false;	
		}
		
		//NewWidth = GivenHeight * (OriginalWidth / OriginalHeight)
		//NewHeight = GivenWidth * (OriginalHeight / OriginalWidth)
		
		list ($new_w, $new_h, $type, $attr) = $imgInfo;
		
		$new_width = $picsize;
		
		if ($new_h > $new_w && $new_w < $picsize) {
			$new_width = $new_w;
		}
		
		$new_h = aspect_ratio ($new_w, $new_h, $new_width);
			
		if ($new_h > 250) {
			$new_h = aspect_ratio ($new_w, $new_h, $new_width);
			$new_h = 250;
		}
		
		if ($thumb && $new_h > ($picsize*2)) {
			$new_h = aspect_ratio ($new_w, $new_h, $new_width);
		}
			
		
		if ($new_w > $picsize) {
			$new_w = $picsize;
		}
		
		/*	if ($new_w > $new_h) {
			// landscape image
			
			$org_h = $new_h;
			
			$new_h = ($new_w * $new_h / $new_w) / 2;
			$new_w = $picsize;
			
			if ($new_h < 50 && $org_h < $max_height) {
				$new_h = $org_h;
			}
			
			if ($new_h > $max_height) {
				$new_h = $picsize;
				$new_w = ($max_height * $new_w / $new_h);
			}
		} elseif ($new_h > $new_w) {
			// portrait image
			
			$new_h = $max_height;
			$new_w = (int)($max_height * $new_w / $new_h);
			
			if ($new_w > $picsize) {
				$new_w = $picsize;
				$new_h = ($picsize * $new_h / $new_w);
			}
		} else {
			// square image
			$new_w = $picsize;
			$new_h = $max_height;
		}
		
		if ($new_w == 0) {
			$new_w = $picsize;
			
			if ($new_w > $imgInfo[0]) {
				$new_w = $imgInfo[0];
			}
		}*/
		
		if (!$thumb) {
			if ($this->_MaxImageWidth > $imgInfo[0] && $this->_MaxImageHeight > $imgInfo[1]) {
				$new_w = $imgInfo[0];
				$new_h = $imgInfo[1];
			}
		}
		
		/*if ($new_h > $imgInfo[1]) {
			$new_h = $imgInfo[1];
		}*/

		$new_img = imagecreatetruecolor ($new_w, $new_h);
	    
	        
	    if (imagecopyresampled ($new_img, $src_img, 0, 0, 0, 0, $new_w, $new_h, imagesx ($src_img), imagesy ($src_img)) == false) {
	    	return false;	
	    }
	    
	    if ($this->_AddLogo == true && $thumb == false) {
	    	$logoinfo =	getimagesize ($this->_LogoSRC);
	    	
	    	if ( ( $logoinfo[0] <= $new_w + 70 ) &&  ( $logoinfo[1] <= $new_h + 50 )) {
	    	
		    	switch  ($logoinfo[2]) {
		    		case 2:
		    			$logo_src = @imagecreatefromjpeg ($this->_LogoSRC);
		    		break;
		    		case 3:
		    			$logo_src = imagecreatefrompng ($this->_LogoSRC);
		    		break;
		    		case 1:	
		    			$logo_src = @imagecreatefromgif ($this->_LogoSRC);
		    			break;
		    		default:
		    			return false;
		    		break;
		    	}
		    	
		    	if (!$logo_src) {
		    		return false;	
		    	}
		    	
		    	$dst_x = $new_w - $logoinfo[0] - 5;
		    	$dst_y = $new_h - $logoinfo[1] - 5;
		    	
		    	imagecopymerge ($new_img, $logo_src, $dst_x, $dst_y, 0, 0, $logoinfo[0], $logoinfo[1], 100);
	    	}
	    } elseif ($this->_Watermark == true && $thumb == false) {
	   
		    $colors = $this->rgb ();
		    $textcolor = imagecolorallocate ($new_img, $colors[0], $colors[1], $colors[2]); //Farge på teksten
		 
		    $textinfo = imagettfbbox ($fontsize, 0, $fontfile, $bildetekst);
		    $stringwidth = $textinfo[2] - $textinfo[0]; 
		    $y = $new_h - 5;
		    $x = $new_w - $stringwidth - 5;
	    	
		    imagettftext ($new_img, $fontsize, 0, $x, $y, $textcolor, $fontfile, $bildetekst); 
		    
	    }
		
		$savepos = $dir . $bildenavn;
	   
	    switch  ($imgType) {
			case 2:
				if ($this->_JPGQuality > 100) $this->_JPGQuality = 100;
				if ($this->_JPGQuality < 0 ) $this->_JPGQuality = 75;
				imageinterlace ($new_img, 1);
				imagejpeg ($new_img, $savepos, $this->_JPGQuality);
			break;	
			case 3:
				#imageantialias ($new_img, true);
				imagepng ($new_img, $savepos);
			break;
			case 1:
				#imageantialias ($new_img, true);
				imagepng ($new_img, $savepos);	
				//imagegif ($new_img, $savepos);
			break;
			default:
				return false;
			break;
		}
		
		imagedestroy ($new_img);
		imagedestroy ($src_img);
		return true;
	}
	
	private function rgb () {
		$validPictureHexes = array ();
		if (preg_match ('/^#[0-9a-fA-F]{6}$/', $this->_WatermarkColor, $validPictureHexes)) {
			//Første steg fullført
			//Stringen inneholder riktige tegn, og riktig antall.
			
			$r = hexdec (substr ($validPictureHexes[0], 1, 2));
			$g = hexdec (substr ($validPictureHexes[0], 3, 2));
			$b = hexdec (substr ($validPictureHexes[0], 5, 2));
			
			if ( ($r <= 255)&& ($g <= 255)&& ($b <= 255)) {
				return array ($r, $g, $b);
			} else {
				return false;	
			}	
		} else {
			return false;
		}	
	}
	
	private function setFolders ($img, $thumb) {
		$this->_UploadDir = $img;
		$this->_ThumbsDir = $thumb;
	}
	
	private function setBredde ($bredde) {
		$this->_MaxImageWidth = $bredde;
	}
	
	private function setHoyde ($hoyde) {
		$this->_MaxImageHeight = $hoyde;	
	}
	
	private function setThumbBredde ($bredde) {
		$this->_MaxThumbWidth = $bredde;	
	}
	
	private function setThumbHoyde ($hoyde) {
		$this->_MaxThumbHeight = $hoyde;	
	}
	
	private function makeThumb ($thumb) {
		$this->_MakeThumb =  (bool) $thumb;	
	}
	
	private function writeString ($string) {
		$this->_Watermark =  (bool) $string;	
	}
 
	private function setStringColor ($color) {
		if ($this->rgb ($color) != false) {
			$this->_WatermarkColor = $color;
		} else {
			return false;
		}
	}
	
	private function setString ($string) {
		$this->_WatermarkText = substr ($string, 0, 15);
	}
	
	private function setStringFont ($font) {
		$this->_WatermarkFont = $font;	
	}
	
	private function setLogoSrc ($src) {
		$this->_LogoSRC = $src;	
	}
	
	private function addLogo ($addLogo = false) {
		$this->_AddLogo = $addLogo;	
	}
	
	private function remImg ($src) {
		imagedestroy ($src);	
	}
}
?>
