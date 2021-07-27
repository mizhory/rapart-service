<?php
namespace GetCode\Entity;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\TextField;

Loc::loadMessages(__FILE__);

/**
 * Class OrderTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_USER_ID int optional
 * <li> UF_OFFERS text optional
 * <li> UF_TIMESTAMP text optional
 * <li> UF_OFFER int optional
 * <li> UF_ORDER_TYPES int optional
 * <li> UF_NAME text optional
 * </ul>
 *
 * @package Bitrix\Customer
 **/

class CustomerOrderTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'gk_customer_order';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => Loc::getMessage('ORDER_ENTITY_ID_FIELD')
                ]
            ),
            new IntegerField(
                'UF_USER_ID',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_USER_ID_FIELD')
                ]
            ),
            new IntegerField(
                'UF_OFFER',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_OFFER_FIELD')
                ]
            ),
            new IntegerField(
                'UF_ORDER_TYPES',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_ORDER_TYPES_FIELD')
                ]
            ),
            new TextField(
                'UF_NAME',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_NAME_FIELD')
                ]
            ),
            new TextField(
                'UF_XML_ID',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_XML_ID_FIELD')
                ]
            ),
            new IntegerField(
                'UF_STATUS',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_STATUS_FIELD')
                ]
            ),
            new TextField(
                'UF_PERC_PAYMENT',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_PERC_PAYMENT_FIELD')
                ]
            ),
            new TextField(
                'UF_PERC_SHIPMENT',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_PERC_SHIPMENT_FIELD')
                ]
            ),
            new TextField(
                'UF_OFFERS',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_OFFERS_FIELD')
                ]
            ),
            new TextField(
                'UF_PRIORITY',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_PRIORITY_FIELD')
                ]
            ),
            new TextField(
                'UF_DATE',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_DATE_FIELD')
                ]
            ),
            new TextField(
                'UF_NUMBER_CUSTOMER',
                [
                    'title' => Loc::getMessage('ORDER_ENTITY_UF_NUMBER_CUSTOMER_FIELD')
                ]
            ),
        ];
    }
}