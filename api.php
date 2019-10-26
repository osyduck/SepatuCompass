<?php
header('Content-Type: application/json');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $_REQUEST['url'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_HTTPHEADER => array(
        "Accept-Encoding: gzip, deflate",
        "Connection: keep-alive",
        "Host: sepatucompass.com",
        "Postman-Token: 85282380-dd13-47c9-93b4-5d2db8a02031,376a0805-066b-4c3d-a47d-46d484fe0875",
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3",
        "accept-language: en-US,en;q=0.9",
        "cache-control: max-age=0,no-cache",
        //"cookie: _deviceId=5fcd71c1-8926-4d83-93a9-f7c4673eab4e; __jdv=63461492|www.facebook.com|-|referral|-|1570600135625; areaId=33; cityId=4; stateId=2; addressId=; __jd_ab=1; TrackID=1Y_UXvkA9TiUsi-kgWjWC6FsbQrV634CTEJ3ok1BLubfgHV8jICNol8H3DsNG48bcIkEIe43g94Fcon6BpdhRBrfcb1RdfVSn745oqZIxi64; pinId=f2uVQHCWgK8; pin=osyduck; unick=osyduck; _tp=""; _pst=osyduck; viewed=110336796%2C110336499%2C510340084%2C110337234%2C510337733%2C110337101%2C110336659; 3AB9D23F7A4B3C9B=ZSTYSUVPNMJKOYJQ5PLCXFGWP3TW37FKR6DSSMJU5HPN5VYPKX6VXHT2AMAAJBHC4HHAHXVHYI4GD634IZTP7Z7NWM; lighting-id=C5A7D499AF71E00CC2EC37A8A7AFABBD50684D05DB7F241AF89F3CC44F78AB821085A337CB083F37161B0B61BFCF915ECCA34100A82241FD22AF4E24E98548D3A22B0DC12880CE7E5E83141309279B6F8454366E584AE1DBE0389E09925571613A1CD5B3ED9B84E3DF9AE6308D128AD6FAF893FC37EC64E60E9656673EB323DD1B0B4EF3B8648E14A616C29DB83C24028CA8CECB052A92E287F9C4B4B8F92FBEEBCA14FCFFF513C79C3FFC90672DF2E7; __jda=63461492.15706001356252011290247.1570600136.1570600136.1570613913.2; __jdc=63461492; _tk=U1dmnu5bbu16bb1aqq1r5h1js6d6p0; _u_m_id=10693223; _u_m_p=osyduck; __jdb=63461492.5.15706001356252011290247|2.1570613913; mba_muid=15706001356252011290247; mba_sid=15706139321695717436562641083.1; _s_b_f=osyduck9",
        "if-modified-since: Wed, 09 Oct 2019 09:30:00 GMT",
        "sec-fetch-mode: navigate",
        "sec-fetch-site: none",
        "sec-fetch-user: ?1",
        "upgrade-insecure-requests: 1",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36"
    ) ,
));

$response = curl_exec($curl);
$err = curl_error($curl);
preg_match_all('~("ProductSelect-(.*?)-option-0">)~', $response, $id);
$id = $id[2][0];
$ex = explode('<select name="id" id="ProductSelect-' . $id . '" class="product-single__variants no-js">', $response);
$ex = explode('</select>', $ex[1]);

$ex1 = explode('<option disabled="disabled">', $ex[0]);

for ($i = 1;$i < count($ex1);$i++)
{
    $exi = explode("</option>", $ex1[$i]);

    //$stat[] = $stat;
    //$hasil['available'] = $stat;
    $details[] = trim($exi[0]);
}
for ($i = 0;$i < count($details);$i++)
{

    $status = preg_match("/Sold Out/", $details[$i]);
    if ($status == true)
    {
        $stat = "no";
    }
    else
    {
        $stat = "yes";
    }
    $available[] = $stat;
}

for ($i = 0;$i < count($details);$i++)
{
    $res[] = ['available' => $available[$i], 'details' => $details[$i], ];
}

$result['link'] = @$_REQUEST['url'];
$result['id'] = $id;
$result['stock'] = $res;

echo json_encode($result, JSON_PRETTY_PRINT);


?>
