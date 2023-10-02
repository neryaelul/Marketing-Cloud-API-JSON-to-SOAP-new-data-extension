<?php
    
    class MarketingCloud extends urlReq {

        public $tokenOauthUrl = 0;
        public $username = 0;
        public $password = 0;
        public $client_id = 0;
        public $client_secret = 0;
        public $grant_type = 0;
        public $uri_redirect = "";
        public $accessTokenMC = 0;
        public $bodyReqSF = 0;
        public $urlRestAPI = 0;

        public function getToken(){
            $this->methood = 'POST';
            $this->url = $this->tokenOauthUrl;
            $this->body = 'client_id=' .$this->client_id. '&client_secret=' .$this->client_secret. '&account_id=' .$this->account_id. '&grant_type=' .$this->grant_type;
            $this->header =  array(
                'Content-Type: application/x-www-form-urlencoded'
            );
            $jtoarr = $this->curlQ(1);
            return $jtoarr['access_token'];
        }
        public function dataExtensions($key){
            $this->methood = 'POST';
            $this->url = $this->urlRestAPI . '/data/v1/async/dataextensions/key:' .$key. '/rows';
            $this->header = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' .$this->accessTokenMC
            );
            $this->body = $this->bodyReqSF;
            return $this->curlQ(1); 
            
        }
        public function APIEventDataExtensions(){
            $this->methood = 'POST';
            $this->url = $this->urlRestAPI . '/interaction/v1/events';
            $this->header = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' .$this->accessTokenMC
            );
            $this->body = $this->bodyReqSF;
            return $this->curlQ(1); 
            
        }
    }

    



  ?>
    

