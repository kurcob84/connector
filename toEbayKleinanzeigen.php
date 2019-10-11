<?php

class toEbayKleinanzeigen {

    private $base = 'https://api.ebay-kleinanzeigen.de/api';

    private $example = '
        <ad:ad ...>
            <cat:category id="258"/>
            <ad:title>Erster Test</ad:title>
            <ad:description>Description of ad</ad:description>
            <ad:ad-type>
                <ad:value>OFFERED</ad:value>
            </ad:ad-type>
            <ad:ad-address>
                <types:zip-code>01097</types:zip-code>
                <types:city>Dresden</types:city>
                <types:street>Dammweg 15</types:street>
                <types:full-address>2145 Hamilton Ave, San Jose, CA 95125, US</types:full-address>
                <types:state>CA</types:state>
                <types:country>US</types:country>
                <types:longitude>-122.084145</types:longitude>
                <types:latitude>37.42197</types:latitude>
        </ad:ad-address>
        </ad:ad>';

    function __construct() {
        $url = "http://59.162.33.102:9301/Avalability";

        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->base);
// Following line is compulsary to add as it is:
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "xmlRequest=" . $this->example);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $data = curl_exec($ch);
        curl_close($ch);

        //convert the XML result into array
        $array_data = json_decode(json_encode(simplexml_load_string($data)), true);

        print_r('<pre>');
        print_r($array_data);
        print_r('</pre>');
    }
}