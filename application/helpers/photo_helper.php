<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('cropImage'))
{
    function cropImage($source, $dest, $nw, $nh) {
    	$size = getimagesize($source);
    	$w = $size[0];
    	$h = $size[1];
         switch ($size[2]) {
         case 1: $simg = imagecreatefromgif($source); break;
         case 2: $simg = imagecreatefromjpeg($source); break;
         case 3: $simg = imagecreatefrompng($source); break;
         default: trigger_error('This is not an allowed image type.', E_USER_WARNING); break;
         }

    	$dimg = imagecreatetruecolor($nw, $nh);
    	$wm = $w/$nw;
    	$hm = $h/$nh;
    	$h_height = $nh/2;
    	$w_height = $nw/2;
    	if($w> $h) {
    		$adjusted_width = $w / $hm;
    		$half_width = $adjusted_width / 2;
    		$int_width = $half_width - $w_height;
    		imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
    	} elseif(($w <$h) || ($w == $h)) {
    		$adjusted_height = $h / $wm;
    		$half_height = $adjusted_height / 2;
    		$int_height = $half_height - $h_height;
    		imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
    	} else {
    		imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
    	}
    	imagejpeg($dimg,$dest,60);
    }
}

if (!function_exists('zmniejsz_fotke'))
{
    function zmniejsz_fotke($file_name_src, $file_name_dest, $weight,$quality=60)
        {
           if (file_exists($file_name_src)  && isset($file_name_dest))
           {
               $est_src = pathinfo(strtolower($file_name_src));
               $est_dest = pathinfo(strtolower($file_name_dest));
               $size = getimagesize($file_name_src);
               if ($size[0] > $weight OR $size[1] > 1000)
                     {
                     $w = number_format($weight, 0, ',', '');
                     $h = number_format(($size[1]/$size[0])*$weight,0,',','');
                     }
               else
                     {
                     $w = $size[0];
                     $h = $size[1];
                     }

               if ($est_dest['extension'] == "gif")
               {
                   $file_name_dest = substr_replace($file_name_dest, 'jpg', (-1*strlen($est_dest['extension'])));
               }

               $dest = imagecreatetruecolor($w, $h);

               switch($size[2])
               {
               case 1:       //GIF
                   $src = imagecreatefromgif($file_name_src);
                   break;
               case 2:       //JPEG
                   $src = imagecreatefromjpeg($file_name_src);
                   break;
               case 3:       //PNG
                   $src = imagecreatefrompng($file_name_src);
                   break;
               default:
                   return FALSE;
                   break;
               }
               imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);

               switch($size[2])
               {
               case 1:
                    imagegif($dest,$file_name_dest);
               case 2:
                    imagejpeg($dest,$file_name_dest, $quality);
                    break;
               case 3:
                    imagepng($dest,$file_name_dest);
               }
               return TRUE;
           }
           return FALSE;
        }
}
