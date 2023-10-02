<?php 
    //
    require_once '/config/MasterSC.php';
    require_once '/config/MCClass.php';

    $MarketingCloud = new MarketingCloud();

    $MarketingCloud->tokenOauthUrl = 'https://****.auth.marketingcloudapis.com/v2/token'; 
    $MarketingCloud->client_id = '*******';
    $MarketingCloud->client_secret = '*******';
    $MarketingCloud->grant_type = 'client_credentials';

    $MarketingCloud->urlRestAPI = "https://*****.rest.marketingcloudapis.com";
    
 
    
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
    
    $MarketingCloud->account_id = $stores[$storeName]['MC']['acountId'];
    $accessTokenMC = $MarketingCloud->getToken();
    

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
            

 

        $urlReq = new urlReq();
        $urlReq->url = "https://mchh-m48rfvtknbpmrl-4njrqyd4.soap.marketingcloudapis.com/Service.asmx";
        $urlReq->header =  array(
            'Content-Type: text/xml',
            'SoapAction: Create'

        );
        
        $urlReq->methood = "POST";
        $urlReq->body = $XML;
        $res = $urlReq->curlQ(0);

        $xmlStr = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $res);
        $xml = new SimpleXMLElement($xmlStr);
        $j = json_encode($xml);
        echo $j;
       // echo $res;
        
?>