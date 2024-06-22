<?php
function hashFunction($e, $g = 0) {
    if (!$e || strlen($e) == 0) {
        return $g;
    }
    $len = strlen($e);
    for ($h = 0; $h < $len; $h++) {
        $k = ord($e[$h]);
        $g = ($g << 5) - $g + $k;
        // Simulate 32-bit overflow
        $g = $g & 0xFFFFFFFF;
    }
    return $g;
}

if(isset($_COOKIE["_biz_nA"]) && isset($_COOKIE["_biz_uid"])){
$docname="Document title"; //set a title
$urlforpayload="https://www.putyoururlhere.com"; //put url here
$screenDimensions = "1680x1050"; //fake it
$screenHash = hashFunction($screenDimensions);
$sequence = $_COOKIE["_biz_nA"]+1;
setcookie("_biz_nA", $sequence, time()+ 365 * 24 * 60 * 60); //set sequence cookie one number ahead
$uid = $_COOKIE["_biz_uid"];
$rnd = mt_rand(0, 999999);
$microtime = intval(microtime(true) * 1000);
$payload = array(
    '_biz_r' => $_SERVER['HTTP_REFERER'], // Assuming you want to capture the HTTP referer
    '_biz_h' => $screenHash,
    '_biz_u' => $uid,
    '_biz_l' => $urlforpayload,
    '_biz_t' => $microtime,
    '_biz_i' => $docname,
    '_biz_n' => $sequence,
    'rnd' => $rnd,
    'cdn_o' => 'a',
    '_biz_z' => $microtime+1
);
$bizurl = "https://cdn.bizible.com/ipv";
$bizurl .= '?' . http_build_query($payload);
$response = file_get_contents($bizurl);
}

?>
