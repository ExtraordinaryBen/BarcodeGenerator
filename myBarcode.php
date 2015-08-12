<?php

require_once('tcpdf/tcpdf_barcodes_1d.php');

class myBarcode extends TCPDFBarcode {
	protected $labelName, $codeType, $width, $height, $codeColor;
	
	public function __construct($name, $type, $w=2, $h=30, $color='black') {
		global $labelName, $codeType, $width, $height, $codeColor;
		$this->setBarcode(null, $type);
		$labelName = $name;
		$codeType = $type;
		$width = $w;
		$height = $h;
		$codeColor = $color;
	}
	
	function makeHTMLbarcode($code) {
	  global $labelName, $codeType, $width, $height, $codeColor;
	  $this->setBarcode($code, $codeType);
	  return '<div id="'.$code.'" class="barcode" align="center"><span class="barcode-label">'.strtoupper ($labelName).'</span><br/>' . $this->getBarcodeSVGcode($width, $height) . '<br/><span class="barcode-number">'.$code.'</span></div>';
	}

	function makeHTMLsequence($code, $prefix, $quantity) {
	  $html = '';
	  $col = 0;
	  for($i = 1; $i <= $quantity; $i++)  {
	    if($col == 0)
	      $html .= '<tr>';
	    $html .= '<td>'.$this->makeHTMLbarcode($prefix . ($code+$i)).'</td>';
	    if($col < 2)
	      $col++;
	    else {
	      $html .= '</tr>';
	      $col = 0;
	    }
	  }
	  $html .= '</tr>';
	  return $html;
	}

	public function makeBarcodePNG($w=2, $h=30, $color=array(0,0,0)) {
		// calculate image size
		$width = ($this->barcode_array['maxw'] * $w);
		$height = $h;
		if (function_exists('imagecreate')) {
			// GD library
			$imagick = false;
			$png = imagecreate($width, $height);
			$bgcol = imagecolorallocate($png, 255, 255, 255);
			imagecolortransparent($png, $bgcol);
			$fgcol = imagecolorallocate($png, $color[0], $color[1], $color[2]);
		} elseif (extension_loaded('imagick')) {
			$imagick = true;
			$bgcol = new imagickpixel('rgb(255,255,255');
			$fgcol = new imagickpixel('rgb('.$color[0].','.$color[1].','.$color[2].')');
			$png = new Imagick();
			$png->newImage($width, $height, 'none', 'png');
			$bar = new imagickdraw();
			$bar->setfillcolor($fgcol);
		} else {
			return false;
		}
		// print bars
		$x = 0;
		foreach ($this->barcode_array['bcode'] as $k => $v) {
			$bw = round(($v['w'] * $w), 3);
			$bh = round(($v['h'] * $h / $this->barcode_array['maxh']), 3);
			if ($v['t']) {
				$y = round(($v['p'] * $h / $this->barcode_array['maxh']), 3);
				// draw a vertical bar
				if ($imagick) {
					$bar->rectangle($x, $y, ($x + $bw - 1), ($y + $bh - 1));
				} else {
					imagefilledrectangle($png, $x, $y, ($x + $bw - 1), ($y + $bh - 1), $fgcol);
				}
			}
			$x += $bw;
		}
		// send headers
		//header('Content-Type: image/png');
		//header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
		//header('Pragma: public');
		//header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		//header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		if ($imagick) {
			$png->drawimage($bar);
			echo $png;
		} else {
			// start buffering
			ob_start();
			imagepng($png);
			$contents =  ob_get_contents();
			ob_end_clean();
			imagedestroy($png);
			return '<img src="data:image/png;base64,'.base64_encode($contents).'" />';
		}
	}

}

?>