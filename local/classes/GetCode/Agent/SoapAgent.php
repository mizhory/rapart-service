<?php
namespace GetCode\Agent;

use GetCode\API\SOAP\SoapConnector,
    GetCode\Helper\StepingHelper,
    GetCode\Entity\StatusesTable,
    GetCode\Entity\CustomerOfferTable,
    GetCode\Entity\CustomerOrderTable,
    GetCode\Entity\CustomerInvoiceTable,
    GetCode\Entity\CustomerRTIUTable,
    \Bitrix\Main\Loader;

class SoapAgent {
    private static $user_pool = [];
    private static $steping_data = [];

    private static function preStep() {
        $e = \CUser::GetList(
            ($by="id"),
            ($order="desc"),
            array('!XML_ID' => false));
        while($arUser = $e->fetch()){
            if(strlen($arUser['XML_ID'])>=30)
                static::$user_pool[$arUser['ID']] = $arUser;
        }
    }
    private static function checkAuthorizedUser($USER){
        $active_user_ID = $USER->GetID();
        foreach(static::$user_pool as $k=>$r){
            if($r['ID'] == $active_user_ID) {
                static::$user_pool[$k]['AUTH'] = true;
            }
        }
    }
    private static function inStep($method_step){
        $method_step = intval($method_step);
        $step_data = false;
        foreach(static::$user_pool as $k=>$r){
            $data = [
                'METHOD_STEP' => $method_step,
                'XML_ID' => $r['XML_ID']
            ];
            $step_data[$r['XML_ID']] = SoapConnector::initRequest($data);
        }
        return $step_data;
    }
    private static function coreStep() {
        $steping_data = false;

        //$steping_data[StepingHelper::STEP_GET_REQUEST_N_KP]     = static::inStep(StepingHelper::STEP_GET_REQUEST_N_KP);
        $steping_data[StepingHelper::STEP_GET_REQUEST]          = static::inStep(StepingHelper::STEP_GET_REQUEST);
        $steping_data[StepingHelper::STEP_GET_KP]               = static::inStep(StepingHelper::STEP_GET_KP);
        $steping_data[StepingHelper::STEP_GET_ORDER]            = static::inStep(StepingHelper::STEP_GET_ORDER);
        $steping_data[StepingHelper::STEP_GET_INVOICE]          = static::inStep(StepingHelper::STEP_GET_INVOICE);
        $steping_data[StepingHelper::STEP_GET_RTIU]             = static::inStep(StepingHelper::STEP_GET_RTIU);
        static::$steping_data = $steping_data;
    }
    private static function getUserIDbyXMLID($user_xml_id){
        $e = \CUser::GetList(
            ($by="id"),
            ($order="desc"),
            array('XML_ID' => $user_xml_id));
        if($a=$e->fetch())
            return $a['ID'];
    }
    private static function checkXMLID($method, $xml_id, $flag=false){
        if($method == StepingHelper::STEP_GET_REQUEST || $method == StepingHelper::STEP_GET_ORDER){
            $a = CustomerOrderTable::getList(
                [
                    'select' => [
                        'ID'
                    ],
                    'order' => [
                        'ID' => 'ASC'
                    ],
                    'filter' => [
                        'UF_XML_ID' => $xml_id
                    ]
                ]);
            if($e=$a->fetch())
                if(isset($e['ID']) && !$flag)
                    return true;
                elseif(isset($e['ID']) && $flag!=false)
                    return $e['ID'];
        } elseif ($method == StepingHelper::STEP_GET_KP){
            $a = CustomerOfferTable::getList(
                [
                    'select' => [
                        'ID'
                    ],
                    'order' => [
                        'ID' => 'ASC'
                    ],
                    'filter' => [
                        'UF_XML_ID' => $xml_id
                    ]
                ]);
            if($e=$a->fetch())
                if(isset($e['ID']) && !$flag)
                    return true;
                elseif(isset($e['ID']) && $flag!=false)
                    return $e['ID'];
        } elseif ($method == StepingHelper::STEP_GET_INVOICE){
            $a = CustomerInvoiceTable::getList(
                [
                    'select' => [
                        'ID'
                    ],
                    'order' => [
                        'ID' => 'ASC'
                    ],
                    'filter' => [
                        'UF_XML_ID' => $xml_id
                    ]
                ]);
            if($e=$a->fetch())
                if(isset($e['ID']) && !$flag)
                    return true;
                elseif(isset($e['ID']) && $flag!=false)
                    return $e['ID'];
        }
    }
    private static function getStatusIDbyName($status_name, $method) {

        $a = StatusesTable::getList(
            [
                'select' => ['ID'],
                'order' => ['ID' => 'ASC'],
                'filter' => ['UF_NAME' => $status_name]
            ]
        );
        if($e=$a->fetch()){
            return $e['ID'];
        }
    }
    private static function getOffers($array) {
        if(!Loader::includeModule('iblock')) return false;

        foreach($array as $k=>$r){
            $res = \CIBlockElement::GetList(
                Array("SORT"=>"ASC"),
                [
                    ['LOGIC' => 'OR',
                        ["NAME"                     => $r["Nomenklature"]],
                        ["NAME"                     => $r["DesignationNomenklature"]],
                        ["PROPERTY_CML2_ARTICLE"    => $r["Nomenklature"]],
                        ["PROPERTY_CML2_ARTICLE"    => $r["DesignationNomenklature"]]
                    ]
                ],
                Array("ID")
            );
            $e = false;
            if($z = $res->fetch()) {
                $e['ID'] = $z['ID'];
                $e['IDNomenklature'] = $r['IDNomenklature'];

                if(isset($r['DateShipment']))
                    $e['DateShipment'] = $r['DateShipment'];

                $e['PN'] = $r['PartyNumber'];
                $e['COUNT'] = $r['KolVo'];
                $e['PRICE'] = $r['Cena'];
                $e['STAVKA_NDS'] = $r['StavkaNDS'];
                $e['SUMM']  = $r['Summ'];
                $e['SUMM_NDS'] = $r['SummNDS'];
                $e['SUMM_S_NDS'] = $r['SummSNDS'];
                $e['STATUS'] = $r['Status'];
            }
            if(!is_bool($e))
                $ret[] = $e;
        }
        //var dump($ret, $array);
        return serialize($ret);
    }
    private static function updElement($method, $data, $id){
        if($method == StepingHelper::STEP_GET_REQUEST || $method == StepingHelper::STEP_GET_ORDER) {
            CustomerOrderTable::update($id, $data);
        } elseif ($method == StepingHelper::STEP_GET_KP) {
            CustomerOfferTable::update($id, $data);
        } elseif ($method == StepingHelper::STEP_GET_INVOICE) {
            CustomerInvoiceTable::update($id, $data);
        }
    }
    private static function newElement($method, $data){
        if($method == StepingHelper::STEP_GET_REQUEST || $method == StepingHelper::STEP_GET_ORDER) {
            CustomerOrderTable::add($data);
        } elseif($method == StepingHelper::STEP_GET_KP) {
            CustomerOfferTable::add($data);
        } elseif($method == StepingHelper::STEP_GET_INVOICE) {
            CustomerInvoiceTable::add($data);
        }
    }
    private static function getKPIDbyName($name){
        $arFilter = [
            '=UF_CO_ID' => $name
        ];
        $e = CustomerOfferTable::getList(['select' => ['ID'], 'filter' => $arFilter, 'order' => ['ID' => 'ASC']]);
        if($a=$e->fetch())
            return $a['ID'];
    }
    private static function syncStep() {
        global $USER, $APPLICATION;
        \Bitrix\Main\Diag\Debug::writeToFile(static::$steping_data);
        foreach(static::$steping_data as $method_step=>$data_step){
            if($method_step == StepingHelper::STEP_GET_REQUEST) {
                foreach($data_step as $user_xml_id=>$_user_data){
                    foreach($_user_data as $k=>$user_data){
                        $_data = Array(
                            "UF_XML_ID"     => $user_data["GUIDZayavka"],
                            "UF_USER_ID"    => static::getUserIDbyXMLID($user_xml_id),
                            "UF_NAME"       => $user_data["IDZayavka"],
                            "UF_PRIORITY"   => $user_data["Priority"],
                            "UF_STATUS"     => static::getStatusIDbyName($user_data["StatusZayavka"]
                                , StepingHelper::STEP_GET_REQUEST),
                            "UF_OFFER"      => '1',
                            "UF_OFFERS"     => static::getOffers($user_data["Tovary"]),
                            "UF_DATE"       => $user_data['Date'],
                            "UF_PERC_PAYMENT"   => $user_data['PercPayment'],
                            "UF_PERC_SHIPMENT"   => $user_data['PercShipment'],
                            "UF_NUMBER_CUSTOMER"    => $user_data['NumberCustomer'],
                            "UF_SUMM"               => $user_data['Summ'],
                        );
                        if(static::checkXMLID(StepingHelper::STEP_GET_REQUEST, $user_data["GUIDZayavka"])){
                            $zid = static::checkXMLID(StepingHelper::STEP_GET_REQUEST, $user_data["GUIDZayavka"], 1);
                            static::updElement(StepingHelper::STEP_GET_REQUEST, $_data, $zid);
                        } else {
                            static::newElement(StepingHelper::STEP_GET_REQUEST, $_data);
                        }
                    }
                }
            } elseif($method_step == StepingHelper::STEP_GET_KP) {
                foreach($data_step as $user_xml_id=>$_user_data){
                    foreach($_user_data as $k=>$user_data) {
                        foreach($user_data["Tovary"] as $r=>$arItems) {
                            $z_id = static::checkXMLID(StepingHelper::STEP_GET_REQUEST, $user_data["GUIDZayavka"], 1);
                            $_data = array(
                                "UF_CO_ID"      => $user_data["IDKP"],
                                "UF_XML_ID"     => $user_data["GUIDKP"],
                                "UF_STATUS"     => static::getStatusIDbyName($user_data["StatusKP"], StepingHelper::STEP_GET_KP),
                                "UF_ORDER_ID"   => $z_id,
                                "UF_ITEM_ID"    => static::getOfferbyName($arItems["Nomenklature"]),
                                "UF_USER_ID"    => static::getUserIDbyXMLID($user_xml_id),
                                "UF_CO_SUMM"    => $user_data['SummKP'],
                                "UF_CO_DATE"    => $user_data['DataKP'],
                                "UF_VALIDATY"   => $user_data['Validity'],
                                "UF_COUNT"      => $arItems['KolVo'],
                                "UF_SUMM"       => $arItems['Summ'],
                                "UF_STAVKA_NDS"       => $arItems['StavkaNDS'],
                                "UF_SUMM_NDS"       => $arItems['SummNDS'],
                                "UF_SUMM_SNDS"       => $arItems['SummSNDS'],
                                "UF_E_STATUS"       => static::getStatusIDbyName($arItems["Status"], StepingHelper::STEP_GET_KP),
                                "UF_PRICE"          => $arItems['Cena'],
                                "UF_DELIVERY_TIME"  => $arItems['DeliveryTime'],
                                "UF_NUMBER_CUSTOMER" => $user_data['NumberCustomer']
                                //"UF_CO_FILE_REMOTE" =>
                            );
                            if(static::checkXMLID(StepingHelper::STEP_GET_KP, $user_data["GUIDKP"])){
                                $zid = static::checkXMLID(StepingHelper::STEP_GET_KP, $user_data["GUIDKP"], 1);
                                static::updElement(StepingHelper::STEP_GET_KP, $_data, $zid);
                            } else {
                                static::newElement(StepingHelper::STEP_GET_KP, $_data);
                            }
                        }
                    }
                }
            } elseif($method_step == StepingHelper::STEP_GET_ORDER) {
                foreach($data_step as $user_xml_id=>$_user_data){
                    foreach($_user_data as $k=>$user_data){
                        $_data = Array(
                            "UF_XML_ID"     => $user_data["GUIDZakaz"],
                            "UF_USER_ID"    => static::getUserIDbyXMLID($user_xml_id),
                            "UF_NAME"       => $user_data["ID"],
                            "UF_PRIORITY"   => $user_data["Priority"],
                            "UF_STATUS"     => static::getStatusIDbyName($user_data["Status"], StepingHelper::STEP_GET_ORDER),
                            "UF_OFFER"      => '0',
                            "UF_OFFERS"     => static::getOffers($user_data["Tovary"]),
                            "UF_DATE"       => $user_data['Data'],
                            "UF_PERC_PAYMENT"   => $user_data['PercPayment'],
                            "UF_PERC_SHIPMENT"   => $user_data['PercShipment'],
                            "UF_SUMM"               => $user_data['Summ'],
                            "UF_NUMBER_CUSTOMER"    => $user_data['NumberKontr']
                        );
                        if(static::checkXMLID(StepingHelper::STEP_GET_REQUEST, $user_data["GUIDZakaz"])){
                            $zid = static::checkXMLID(StepingHelper::STEP_GET_REQUEST, $user_data["GUIDZakaz"], 1);
                            static::updElement(StepingHelper::STEP_GET_REQUEST, $_data, $zid);
                        } else {
                            static::newElement(StepingHelper::STEP_GET_REQUEST, $_data);
                        }
                    }
                }
            } elseif($method_step == StepingHelper::STEP_GET_INVOICE) {
                foreach($data_step as $user_xml_id=>$_user_data) {
                    foreach($_user_data as $d=>$user_data){
                        $files = [];
                        if(count($user_data["Files"])>=1){
                            foreach($user_data["Files"] as $y=>$arFile){
                                $_fififi = explode('://', $arFile["File"]);
                                $auth = base64_decode('dTA4MzEwMDJfaXBfbGltbzpgZV1TeT03YUA=');
                                $file = $_fififi[0].'://'.$auth.$_fififi[1];
                                $arFiles = \CFile::MakeFileArray($file);
                                $fid = \CFile::SaveFile($arFiles, "ftp_invoice");
                                $files[] = intval($fid);
                            }
                        }
                        $_data = array(
                            "UF_FILES"          => serialize($files),
                            "UF_KP_ID"          => static::getKPIDbyName($user_data["ID"]),
                            "UF_CURRENCY"       => $user_data["Currency"],
                            "UF_SUMM"           => $user_data["Summ"],
                            "UF_NULLED_INVOICE" => ($user_data["Annulirovan"]=='истина')?1:0,
                            "UF_FILE_INVOICE_REMOTE_SERVER" => $user_data["File"],
                            "UF_FORMAT_INVOICE" => $user_data["FormaOplati"],
                            "UF_REQUEST"        => $user_data["Request"],
                            "UF_STATUS"         => static::getStatusIDbyName($user_data["State"], StepingHelper::STEP_GET_INVOICE),
                            "UF_DATE"           => $user_data["Data"],
                            "UF_XML_ID"         => $user_data["GUIDschet"],
                            "UF_NAME"           => $user_data["ID"],
                            "UF_USER_ID"        => static::getUserIDbyXMLID($user_xml_id)
                        );
                        if(static::checkXMLID(StepingHelper::STEP_GET_INVOICE, $_user_data["GUIDschet"])){
                            $zid = static::checkXMLID(StepingHelper::STEP_GET_INVOICE, $_user_data["GUIDschet"], 1);
                            static::updElement(StepingHelper::STEP_GET_INVOICE, $_data, $zid);
                        } else {
                            static::newElement(StepingHelper::STEP_GET_INVOICE, $_data);
                        }
                    }
                }
            } elseif($method_step == StepingHelper::STEP_GET_RTIU) {
                //var_dump($data_step);
            }
        }
    }

    private static function getOfferbyName($name){
        $arFilter = ['=NAME' => $name];
        $arOrder = ['ID' => 'ASC'];
        $arSelect = ['ID'];

        \Bitrix\Main\Loader::includeModule('iblock');

        $res = \CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
        if($e=$res->fetch())
            if($e['ID'])
                return $e['ID'];
    }

    public static function sync() {
        global $APPLICATION, $USER;
        // ----------------------------
        SoapConnector::initConnect();
        // ----------------------------
        static::preStep();
        // ----------------------------
        static::checkAuthorizedUser($USER);
        // ----------------------------
        static::coreStep();
        // ----------------------------
        static::syncStep();
        return "GetCode\Agent\SoapAgent::sync();";
    }
}
