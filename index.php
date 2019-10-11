<?php

#https://github.com/tejado/ebk-client/blob/master/ebk_client.py

print_r(get_loaded_extensions());


$oauth_request = new OAuth("0vtifueudse5gnm7emk36wet", "iuvkflq31d");
$req_token = $oauth_request->getRequestToken("https://openapi.etsy.com/v2/oauth/request_token?scope=email_r%20listings_r", 'http://oxid6.coral-garden.de/callback_index.php', "GET");

setcookie("request_secret", $req_token['oauth_token_secret']);
echo '<a target="_parent" href="'.$req_token['login_url'].'">Link to Etsy</a>';