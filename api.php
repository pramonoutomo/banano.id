<?php
if(isset($_GET['wallet'])){
	$wallet=$_GET['wallet'];
	if (!preg_match("/ban_/", $wallet)) {
		$wallet="ban_1burnbabyburndiscoinferno111111111111111111111111111aj49sw3w";
	}else{
		if(strlen($wallet)!=64){
			$wallet="ban_1burnbabyburndiscoinferno111111111111111111111111111aj49sw3w";
		}
	}
}else{
	$wallet="ban_1burnbabyburndiscoinferno111111111111111111111111111aj49sw3w";
}


//qrcode
$data = $wallet;
$size = isset($_GET['size']) ? $_GET['size'] : '235x235';
$logo = 'images/banano-mark.png';
$tempdir = "temp/";
header('Content-type: image/png');
// Get QR Code image from Google Chart API
// http://code.google.com/apis/chart/infographics/docs/qr_codes.html
$QR = imagecreatefrompng('https://chart.apis.google.com/chart?cht=qr&chld=L|0&chs='.$size.'&chl='.urlencode($data));
if($logo !== FALSE){
    $logo = imagecreatefromstring(file_get_contents($logo));
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);

    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Scale logo to fit in the QR Code
    $logo_qr_width = $QR_width/3;
    $scale = $logo_width/$logo_qr_width;
    $logo_qr_height = $logo_height/$scale;

    imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/2.7, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
    imagepng($QR,$tempdir.'qrwithlogo2.png');
}


//gabungkan gambar dengan qr frame monyet
$dest = imagecreatefrompng('images/qrcodeframe.acc2d3e3.png');
$src = imagecreatefromstring(file_get_contents($tempdir.'qrwithlogo2.png'));

imagealphablending($dest, false);
imagesavealpha($dest, true);

imagecopymerge($dest, $src, 120, 170, 0, 0, 235, 235, 100); //have to play with these numbers for it to work for you, etc.

imagepng($dest,$tempdir.'qrwithlogo2.png');


// open the file in a binary mode
$name = $tempdir.'qrwithlogo2.png';
//$name = $tempdir.'qrwithlogo-'.$wallet.'.png';
$fp = fopen($name, 'rb');

// send the right headers
header("Content-Type: image/png");
header("Content-Length: " . filesize($name));

// dump the picture and stop the script
fpassthru($fp);


//remove all images temp
//$dir = "temp";
//$di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
//$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
//foreach ( $ri as $file ) {
//    $file->isDir() ?  rmdir($file) : unlink($file);
//}
//return true;

exit;
?>
