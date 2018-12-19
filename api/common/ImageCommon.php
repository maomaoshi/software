<?php
namespace Common;
/**
* 
*/
class ImageCommon 
{	
	public $width;
	private $height ;
	private $fontSize ;
	private $fontFile ;
	function __construct()
	{
		$this->width = 120;
		$this->height = 60;
		$this->fontSize = $this->height / 2;
		$this->fontFile = 'AnkeCalligraph.TTF';
	}	

	private function create_captcha()
	{
		$codeRange = '0123456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
		$len = strlen($codeRange);
		$code = '';
		for($i = 0; $i < 4; $i++){
			$code .= $codeRange[mt_rand(0, $len - 1)];
		}
		return $code;
	}

	//随机产生一个背景颜色（暗色）
	public function RandomBackColor($imgSource)
	{
		return imagecolorallocate($imgSource, mt_rand(0,128), mt_rand(0, 128), mt_rand(0, 128));
	}

	//随机产生一个颜色（亮色）
	public function RandomColor($imgSource)
	{
		return imagecolorallocate($imgSource, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));
	}

	public function create_image()
	{
		
		//创建一个画布
		$width = $this->width;
		$height = $this->height;
		$img = imagecreatetruecolor($this->width, $this->height);
		//填充背景
		imagefill($img, 0, 0, $this->RandomBackColor($img));

		//添加一些干扰直线
		for ($i = 0; $i < 3 ; $i++) { 
			imageline($img, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200), $this->RandomColor($img));
		}

		//添加一些干扰弧线
		for ($i = 0; $i < 3 ; $i++) { 
			imagearc($img, mt_rand(- $width, $width), mt_rand(- $height, $height), mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, 360), mt_rand(0, 360), $this->RandomColor($img));
		}

		//添加一些干扰点
		for ($i = 0; $i < 3 ; $i++) { 
			imagesetpixel($img, mt_rand(0,150), mt_rand(0,60), $this->RandomColor($img));
		}

		$captcha = $this->create_captcha();
		$_SESSION['captcha'] = $captcha;
		//var_dump($code);
		//添加验证码到图像
		$x = 10;
		$dx = ($this->width - 10)/4;
		$y = $this->height - ($this->height - $this->fontSize) / 2;
		for($i = 0; $i < 4; ++ $i){
		    imagettftext($img, $this->fontSize, mt_rand(-15, 15), $x, $y, $this->RandomColor($img), $this->fontFile, $captcha[$i]);
		    $x += $dx;
		}
		ob_clean();   // ob_clean()清空输出缓存区
		header('Content-Type: image/png');
		imagepng($img);             // 输出图像
	}

}