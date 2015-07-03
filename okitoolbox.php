<?php
class okitoolbox {
	public function __construct(){
		
	}
	public function strcap($str,$action = "capitalize") { 
    $TRChars            = array("ş", "Ş", "ç","Ç","ö","Ö","ü","Ü","ğ","Ğ","ı","İ","i","I");  
    $TRCharsHandlers    = array("[sh]", "[SH]", "[ch]","[CH]","[oo]","[OO]","[uu]","[UU]","[gg]","[GG]","[ww]","[_W]","[_w]","[WW]");  
    $str = str_replace($TRChars,$TRCharsHandlers,$str); 
    if ($action == "capitalize") { 
        $str = strtolower($str); 
        $str_split = explode(' ',$str); 
        $str_return = ""; 
        for ($i = 0; $i < count($str_split); $i++) {  
            $sentence = $str_split[$i]; 
            if (substr($sentence,0,1) == "[") { 
                $str_return.= strtoupper(substr($sentence,0,4)); 
                $str_return.= substr($sentence,4,strlen($sentence))." ";             
                } 
                else 
                { 
                $str_return.= ucfirst($sentence)." "; 
                } 
            } 
        } 
    elseif ($action == "upper") { 
        $str_return = strtoupper($str); 
        } 
    elseif ($action == "lower") { 
        $str_return = strtolower($str); 
        } 
    $str_return = str_replace($TRCharsHandlers,$TRChars,$str_return); 
    //$str_return = ereg_replace("[-i]","i",$str_return); 
    return $str_return; 
	}
	
	public function utf_iso_tr($text){
		$output=iconv("UTF-8", "ISO-8859-9", $text);
		return $output;
	}
	
	public function iso_utf_tr($text){
		$text=iconv("ISO-8859-9","UTF-8", $text);
		return $text;
	}
	
	public function encrypt($key,$text){ 
    	$enc_text = @mcrypt_ecb (MCRYPT_3DES, $key, $text, MCRYPT_ENCRYPT); 
    	$enc_text = bin2hex($enc_text); 
    return $enc_text; 
	} 
	
	public function decrypt($key,$text){ 
    	$text = @pack('H*',$text); 
    	$text = @mcrypt_ecb (MCRYPT_3DES, $key, $text, MCRYPT_DECRYPT); 
   		return trim($text);
	}
	
	private function co_tr_sort($a, $b){
		$turkce = array('ç' => 'c', 'ğ' => 'g', 'ı' => 'i', 'ö' => 'o',
				'ş' => 's', 'ü' => 'u', 'Ç' => 'C', 'Ğ' => 'G',
				'İ' => 'I', 'Ö' => 'O', 'Ş' => 'S', 'Ü' => 'U');
	
		$a = preg_replace("/(ı|ğ|ü|ş|ö|ç|Ğ|Ü|Ş|İ|Ö|Ç)/e", "\$turkce['\\1'].'~'", $a);
		$b = preg_replace("/(ı|ğ|ü|ş|ö|ç|Ğ|Ü|Ş|İ|Ö|Ç)/e", "\$turkce['\\1'].'~'", $b);
	
		if ($a == $b)
			return 0;
	
		return ($a < $b) ? -1 : 1;
	}
	
	public function tr_sort(&$array) {
		return usort($array, "co_tr_sort");
	}
	
	public function browser_info($agent=null){
		$known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape','konqueror', 'gecko');
		$agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
		if (!preg_match_all($pattern, $agent, $matches)) return array();
		$i = count($matches['browser'])-1;
		return array($matches['browser'][$i] => $matches['version'][$i]);
	}
	
	public function gen_rnd_string($length=10,$characters = '023456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ',$string = '') {
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}
	
	public function calculate_gps($lat,$lng){
		$lat = (double) round($lat * 1e10) / 1e10;
		$lng = (double) round($lng * 1e10) / 1e10;
		$latDeg = floor($lat); $lat = ($lat - $latDeg) * 60;
		$latMin = floor($lat); $lat = ($lat - $latMin) * 600;
		$latSec = (double) floor($lat) / 10;
		$cLat   = ($latDeg < 0) ? "S" : "N";
		$latDeg = abs($latDeg);
		$lngDeg = floor($lng); $lng = ($lng - $lngDeg) * 60;
		$lngMin = floor($lng); $lng = ($lng - $lngMin) * 600;
		$lngSec = (double) floor($lng) / 10;
		$cLng   = ($lngDeg < 0) ? "W" : "E";
		$lngDeg = abs($lngDeg);
		$out_lat = $latDeg. "&deg; ".$latMin."' ".$latSec.'" '.$cLat;
		$out_lng = $lngDeg. "&deg; ".$lngMin."' ".$lngSec.'" '.$cLng;
		return array('lat'=>$out_lat,'lng'=>$out_lng);
	}
	
	public function html_qtrim($string){
		$search = array("”","“","&lsquo;","&rsquo;","&ldquo;","&rdquo;");
		$replace = array("\"","\"","'","'","\"","\"");
		return str_replace($search, $replace, $string);
	}
	
	public function tr_money_to_string($money,$input_format=0){
		$arr1 = array("","Bir","İki","Üç","Dört","Beş","Altı","Yedi","Sekiz","Dokuz");
		$arr10 = array("","On","Yirmi","Otuz","Kırk","Elli","Atmış","Yetmiş","Seksen","Doksan");
		$arr100 = array("","Yüz","İkiYüz","ÜçYüz","DörtYüz","BeşYüz","AltıYüz","YediYüz","SekizYüz","DokuzYüz");
		$add_word = array("","Bin","Milyon","Milyar","Trilyon","Katrilyon","Kentilyon","Seksilyon","Septilyon","Oktilyon");
		
		if($input_format==0){ //10000.25
			$money=number_format($money,2,',','.');
		}
		else if($input_format==1){ //10,000.25
			$money=str_replace(',','',$money);
			$money=number_format($money,2,',','.');
		}
		else if($input_format==2){ //10000,25
			$money=str_replace(',','.',$money);
			$money=number_format($money,2,',','.');
		}
		else if ($input_format==3){//10.000,25
			$money=$money;
		}
		$money_part1=explode(",",$money);
		$money_part2=explode(".",$money_part1[0]);
		
		$output='';
		$trees_len=count($money_part2);
		$addword_start=$trees_len-1;
		for($i=0;$i<$trees_len;$i++){
			if(strlen($money_part2[$i]*1)==3){
				$output.=$arr100[substr($money_part2[$i],0,1)].$arr10[substr($money_part2[$i],1,1)].$arr1[substr($money_part2[$i],2,1)];
			}
			else if(strlen($money_part2[$i]*1)==2){
				$output.=$arr10[substr($money_part2[$i]*1,0,1)].$arr1[substr($money_part2[$i]*1,1,1)];
			}
			else if(strlen($money_part2[$i]*1)==1){
				if(!($addword_start==1 and $money_part2[$i]*1==1)){
					$output.=$arr1[substr($money_part2[$i]*1,0,1)];
				}
			}
			if(($money_part2[$i]*1)>0){
				$output.=$add_word[$addword_start];
			}
			$addword_start=$addword_start-1;
		}
		if(substr($money_part1[1],0,1)==0 and substr($money_part1[1],1,1)==0){
			$output.='Lira';
		}
		else {
			$output.='Lira'.$arr10[substr($money_part1[1],0,1)].$arr1[substr($money_part1[1],1,1)].'Krş';
		} 
		return $output;
	}
	
	public function format_bytes($size, $precision = 2){
		$base = log($size) / log(1024);
		$suffixes = array('byte', 'kb', 'mb', 'gb', 'tb');
		return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
	}
	
	public function format_phone($phoneNumber) {
		$phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);
	
		if(strlen($phoneNumber) > 10) {
			$countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
			$areaCode = substr($phoneNumber, -10, 3);
			$nextThree = substr($phoneNumber, -7, 3);
			$lastFour = substr($phoneNumber, -4, 4);
	
			$phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
		}
		else if(strlen($phoneNumber) == 10) {
			$areaCode = substr($phoneNumber, 0, 3);
			$nextThree = substr($phoneNumber, 3, 3);
			$lastFour = substr($phoneNumber, 6, 4);
	
			$phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
		}
		else if(strlen($phoneNumber) == 7) {
			$nextThree = substr($phoneNumber, 0, 3);
			$lastFour = substr($phoneNumber, 3, 4);
	
			$phoneNumber = $nextThree.'-'.$lastFour;
		}
	
		return $phoneNumber;
	}
	
	public function place_patterned_str($str='', $vars=array(), $char='%'){
		if (!$str) return '';
		if (count($vars) > 0){
			foreach ($vars as $k => $v){
				$str = str_replace($char . $k, $v, $str);
			}
		}
		return $str;
	}
	
	public function super_unique($array){
		$result = array_map("unserialize", array_unique(array_map("serialize", $array)));
		foreach ($result as $key => $value){
			if (is_array($value) ){
				$result[$key] = super_unique($value);
			}
		}
		return $result;
	}
	
	public function replace_html_turkish_char($text){
		$chararr=array('&#304;'=>'İ','&#305;'=>'ı','&#231;'=>'ç','&#286;'=>'Ğ','&#287;'=>'ğ','&#199;'=>'Ç','&#351;'=>'ş','&#350;'=>'Ş','&Uuml;'=>'Ü','&uuml;'=>'ü','&Ouml;'=>'Ö','&ouml;'=>'ö');
		return str_replace(array_keys($chararr), array_values($chararr), $text);
	}
	
	function cget_data($url,$host,$referer,$cookie) {
		//$f = fopen('../tmp/request1.txt', 'w');
		$ch = curl_init();
		$userAgent='User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.91 Safari/537.36';
		$header=array(
				'Host: '.$host,
				'Connection: keep-alive',
				'Cache-Control: max-age=0',
				'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
				'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.91 Safari/537.36',
				'Referer: '.$referer,
				'Accept-Language: en-US,en;q=0.8'
		);
		$timeout = 60;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch,CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie);
		curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie);
		curl_setopt($ch,CURLOPT_REFERER,$referer);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // allow https verification if true
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 1);
	
		curl_setopt($ch,CURLOPT_USERAGENT,$userAgent);
		//curl_setopt($ch,CURLOPT_STDERR, $f);
		//curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
		//curl_setopt($ch,CURLOPT_HEADERFUNCTION, "readHeader");
		//curl_setopt($ch, CURLOPT_VERBOSE, true);
		$result=curl_exec($ch);
		curl_close($ch);
		//fclose($f);
		return $result;
	}
	private function cpost_data($url,$host,$fields,$referer,$cookie){
		//$f = fopen('tmp/request2.txt', 'w');
		$userAgent='User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.91 Safari/537.36';
		$header=array(
				'Host: '.$host,
				'Connection: keep-alive',
				'Cache-Control: no-cache',
				'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
				'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.91 Safari/537.36',
				'Referer: '.$referer,
				'Content-Type:application/x-www-form-urlencoded',
				'Accept-Language: en-US,en;q=0.8'
		);
		$timeout = 60;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch,CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie);
		curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie);
		curl_setopt($ch,CURLOPT_REFERER,$referer);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // allow https verification if true
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ch,CURLOPT_USERAGENT,$userAgent);
		curl_setopt($ch,CURLOPT_VERBOSE, true);
		//curl_setopt($ch,CURLOPT_STDERR, $f);
		//curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
		//curl_setopt($ch,CURLOPT_POST, count($fields));
		//curl_setopt($ch, CURLOPT_HEADERFUNCTION, "readHeader");
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));
		$result = curl_exec($ch);
		curl_close($ch);
		//fclose($f);
		return $result;
	}
	
	public function __destruct(){
	
	}
}
?>