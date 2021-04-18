<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
class number_in_words{


function amount_in_words($sum){
$sum=pricef($sum);
$rub=substr($sum, 0, strlen($sum)-3);
$kop=substr($sum, strlen($sum)-2);

$rub_in_words=$this->num2str($rub);

$rub_in_words=trim(mb_substr($rub_in_words, 0, mb_strlen($rub_in_words)-10));

$pos=strrpos($rub_in_words, ' ');
$ruble_rubla_rubley=trim(substr($rub_in_words, $pos));

$rub_in_words=substr($rub_in_words, 0, $pos);

 if(! $rub_in_words){
 $rub_in_words='ноль';
 $ruble_rubla_rubley='рублей';
 }

$kop_in_words=trim($this->num2str("0.$kop"));

$pos=strrpos($kop_in_words, ' ');
$kopeyka_kopeyki_kopeek=trim(substr($kop_in_words, $pos));

$kop_in_words=substr($kop_in_words, 0, $pos);

 if($kop_in_words=='00'){
 $kop_in_words='ноль';
 }

return array($rub_in_words, $ruble_rubla_rubley, $kop_in_words, $kopeyka_kopeyki_kopeek, $rub, $kop);
}


function num2str($inn){
$o = array();
$str= array();
$str[0] = array('','сто','двести','триста','четыреста','пятьсот','шестьсот','семьсот', 'восемьсот','девятьсот','тысяча'); 
$str[1] = array('','десять','двадцать','тридцать','сорок','пятьдесят','шестьдесят', 'семьдесят','восемьдесят','девяносто','сто'); 
$str[2] = array('','один','два','три','четыре','пять','шесть', 'семь','восемь','девять','десять'); 
$str[3] = array('','одна','две','три','четыре','пять','шесть', 'семь','восемь','девять','десять'); 
$str11 = array(11=>'одиннадцать',12=>'двенадцать',13=>'тринадцать',14=>'четырнадцать', 
15=>'пятнадцать',16=>'шестнадцать',17=>'семнадцать', 18=>'восемнадцать',19=>'девятнадцать',20=>'двадцать'); 
$forms = array( 
array('копейка', 'копейки', 'копеек', 3),
array('рубль', 'рубля', 'рублей', 2),
array('тысяча', 'тысячи', 'тысяч', 3),
array('миллион', 'миллиона', 'миллионов', 2),
array('миллиард','миллиарда','миллиардов',2),
array('триллион','триллиона','триллионов',2),
); 

$tmp = explode('.', str_replace(',','.', $inn));
$rub = $tmp[0];
$kop = isset($tmp[1]) ? str_pad(str_pad($tmp[1], 2, '0'), 3, '0',STR_PAD_LEFT) : '000';
$rub .= $kop; 

$levels = explode('-', number_format($rub,0,'','-') ); 
$offset = sizeof($levels)-1;


 foreach($levels as $k=>$level){

 $index = $offset-$k;
 $level = str_pad($level, 3, '0', STR_PAD_LEFT); 
 if(!empty($str[0][$level[0]])) $o[] = $str[0][$level[0]]; 
 $tmp = intval($level[1].$level[2]);

  if($tmp>20){
  $tmp = strval($tmp); 
   for($i=0,$m=strlen($tmp); $i<$m; $i++){
   $rod = $forms[$index][3]; 
   $tmp_o = ($i+1)==2 ? $str[$rod][$tmp[$i]] : $str[$i+1][$tmp[$i]]; 
   if(! empty($tmp_o)) $o[]= $tmp_o;
   } 
  }
  else{
  $o[] = ($tmp>10 ? $str11[$tmp] : $str[$forms[$index][3]][$tmp] );
  }

 $tmp_o = $this->pluralForm($level, $forms[$index][0], $forms[$index][1], $forms[$index][2]);
 if (!empty($tmp_o)) $o[] = $tmp_o;

 }

 
 if ('000'==$kop){
 $o[] = '00'; 
 $o[] = $forms[0][2]; 
 }

return implode(' ',$o); 
} 

function pluralForm($n, $f1, $f2, $f5){
 if(intval($n)==0 && ($f5 !== 'рублей') ){
 return '';
 }
$n = abs($n) % 100; 
$n1 = $n % 10; 
if ($n > 10 && $n < 20) return $f5; 
if ($n1 > 1 && $n1 < 5) return $f2; 
if ($n1 == 1) return $f1;
return $f5;
}



}
?>