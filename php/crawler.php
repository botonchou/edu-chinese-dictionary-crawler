<?php

$OUTPUT_DATA_DIR="../data/html/";
$CHT_CHAR_SET="../material/all.char.ascii.2";

$start=$_GET["start"];
$end=$_GET["end"];

echo "$start => $end <br/>";

require 'simple_html_dom.php';
error_reporting(E_ALL);

$curl=curl_init();

header("Content-Type: text/html");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

function getUrl($curl, $url) {
  $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml, text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5"; 
  $header[] = "Cache-Control: max-age=0"; 
  $header[] = "Connection: keep-alive"; 
  $header[] = "Keep-Alive: 300"; 
  $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"; 
  $header[] = "Accept-Language: en-us,en;q=0.5"; 

  curl_setopt($curl, CURLOPT_URL, $url); 
  curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/534.3 (KHTML, like Gecko) Ubuntu/10.04 Chromium/6.0.472.53 Chrome/6.0.472.53 Safari/534.3'); 
  curl_setopt($curl, CURLOPT_HTTPHEADER, $header); 
  curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate'); 
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // very important to set it to true, otherwise the content will be not be saved to string

  $html = curl_exec($curl); // execute the curl command

  if (curl_errno($curl)) {
    echo "[Error] ".curl_error($curl);
    exit;
  }

  return $html;
}

function crawl($curl, $url, $filename) {
  $html = getUrl($curl, $url); // the function from Step 3
  // $html = str_get_html($html);

  // $table = $html->find('table', 2);
  // $table = "";

  $fid = fopen($filename, 'w');
  fwrite($fid, $html);
  fclose($fid);
}

$DICT_URL="http://dict.revised.moe.edu.tw/cgi-bin/newDict/dict.sh?idx=dict.idx&pieceLen=999&fld=1&recNo=0&cat=&imgFont=1&cond=";

$q_fid = fopen($CHT_CHAR_SET, "r");
$counter=-1;
if ($q_fid) {
  while (($line = fgets($q_fid)) !== false) {
    $counter++;
    if ($counter < $start) continue;
    if ($counter >= $end) break;

    $url=$DICT_URL.$line;

    $filename = $OUTPUT_DATA_DIR.$counter.".txt";
    echo "$counter => $url => $filename <br/>";
    crawl($curl, $url, $filename);
  }
} else {
  echo "Error opening file";
  // error opening the file.
} 
fclose($q_fid);

?>
