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
        if($method == StepingHelper::STEP_GET_REQUEST){
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
        }
    }
    private static function getStatusIDbyName($status_name, $method) {
        if($method == StepingHelper::STEP_GET_REQUEST){
            $method_status = "(заявка)";
        }
        $a = StatusesTable::getList(
            [
                'select' => ['ID'],
                'order' => ['ID' => 'ASC'],
                'filter' => ['=UF_NAME' => $status_name. ' ' . $method_status]
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
                    "=NAME" => $r["Nomenklature"]
                ],
                Array("ID")
            );
            $r = $res->fetch();
            $ret[] = $r['ID'];
        }
        return serialize($ret);
    }
    private static function updElement($method, $data, $id){
        if($method == StepingHelper::STEP_GET_REQUEST) {
            CustomerOrderTable::update($id, $data);
        }
    }
    private static function newElement($method, $data){
        if($method == StepingHelper::STEP_GET_REQUEST) {
            CustomerOrderTable::add($data);
        }
    }
    private static function syncStep() {
        foreach(static::$steping_data as $method_step=>$data_step){
            if($method_step == StepingHelper::STEP_GET_REQUEST) {
                foreach($data_step as $user_xml_id=>$_user_data){
                    foreach($_user_data as $k=>$user_data){
                        $_data = Array(
                            "UF_XML_ID" => $user_data["GUIDZayavka"],
                            "UF_USER_ID" => static::getUserIDbyXMLID($user_xml_id),
                            "UF_NAME" => $user_data["IDZayavka"],
                            "UF_PRIORITY" => $user_data["Priority"],
                            "UF_STATUS" => static::getStatusIDbyName($user_data["StatusZayavka"]
                                , StepingHelper::STEP_GET_REQUEST),
                            "UF_OFFER" => '1',
                            "UF_OFFERS" => static::getOffers($user_data["Tovary"]),
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
                    /*
                     * {
" IDKP": "КА-000145"-- Номер документа 1с,
" GUIDKP": "88a94845-6632-11eb-8111-005056b68048" –ГУИД ЗаказКлиента,
"GUIDDelivery": "88232a38-67a2-11eb-8115-005056b68048" –ГУИД Реализации ,
" AvailableDocumentsKol": "10"—Количество документов в запросе,
" DataKP": "05.02.2021"—Дата документа,
" StatusKP": "выставлен"—Статус документа тип строка,
"Currency": "руб."—Валюта документа тип строка,
" SummKP": "123 289,58 руб." сумма документа тип строка,
" BooleanActiv": "истина." Признак может выкупаться частично тип строка,
" Validity": "05.02.2021." дата действия тип строка,
" SdelkaKP": "сделка 35 от 11.11.2021." сделка коммерческого предложения тип строка,
" IDZayavka ": "кА-000544" номер документа заявки клиента тип строка
" NumberCustomer": "кА-00054а4" номер закявки по данным клиента тип строка
" File": "/оль/рроп" папка файлов на сервере тип строка
"Tovary": [
{
"IDNomenklature": "1"—тип строка Номер строки,
"Nomenklature": "4-21-6107" –Наименование Номенклатуры тип строка,
"NomenklatureArticule": "4-21-6107" –Артикул Номенклатуры тип строка,
"PartyNumber": "КА-00018899" –Код Номенклатуры 1с тип строка,
"KolVo": "1шт" –Количество тип строка с упаковкой
"DateRO": "12,12,2021" –дата рапарт тип строка с упаковкой
"DeliveryTime": "12,12,2021" –дата доставки тип строка
"Request": "104 от 21.11.2021" –дата заявки клиента
,
"Unit": "шт" –Упаковка тип строка,
"Cena": "123 289,58 руб." –Цена тип строка,
"StavkaNDS": "0%" –Ставка ндс тип строка,

"SummNDS": "0 руб." –Сумма НДС тип строка,
"SummSNDS": "123 289,58 руб. –сумма с НДС тип строка",
"Summ": "123 289,58 руб."—сумма тип строка
}
]
                     */
                    foreach($_user_data as $k=>$user_data) {
                        foreach($user_data["Tovary"] as $r=>$arItems) {
                            $z_id = static::checkXMLID(StepingHelper::STEP_GET_REQUEST, $user_data["GUIDZakaz"], 1);
                            $_data = array(
                                "UF_CO_ID"      => $user_data["IDKP"],
                                "UF_XML_ID"     => $user_data["GUIDKP"],
                                "UF_STATUS"     => static::getStatusIDbyName($user_data["StatusKP"]),
                                "UF_ORDER_ID"   => $z_id,
                                "UF_ITEM_ID"    => static::getOfferbyName($arItems["Nomenklature"]),

                            );
                        }
                    }
                }
            } elseif($method_step == StepingHelper::STEP_GET_ORDER) {
                foreach($data_step as $user_xml_id=>$_user_data){
                    foreach($_user_data as $k=>$user_data){
                        $_data = Array(
                            "UF_XML_ID" => $user_data["GUIDZakaz"],
                            "UF_USER_ID" => static::getUserIDbyXMLID($user_xml_id),
                            "UF_NAME" => $user_data["ID"],
                            "UF_PRIORITY" => $user_data["Priority"],
                            "UF_STATUS" => static::getStatusIDbyName($user_data["StatusZayavka"], StepingHelper::STEP_GET_ORDER),
                            "UF_OFFER" => '0',
                            "UF_OFFERS" => static::getOffers($user_data["Tovary"]),
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

            } elseif($method_step == StepingHelper::STEP_GET_RTIU) {

            }
        }
    }
    private static function getOfferbyName($name){

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
    }
}