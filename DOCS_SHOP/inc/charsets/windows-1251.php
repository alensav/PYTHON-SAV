<?php 
// ArwShop Market v3.3.10 Copyright (c) Igor Anikeev ( http://www.arwshop.ru/ ) 2006 - 2019.
// YOU CAN NOT SPREAD THIS SOFTWARE AND ITS SEPARATE PARTS NOT IN WHAT ITS KIND!
// ВЫ НЕ ИМЕЕТЕ ПРАВА ТИРАЖИРОВАТЬ, ИМИТИРОВАТЬ, РАСПРОСТРАНЯТЬ ДАННЫЙ ПРОГРАММНЫЙ ПРОДУКТ НИ В КАКОМ ЕГО ВИДЕ.
?><?php
$to_utf8_chars = array("\x80"=>"\xD0\x82","\x81"=>"\xD0\x83","\x82"=>"\xE2\x80\x9A","\x83"=>"\xD1\x93","\x84"=>"\xE2\x80\x9E","\x85"=>"\xE2\x80\xA6","\x86"=>"\xE2\x80\xA0","\x87"=>"\xE2\x80\xA1","\x88"=>"\xE2\x82\xAC","\x89"=>"\xE2\x80\xB0","\x8A"=>"\xD0\x89","\x8B"=>"\xE2\x80\xB9","\x8C"=>"\xD0\x8A","\x8D"=>"\xD0\x8C","\x8E"=>"\xD0\x8B","\x8F"=>"\xD0\x8F","\x90"=>"\xD1\x92","\x91"=>"\xE2\x80\x98","\x92"=>"\xE2\x80\x99","\x93"=>"\xE2\x80\x9C","\x94"=>"\xE2\x80\x9D","\x95"=>"\xE2\x80\xA2","\x96"=>"\xE2\x80\x93","\x97"=>"\xE2\x80\x94","\x98"=>"\x3F","\x99"=>"\xE2\x84\xA2","\x9A"=>"\xD1\x99","\x9B"=>"\xE2\x80\xBA","\x9C"=>"\xD1\x9A","\x9D"=>"\xD1\x9C","\x9E"=>"\xD1\x9B","\x9F"=>"\xD1\x9F","\xA0"=>"\xC2\xA0","\xA1"=>"\xD0\x8E","\xA2"=>"\xD1\x9E","\xA3"=>"\xD0\x88","\xA4"=>"\xC2\xA4","\xA5"=>"\xD2\x90","\xA6"=>"\xC2\xA6","\xA7"=>"\xC2\xA7","\xA8"=>"\xD0\x81","\xA9"=>"\xC2\xA9","\xAA"=>"\xD0\x84","\xAB"=>"\xC2\xAB","\xAC"=>"\xC2\xAC","\xAD"=>"\xC2\xAD","\xAE"=>"\xC2\xAE","\xAF"=>"\xD0\x87","\xB0"=>"\xC2\xB0","\xB1"=>"\xC2\xB1","\xB2"=>"\xD0\x86","\xB3"=>"\xD1\x96","\xB4"=>"\xD2\x91","\xB5"=>"\xC2\xB5","\xB6"=>"\xC2\xB6","\xB7"=>"\xC2\xB7","\xB8"=>"\xD1\x91","\xB9"=>"\xE2\x84\x96","\xBA"=>"\xD1\x94","\xBB"=>"\xC2\xBB","\xBC"=>"\xD1\x98","\xBD"=>"\xD0\x85","\xBE"=>"\xD1\x95","\xBF"=>"\xD1\x97","\xC0"=>"\xD0\x90","\xC1"=>"\xD0\x91","\xC2"=>"\xD0\x92","\xC3"=>"\xD0\x93","\xC4"=>"\xD0\x94","\xC5"=>"\xD0\x95","\xC6"=>"\xD0\x96","\xC7"=>"\xD0\x97","\xC8"=>"\xD0\x98","\xC9"=>"\xD0\x99","\xCA"=>"\xD0\x9A","\xCB"=>"\xD0\x9B","\xCC"=>"\xD0\x9C","\xCD"=>"\xD0\x9D","\xCE"=>"\xD0\x9E","\xCF"=>"\xD0\x9F","\xD0"=>"\xD0\xA0","\xD1"=>"\xD0\xA1","\xD2"=>"\xD0\xA2","\xD3"=>"\xD0\xA3","\xD4"=>"\xD0\xA4","\xD5"=>"\xD0\xA5","\xD6"=>"\xD0\xA6","\xD7"=>"\xD0\xA7","\xD8"=>"\xD0\xA8","\xD9"=>"\xD0\xA9","\xDA"=>"\xD0\xAA","\xDB"=>"\xD0\xAB","\xDC"=>"\xD0\xAC","\xDD"=>"\xD0\xAD","\xDE"=>"\xD0\xAE","\xDF"=>"\xD0\xAF","\xE0"=>"\xD0\xB0","\xE1"=>"\xD0\xB1","\xE2"=>"\xD0\xB2","\xE3"=>"\xD0\xB3","\xE4"=>"\xD0\xB4","\xE5"=>"\xD0\xB5","\xE6"=>"\xD0\xB6","\xE7"=>"\xD0\xB7","\xE8"=>"\xD0\xB8","\xE9"=>"\xD0\xB9","\xEA"=>"\xD0\xBA","\xEB"=>"\xD0\xBB","\xEC"=>"\xD0\xBC","\xED"=>"\xD0\xBD","\xEE"=>"\xD0\xBE","\xEF"=>"\xD0\xBF","\xF0"=>"\xD1\x80","\xF1"=>"\xD1\x81","\xF2"=>"\xD1\x82","\xF3"=>"\xD1\x83","\xF4"=>"\xD1\x84","\xF5"=>"\xD1\x85","\xF6"=>"\xD1\x86","\xF7"=>"\xD1\x87","\xF8"=>"\xD1\x88","\xF9"=>"\xD1\x89","\xFA"=>"\xD1\x8A","\xFB"=>"\xD1\x8B","\xFC"=>"\xD1\x8C","\xFD"=>"\xD1\x8D","\xFE"=>"\xD1\x8E","\xFF"=>"\xD1\x8F");
?>