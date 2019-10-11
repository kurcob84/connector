<?php

class fromEtsy {
    
    private $base = 'https://openapi.etsy.com/v2/';
    private $oauth = null;
    private $api_key = "0vtifueudse5gnm7emk36wet";
    private $api_secret = "iuvkflq31d";

    function __construct() {
        try {

            $request_token          = $_GET['oauth_token'];
            $request_token_secret   = $_COOKIE['request_secret'];
            $verifier               = $_GET['oauth_verifier'];
            
            $oauth = new OAuth($this->api_key, $this->api_secret);
            $oauth->setToken($request_token, $request_token_secret);
            $acc_token = $oauth->getAccessToken($this->base . "oauth/access_token", null, $verifier, "GET");
            $this->oauth = new OAuth($this->api_key, $this->api_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
            $this->oauth->setToken($acc_token['oauth_token'], $acc_token['oauth_token_secret']);
        
        } catch (OAuthException $e) {
            var_dump($e->getMessage());
        }
    }
   
    function getShopID($shopname) {
        # https://www.etsy.com/developers/documentation/reference/shop -> shops
        $this->oauth->fetch($this->base . "shops?shop_name=$shopname", null, OAUTH_HTTP_METHOD_GET);
        $json = $this->oauth->getLastResponse();
        $shop = json_decode($json, true);
        $shop_id = $shop['results'][0]['shop_id'];

        return $shop_id;
    }

    function findAllShopSections($shop_id) {
        # https://www.etsy.com/developers/documentation/reference/shopsection -> findAllShopSections
        $this->oauth->fetch($this->base . "shops/$shop_id./sections", null, OAUTH_HTTP_METHOD_GET);
        $json = $this->oauth->getLastResponse();
        $sections = json_decode($json, true);
        $shop_section_ids = $sections['results'];

        return $shop_section_ids;
    }

    function findAllShopSectionListingsActive($shop_id, $shop_section_id) {
        # https://www.etsy.com/developers/documentation/reference/listing -> findAllShopSectionListingsActive
        $this->oauth->fetch($this->base . "shops/$shop_id/sections/$shop_section_id/listings/active?includes=Images(url_fullxfull)&language=de&limit=75", null, OAUTH_HTTP_METHOD_GET);
        $json = $this->oauth->getLastResponse();
        $articles = json_decode($json, true);

        return $articles;
    }


    function bilderrrr($listing_id) {
        $this->oauth->fetch($this->base . "listings/" . $listing_id . "/images", null, OAUTH_HTTP_METHOD_GET);
        $json = $this->oauth->getLastResponse();
        $result = json_decode($json, true);

        return $result;
    }
}