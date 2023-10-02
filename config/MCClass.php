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
        public $urlSOAP = "";

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
        public function dataExtensionsCreate($JSONBody){

            $input = json_decode($JSONBody, true); 
    
            $MainCustomerKey = $input['CustomerKey'];
            $MainName = $input['Name'];
            $MainDescription= $input['Description'];
            $MainIsSendable = $input['IsSendable'];
            $MainIsTestable = $input['IsTestable'];
            $LineFields = '';
            foreach($input['Fields'] as $key => $val){
                if($input['Fields'][$key]['IsRequired']) {
                    $IsRequired = "true";
                }else{
                    $IsRequired = "false";
                }
        
                if($input['Fields'][$key]['IsPrimaryKey']) {
                    $IsPrimaryKey = "true";
                }else{
                    $IsPrimaryKey = "false";
                }
                $LineFields .=
                    '<Field xsi:type="ns2:DataExtensionField">
                        <CustomerKey>' .$input['Fields'][$key]['CustomerKey']. '</CustomerKey>
                        <Name>' .$input['Fields'][$key]['Name']. '</Name>
                        <Label>' .$input['Fields'][$key]['Label']. '</Label>
                        
                        <IsRequired>' .$IsRequired. '</IsRequired>
                        <IsPrimaryKey>' .$IsPrimaryKey. '</IsPrimaryKey>
                        <FieldType>' .$input['Fields'][$key]['FieldType']. '</FieldType>
                    </Field>';
            }
            
            $accessTokenMC = $this->getToken();
            $XML = 
            '<?xml version="1.0" encoding="UTF-8"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                    <soapenv:Header>
                        <fueloauth>' .$accessTokenMC. '</fueloauth>
                    </soapenv:Header>
                    <soapenv:Body>
                        <CreateRequest xmlns="http://exacttarget.com/wsdl/partnerAPI">
                            <Options/>
                            <Objects xsi:type="ns2:DataExtension" xmlns:ns2="http://exacttarget.com/wsdl/partnerAPI">
                                <CustomerKey>' .$MainCustomerKey. '</CustomerKey>
                                <Name>' .$MainName. '</Name>
                                <Description>' .$MainDescription. '</Description>
                                <IsSendable>' .$MainIsSendable. '</IsSendable>
                                <IsTestable>' .$MainIsTestable. '</IsTestable>
                                <Fields>
                                   ' .$LineFields. '
                                </Fields>
                            </Objects>
                        </CreateRequest>
                    </soapenv:Body>
                    </soapenv:Envelope>';


            $this->methood = 'POST';
            $this->url = $this->urlSOAP . '/Service.asmx';
            
            $this->header = array(
                'Content-Type: text/xml',
                'SoapAction: Create'
            );

            $this->body = $this->bodyReqSF;
            $xmlStr = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $this->curlQ(0));
            $xml = new SimpleXMLElement($xmlStr);
            $j = json_encode($xml);
            return $j; 
        }
        public function APIEventDataExtensions(){
            #neryaelul_
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
    

