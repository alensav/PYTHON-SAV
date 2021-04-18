<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class cache{

public $http_codes=array(200,404);
public $speriod=0;
public $nc_modules=array();
public $dchmod='0755';
public $fchmod='0644';

public function __construct(){
global $db, $cchset, $custom;
$cchset=$custom->get_settings(7);
$this->speriod=$cchset['period']*60;
$this->nc_modules=explode(',', $cchset['nocacheModules']);
}

public function get_from_cache(){
global $db, $sett, $mod, $pmmod, $view, $cchset;

  if( (isset($_SESSION['arwshop_mk']['cart_products']) && sizeof($_SESSION['arwshop_mk']['cart_products'])) || isset($_SESSION['arwshop_mk']['user']['userid']) || isset($_SESSION['arwshop_mk']['show_currency_id']) || isset($_SESSION['arwshop_mk']['design']) || $view === 'cart' || $view === 'order' || $pmmod || $_SERVER['REQUEST_METHOD']!=='GET' || isset($_SESSION['arwshop_mk']['order_complete']) ){
  return get_content(1);
  }

 if($mod){
  if(in_array($mod, $this->nc_modules)){
  return get_content(1);
  }
 }

 if($cchset['nocacheAdmin'] && isset($_SESSION['arwshop_mk']['mcinfo'])){
 return get_content(1);
 }

$request = substr($_SERVER['REQUEST_URI'], strlen($sett['relative_url']));
$tbl_cache = DB_PREFIX.'cache';
$res = $db->query("SELECT * FROM `$tbl_cache` WHERE `request` = '".$db->secstr($request)."'") or die($db->error());
$row = $db->fetch_array($res);
$row['reqid'] = intval($row['reqid']);
 if($row['reqid'] > 0 && time() < $row['mdate'] + $this->speriod){
 $dir = $this->ceil1000($row['reqid'])/1000;
  if($row['http_code'] != 200){
  header("HTTP/1.1 $row[http_code]");
  }
  if(! is_file(SCRIPTCHF_DIR."/ecache/$dir/$row[reqid].ec")){
  return $this->retGetContent($row['reqid'], $request);
  }
 return file_get_contents(SCRIPTCHF_DIR."/ecache/$dir/$row[reqid].ec");
 }
 else{
 return $this->retGetContent($row['reqid'], $request);
 }
}


public function retGetContent($reqid, $request){
$content = get_content(1);
$this->set_in_cache($reqid, $request, $content);
return $content;
}


public function set_in_cache($reqid, $request, $content){
global $db, $http_code;
$http_code = intval($http_code);
  if(! in_array($http_code, $this->http_codes)){
  return false;
  }
$tbl_cache=DB_PREFIX.'cache';
$mdate = time();
$reqid = intval($reqid);
 if($reqid > 0){
 $db->query("UPDATE `$tbl_cache` SET `mdate` = '$mdate', `http_code` = '$http_code' WHERE `reqid` = $reqid") or die($db->error());
 $new_file=false;
 }
 else{
 $request = $db->secstr($request);
 $db->query("INSERT INTO `$tbl_cache` (`reqid`, `request`, `mdate`, `http_code`) VALUES(NULL, '$request', '$mdate', '$http_code')") or die($db->error());
 $reqid = $db->insert_id();
 $new_file = true;
 }
$dir = $this->ceil1000($reqid)/1000;
 if(! is_dir(SCRIPTCHF_DIR."/ecache/$dir")){
 mkdir(SCRIPTCHF_DIR."/ecache/$dir", octdec($this->dchmod));
 }
$res = $this->put_to_file(SCRIPTCHF_DIR."/ecache/$dir/$reqid.ec", $content);
 if($new_file && $res && function_exists('chmod')){
 @chmod(SCRIPTCHF_DIR."/ecache/$dir/$reqid.ec", octdec($this->fchmod));
 }
return $res;
}


public function put_to_file($file,$data){
$fh=fopen($file,'wb');
if(! $fh){return false;}
flock($fh,2);
fputs($fh,$data);
flock($fh,3);
return fclose($fh);
}

public function ceil1000($n){
$l=$n % 1000 ;
if($l>0 && $l<500){$n+=500;}
return round($n, -3);
}


}
?>