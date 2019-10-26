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
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3",
        "accept-language: en-US,en;q=0.9",
        "cache-control: max-age=0,no-cache",
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
