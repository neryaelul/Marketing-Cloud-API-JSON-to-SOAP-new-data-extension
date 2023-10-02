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
    $MarketingCloud->urlSOAP = "https://mchh-m48rfvtknbpmrl-4njrqyd4.soap.marketingcloudapis.com";
    
    $data = file_get_contents('php://input');

            

 
    $json_ex = '
    {
        "CustomerKey": "name",
        "Name": "name",
        "Description" : "name",
        "IsSendable" : "false",
        "IsTestable" : "false",
        "Fields": [
            {
                "CustomerKey": "Email",
                "Name": "Email",
                "Label" : "Email",
                "IsRequired": false,
                "IsPrimaryKey": false,
                "FieldType" : "EmailAddress"
            },{
                "CustomerKey": "NumberOfOrder",
                "Name": "OrderNumber",
                "Label" : "OrderNumber",
                "IsRequired": false,
                "IsPrimaryKey": false,
                "FieldType" : "Number",
                "MaxLength": 11
            },{
                "CustomerKey": "AID",
                "Name": "AID",
                "Label" : "AID",
                "IsRequired": false,
                "IsPrimaryKey": false,
                "FieldType" : "Text",
                "MaxLength": 51
            },{
                "CustomerKey": "CONTACTID",
                "Name": "CONTACTID",
                "Label" : "CONTACTID",
                "IsRequired": false,
                "IsPrimaryKey": false,
                "FieldType" : "Text",
                "MaxLength": 51
            },{
                "CustomerKey": "OrderShippingPhone",
                "Name": "OrderShippingPhone",
                "Label" : "OrderShippingPhone",
                "IsRequired": false,
                "IsPrimaryKey": false,
                "FieldType" : "Phone",
                "MaxLength": 254
            },{
                "CustomerKey": "OrderPhoneNumber",
                "Name": "OrderPhoneNumber",
                "Label" : "OrderPhoneNumber",
                "IsRequired": false,
                "IsPrimaryKey": false,
                "FieldType" : "Phone",
                "MaxLength": 254
            }
        ]
        
    }
    ';
    $new_de = $MarketingCloud->urlSOAP($json_ex);

     echo $new_de;
        
?>
