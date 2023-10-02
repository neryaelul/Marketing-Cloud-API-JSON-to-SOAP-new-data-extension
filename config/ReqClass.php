<?php
     class urlReq{
        public $methood = "GET";
        public $body = "";
        public $response = 0;
        public $key = 0;
        public $url = 0;
        public $header = array();
        public function curlQ($json){
            $curl = curl_init();
            $configRes = array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $this->methood,
                CURLOPT_POSTFIELDS => $this->body,
                CURLOPT_HTTPHEADER => $this->header
            );
            curl_setopt_array($curl,$configRes);
            $this->response = curl_exec($curl);
            curl_close($curl);
            if($json != 0){
                return json_decode($this->response, true);
            }else{
                return $this->response;
            }
        }		
    }
?>