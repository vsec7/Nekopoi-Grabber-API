<?php
error_reporting(0);
header("Content-Type: application/json;charset=utf-8");


// Coded by Versailles - Sec7or Team
// Don't Change Copyright


function curl($url){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) ChromeHD/52.0.2743.82 Safari/537.36');
$ret = curl_exec($ch);
$ret = str_replace(urldecode('%0A'), '', $ret);
return $ret;
}

if(isset($_GET['hal'])){

if($_GET['hal'] == 1){
$f = curl("http://nekopoi.bid/");
}else{
$f = curl("http://nekopoi.bid/page/".$_GET['hal']."/");
}

preg_match_all('/<div class="eropost">(.*?)<soan>/',$f,$data);

foreach($data[1] as $d){

preg_match('/<a href="http:\/\/nekopoi.bid\/(.*?)\/">(.*?)<\/a>/',$d,$l); 

preg_match('/<img src="(.*?)">/',$d,$i);
preg_match('/<span>(.*?)<\/span>/',$d,$r);

$o['title'] = $l[2];
$o['images'] = $i[1];
$o['video'] = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?vid=".$l[1];
$o['uploaded'] = $r[1];

$res[] = $o;
//print_r($r);
}

echo json_encode($res, JSON_PRETTY_PRINT);
}

if(isset($_GET['vid'])){
$f = curl("http://nekopoi.bid/".$_GET['vid']."/");

preg_match('/<b>Anime : <\/b>(.*?)<\/p>/',$f,$t); //title
preg_match('/Sinopsis :<\/b><\/p>(.*?)<\/p>/',$f,$s); //synopsis
preg_match('/Duration : <\/b>(.*?)<\/p>/',$f,$d); //duration
preg_match('/<b>Producers <\/b>:(.*?)<\/p>/',$f,$p); //producer

preg_match('/Genre : (.*?)"\/>/',$f,$g); //genre

preg_match('/<iframe src="(.*?)"/',$f,$hd); //video

//print_r($g);
$v['title'] = $t[1];
$v['video'] = $hd[1];
$v['duration'] = $d[1];
$v['synopsis'] = $s[1];
$v['producer'] = $p[1];
$v['genre'] = $g[1];

echo json_encode($v, JSON_PRETTY_PRINT);

}

if(isset($_GET['usage'])){

print "NekoPoi Unofficial API\n\n";

print "# Cara pakai :\n\n";
print "# >> Get konten home\n";
print "# > Parameter : hal=\n";
print "# GET ". $_SERVER['PHP_SELF']."?hal=(angka)\n";
print "# Contoh : ". $_SERVER['PHP_SELF']."?hal=2\n\n";

print "# >> Get Link Video \n";
print "# > Parameter : vid=\n";
print "# GET ". $_SERVER['PHP_SELF']."?vid=(judul)\n";
print "# Contoh : ". $_SERVER['PHP_SELF']."?vid=skirt-no-naka-wa-kedamono-deshita-episode-1-subtitle-indonesia\n\n";
print "# RESULT : JSON\n\n";
print "# Created on 11/07/2017 by Versailles (Sec7or Team)\n\n";
}

