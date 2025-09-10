<?php
//print_r($_SERVER);

$currentworkingdomain = $_SERVER['SERVER_NAME']; //To get only server name.

$currentworkingdomain = 'http://'.$currentworkingdomain;

$geturls=get_domaininfo($currentworkingdomain);


echo $applocation1 = $geturls['protocol']."://www.".$geturls['domain'].'/'.$appfoldername; //Used inside excel export options on reports module.


function get_domaininfo($url) {
    // regex can be replaced with parse_url
    preg_match("/^(https|http|ftp):\/\/(.*?)\//", "$url/" , $matches);
    $parts = explode(".", $matches[2]);
    $tld = array_pop($parts);
    $host = array_pop($parts);
    if ( strlen($tld) == 2 && strlen($host) <= 3 ) {
        $tld = "$host.$tld";
        $host = array_pop($parts);
    }

    return array(
        'protocol' => $matches[1],
        'subdomain' => implode(".", $parts),
        'domain' => "$host.$tld",
        'host'=>$host,'tld'=>$tld
    );
}
?>