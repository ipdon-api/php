<?php
/**
 * Queries the IPDon api (https://ipdon.com) to retrieve IP intelligence.
 * Libary has a dependency on php-curl library (see https://www.php.net/manual/en/book.curl.php)
 * API supports token based authentication and returns all properties as part of the low-latency IP service.
 * 
 * Usage example:
 *        $apiKey = "<your API key here>"; //leave empty if you dont have an API key to use free plan
 *        
 *        $visitorIP = empty($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR'];
 *
 *        $IPdon = new IPdon($apiKey);
 *        $retval = $IPdon->query($visitorIP);
 *
 *        print_r($retval);
 * 
 */
class IPdon {
    private string $token; 
    private $handler = null;    

    /**
     * Constructs handler
     * @var token specifies the user's API token. It is past via Header to avoid unnencessary disclosure. If empty, free plan is used.
     */
    public function __construct(string $token="") {
        $this->token = $token;
        $this->handler = curl_init();
        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);     
        
        if($token !== "") {
            curl_setopt($this->handler, CURLOPT_HTTPHEADER, array("token: " . $token));
        }
    }    

    /**
     * Queries the IPDon IP intelligence API
     * @var ipAddress IP Address in string format
     * @var sectionOrField Filters a specific field or section (faster retrieval)
     * @return object returns a multi-dimensional object that exactly represents the structure of https://api.ipdon.com/    * 
     */
    public function query(string $ipAddress, string $filterSectionOrField=null) {
        $url = "https://api.ipdon.com/{$ipAddress}";

        if($filterSectionOrField !== null) {
            $url .= "/{$filterSectionOrField}";
        }

        curl_setopt($this->handler, CURLOPT_URL, $url);
        
        $response = curl_exec($this->handler);
        $obj = null;        

        if($response === false) {
            throw new Exception(curl_error($this->handler), curl_errno($this->handler));
        }

        $httpCode = curl_getinfo($this->handler, CURLINFO_HTTP_CODE);
        if($httpCode != 200) {
            throw new Exception($response, $httpCode);

        } else {
            try {
                $obj = json_decode($response);
                
            } catch(Exception $e) {
                throw $e;
            }
        }
        
        return $obj;
    }

    public function __destruct() {
        curl_close($this->handler);
    }
}
?>
