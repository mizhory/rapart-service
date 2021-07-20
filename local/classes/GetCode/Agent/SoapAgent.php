<?php
namespace GetCode\Agent;

use GetCode\API\SOAP\SoapConnector,
    GetCode\Helper\StepingHelper,
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
            array('SORT' => 'asc'),
            "sort",
            $arFilter = array('!XML_ID' => false),
            $arParams = array());
        while($arUser = $e->fetch()){
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
        \Bitrix\Main\Diag\Debug::writeToFile($steping_data);
        static::$steping_data = $steping_data;
    }
    private static function syncStep() {
        foreach(static::$steping_data as $method_step=>$data_step){
            if($method_step == StepingHelper::STEP_GET_REQUEST) {

            } elseif($method_step == StepingHelper::STEP_GET_KP) {

            } elseif($method_step == StepingHelper::STEP_GET_ORDER) {

            } elseif($method_step == StepingHelper::STEP_GET_INVOICE) {

            } elseif($method_step == StepingHelper::STEP_GET_RTIU) {

            }
        }
    }
    public static function sync() {
        global $APPLICATION, $USER;
        SoapConnector::initConnect();
        static::preStep();
        static::checkAuthorizedUser($USER);
        static::coreStep();
        static::syncStep();
        /*
         * getRequests - получение заявок
         * getOrder - получение заказов
         * getQuatation - получение КП
         * getInvoices - получение счетов
         *
         */
    }
}