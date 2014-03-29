<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


if(Nfo::check($g['id']) !== true)
	die('Nincs meg az nfo file');

$nfo = Nfo::getAll($g['id']);

if(!empty($g['id']) && empty($g['modul'])) {
	$replaces = array("/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^()<>\s]+)/i" => "\\1<a href=\"\\2\" target=\"_blank\"><u><font color=\"#0000FF\">\\2</font></u></a>");
	echo preg_replace(array_keys($replaces), array_values($replaces), $nfo['nfo']);
	exit;
}

switch($g['modul']) {
	case 'text':
		$tNfo = $nfo['nfo'];
	break;

	case 'image':
		$tNfo = $g['id'];
	break;

	case 'download':
		$filename = strtolower(fajlnev_atalakit('[' . OLDAL_NEVE . ']' . $nfo['name'] . '.nfo'));
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Type: application/x-nfo');
		echo $nfo['nfo'];
		exit;
	break;

	case 'flash':
		$nfolines = explode("\n", str_replace("\r", '', $nfo['nfo']));
		$width = 0;
		$height = 0;

		foreach($nfolines as $line) {
			if((strlen($line) * 9) > $width) {
				$width = strlen($line) * 9;
			}
			$height += 16;
		}

		require_once('kinezet/' . $USER['smink'] . '/style.php');
		$smarty->assign('width', $width);
		$smarty->assign('height', $height);
		$smarty->assign('NFO_flashbackground', $NFO_flashbackground);
		$tNfo = $g['id'];
	break;

	case 'render':
		$nfolines = explode("\n", str_replace("\r", '', $nfo['nfo']));
				
		$font = imageloadfont('rendszer/font/8x16.phpfont');
		$width = 0;
		$height = 0;
		$fontwidth = imagefontwidth($font);
		$fontheight = imagefontheight($font);

		foreach($nfolines as $line) {
			if((strlen($line) * $fontwidth) > $width)
				$width = strlen($line) * $fontwidth;

			$height += $fontheight;
		}

		$width += $fontwidth * 2;
		$height += $fontheight * 2;
		$image = imagecreate($width, $height);

		if($g['download'] == 1) {
			$transparent = imagecolorallocate($image, 255, 255, 255);
			$fontcolor = imagecolorallocate($image, 0, 0, 0);
		} else {
			require_once('kinezet/' . $USER['smink'] . '/style.php');
			$transparent = imagecolorallocate($image, $NFO_background['R'], $NFO_background['G'], $NFO_background['B']);
			$fontcolor = imagecolorallocate($image, $NFO_characters['R'], $NFO_characters['G'], $NFO_characters['B']);
			if($NFO_transparent) imagecolortransparent($image, $transparent);
		}

		$i = $fontheight;

		foreach($nfolines as $line) {
			imagestring($image, $font, $fontwidth, $i, $line, $fontcolor);
			$i += $fontheight;
		}
		$filename = strtolower(fajlnev_atalakit('[' . OLDAL_NEVE . ']' . $nfo['name'] . '-nfo.png'));

		if($g['download'] == 1)
			header('Content-Disposition: attachment; filename="' . $filename . '"');
		else
			header('Content-Disposition: inline; filename="' . $filename . '"');

		header('Content-Type: image/png');
		imagepng($image);
		exit;
	break;
}

$smarty->assign('modul', $g['modul']);
$smarty->assign('tNfo', $tNfo);
$smarty->display('nfo.tpl');
ob_end_flush();

?>
