<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('createDateRangeArray')) {
function createDateRangeArray($strDateFrom,$strDateTo)
{
    $aryRange=array();
    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}
}

if (!function_exists('gridMaxNumber')) {
function gridMaxNumber ($array, $all, $dest)
    {
        $ret = 0; $min = min($all, $dest);
        if (empty($array) || !$dest || !$all) return $ret;
        foreach ($array AS $a) { if ($a <= $min) $ret = $a; }
        return $ret;
    }
}

if (!function_exists('datePL')) {
function datePL($format,$timestamp=null)
    {
    	$to_convert = array(
    		'l'=>array('dat'=>'N','str'=>array('Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota','Niedziela')),
    		'F'=>array('dat'=>'n','str'=>array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień')),
    		'f'=>array('dat'=>'n','str'=>array('stycznia','lutego','marca','kwietnia','maja','czerwca','lipca','sierpnia','września','października','listopada','grudnia'))
    	);
    	if ($pieces = preg_split('#[:/.\-, ]#', $format))
            {
    		          if ($timestamp === null) { $timestamp = time(); }
        		foreach ($pieces as $datepart)
                    {
            			if (array_key_exists($datepart,$to_convert))
                            {
            				    $replace[] = $to_convert[$datepart]['str'][(date($to_convert[$datepart]['dat'],$timestamp)-1)];
            			    }
                            else
                            {
            				    $replace[] = date($datepart,$timestamp);
            			    }
            		}
    		$result = strtr($format,array_combine($pieces,$replace));
    		return $result;
    	   }
    }
}

if (!function_exists('clear_text')) {
function clear_text($text)
    {
        $text = strip_tags($text);
        $text = trim($text);
        return $text;
    }
}

if (!function_exists('decorate_file_size')) {
function decorate_file_size($waga)
    {
        if ($waga < 1000) { $waga .=' KB'; }
        else { $waga = dec1($waga/1000) . ' MB'; }
        return $waga;
    }
}

if (!function_exists('dec1')) {
function dec1($val)
     {
     return number_format($val, 1, '.', '');
     }
}

if (!function_exists('dec2')) {
function dec2($val)
     {
     return number_format($val, 2, '.', '');
     }
}

if ( !function_exists('pre'))
{
    function pre($var, $stop = false)
    {
        echo '<hr>';
        echo '<pre style="text-align: left; clear: both; margin-left: 250px;">';
        if (is_array($var) || is_object($var))
            {
                print_r($var);
            }
            else
            {
                var_dump($var);
            }
        echo '</pre>';
        echo '<hr>';
        if ($stop) exit;
    }
}

if ( !function_exists('cuts'))
{
    function cuts($tekst, $len = 200)
    {
    	$tekst = preg_replace('/&\w;/', '',strip_tags($tekst)); //usuwa znaczniki html
    	$tekst = str_replace(array('&nbsp;', "\n"),' ',$tekst);
    	while(strpos($tekst, '  ') !== false) { $tekst = str_replace("  ", " ",$tekst); }

        $str = $tekst;
        if( strlen($tekst) > $len) {
            $exp = explode("\n", wordwrap($tekst, $len));
            foreach ($exp AS $e)
                {
                    if (strlen(trim($e)) != 0)
                        {
                            $str = $e.'...';
                            return trim($str);
                        }
                }

        }

    	return trim($str);
    }
}


if ( !function_exists('no_pl'))
{
    function no_pl($tekst)
    {
       $tabela = Array(
       //WIN
        "\xb9" => "a", "\xa5" => "A", "\xe6" => "c", "\xc6" => "C",
        "\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
        "\xf3" => "o", "\xd3" => "O", "\x9c" => "s", "\x8c" => "S",
        "\x9f" => "z", "\xaf" => "Z", "\xbf" => "z", "\xac" => "Z",
        "\xf1" => "n", "\xd1" => "N",
       //UTF
        "\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C",
        "\xc4\x99" => "e", "\xc4\x98" => "E", "\xc5\x82" => "l", "\xc5\x81" => "L",
        "\xc3\xb3" => "o", "\xc3\x93" => "O", "\xc5\x9b" => "s", "\xc5\x9a" => "S",
        "\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
        "\xc5\x84" => "n", "\xc5\x83" => "N",
       //ISO
        "\xb1" => "a", "\xa1" => "A", "\xe6" => "c", "\xc6" => "C",
        "\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
        "\xf3" => "o", "\xd3" => "O", "\xb6" => "s", "\xa6" => "S",
        "\xbc" => "z", "\xac" => "Z", "\xbf" => "z", "\xaf" => "Z",
        "\xf1" => "n", "\xd1" => "N",
        //I to co nie potrzebne
       "$" => "-", "!" => "-", "@" => "-", "#" => "-", "%" => "-");
       $tekst = strtr($tekst,$tabela);
       $tekst = trim(preg_replace("/[^\w]+/","-",$tekst), '-');
       return $tekst;
    }
}

if ( !function_exists('getContrast'))
{
    function getContrast($hexcolor)
    {
    	$r = hexdec(substr($hexcolor,0,2));
    	$g = hexdec(substr($hexcolor,2,2));
    	$b = hexdec(substr($hexcolor,4,2));
    	$yiq = (($r*299)+($g*587)+($b*114))/1000;
    	return ($yiq >= 128) ? '000000' : 'FFFFFF';
    }
}

if ( !function_exists('checkDateTimeFormat'))
{
    function checkDateTimeFormat($data)
    {
        if (date('Y-m-d H:i:s', strtotime($data)) == $data) {
            return true;
        } else {
            return false;
        }
    }
}

if ( !function_exists('checkDateFormat'))
{
    function checkDateFormat($data)
    {
        if (date('Y-m-d', strtotime($data)) == $data) {
            return true;
        } else {
            return false;
        }
    }
}

if ( !function_exists('nowDateTime'))
{
    function nowDateTime($hours = true)
    {
        if ($hours == false)
            return date('Y-m-d 00:00:00');
        return date('Y-m-d H:i:s');
    }
}

if ( !function_exists('commentsText'))
{
    function commentsText($n)
    {
        if ($n == 0)
            {
                $ret = 'brak komentarzy';
            }
            else if ($n == 1)
            {
                $ret = '1 komentarz';
            }
            else if ($n > 1 && $n < 5)
            {
                $ret = $n.' komentarze';
            }
            else
            {
                $ret = $n.' komentarzy';
            }
        return $ret;
    }
}
