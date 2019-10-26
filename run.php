<?php
date_default_timezone_set("Asia/Bangkok");

include("config.php");

function cek($url){
    sleep(1);
    $cek = file_get_contents($URL_API."?url=$url");
    if(preg_match("/yes/", $cek)){
        $text = "Silahkan Dibuy Lurrr!!! || ".$url;
        $res = file_get_contents("https://api.telegram.org/bot$BOT_TOKEN/sendMessage?chat_id=$CHAT_ID&text=$text");
        return "$url || Available || ";
    }else{
        return "$url || No ";
    }
}

while(true){
    $list = explode("\n", "https://sepatucompass.com/collections/all/products/gazelle-hi-cappuccino
https://sepatucompass.com/collections/all/products/gazelle-hi-red
https://sepatucompass.com/collections/all/products/gazelle-hi-white
https://sepatucompass.com/collections/all/products/gazelle-hi-blue-sky
https://sepatucompass.com/collections/all/products/gazelle-low-black-black
https://sepatucompass.com/collections/all/products/gazelle-low-blue-sky
https://sepatucompass.com/collections/all/products/gazelle-low-cappuccino
https://sepatucompass.com/collections/all/products/gazelle-low-grey
https://sepatucompass.com/collections/all/products/gazelle-low-white
https://sepatucompass.com/collections/all/products/gazelle-low-pink
https://sepatucompass.com/collections/all/products/gazelle-low-red
https://sepatucompass.com/collections/all/products/gazelle-low-red-indonesia-bersatu
https://sepatucompass.com/collections/all/products/gazelle-low-navy
https://sepatucompass.com/collections/all/products/gazelle-low-white-indonesia-bersatu
https://sepatucompass.com/collections/all/products/rd-low
https://sepatucompass.com/collections/all/products/rd-hi");
for($i=0; $i<count($list); $i++){
    $cek = cek($list[$i]);
    echo $cek."|| ".date('d-m-Y H:i:s')."\n";
}
}
