<?php

include 'fromEtsy.php';


$fromEtsy = new fromEtsy();
$shop_id = $fromEtsy->getShopID("GEPAECKSTUECK");
$shop_section_ids = $fromEtsy->findAllShopSections($shop_id);
$shop_section_id = $shop_section_ids[0]['shop_section_id'];
$articles = $fromEtsy->findAllShopSectionListingsActive($shop_id, $shop_section_id);

$dataContainer = array();
$i = 0;
foreach($articles['results'] as $article) {

    $dataContainer[$i]['title'] = $article['title'];
    $dataContainer[$i]['description'] = $article['description'];
    $dataContainer[$i]['price'] = $article['price'];
    $j = 0;
    foreach($article['Images'] as $image) {
        $dataContainer[$i]['image'][$j] = $image['url_fullxfull'];
        $j = $j + 1;
    }
    $dataContainer[$i]['shipping'] = $article['ShippingInfo']['primary_cost'];


    $i = $i + 1;
}

echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>';
var_dump($dataContainer);
echo '</body></html>';