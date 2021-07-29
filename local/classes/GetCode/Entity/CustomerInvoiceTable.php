<?php
namespace GetCode\Entity;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\TextField;

Loc::loadMessages(__FILE__);

/**
 * Class InvoiceTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_NAME text optional
 * <li> UF_XML_ID text optional
 * <li> UF_DATE text optional
 * <li> UF_STATUS int optional
 * <li> UF_REQUEST text optional
 * <li> UF_FORMAT_INVOICE text optional
 * <li> UF_FILE_INVOICE_REMOTE_SERVER text optional
 * <li> UF_NULLED_INVOICE int optional
 * <li> UF_SUMM text optional
 * <li> UF_CURRENCY text optional
 * <li> UF_KP_ID int optional
 * </ul>
 *
 * @package Bitrix\Customer
 **/

class CustomerInvoiceTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'gk_customer_invoice';
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
                    'title' => Loc::getMessage('INVOICE_ENTITY_ID_FIELD')
                ]
            ),
            new TextField(
                'UF_NAME',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_NAME_FIELD')
                ]
            ),
            new TextField(
                'UF_XML_ID',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_XML_ID_FIELD')
                ]
            ),
            new TextField(
                'UF_DATE',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_DATE_FIELD')
                ]
            ),
            new IntegerField(
                'UF_STATUS',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_STATUS_FIELD')
                ]
            ),
            new TextField(
                'UF_REQUEST',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_REQUEST_FIELD')
                ]
            ),
            new TextField(
                'UF_FORMAT_INVOICE',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_FORMAT_INVOICE_FIELD')
                ]
            ),
            new IntegerField(
                'UF_NULLED_INVOICE',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_NULLED_INVOICE_FIELD')
                ]
            ),
            new TextField(
                'UF_SUMM',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_SUMM_FIELD')
                ]
            ),
            new TextField(
                'UF_CURRENCY',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_CURRENCY_FIELD')
                ]
            ),
            new IntegerField(
                'UF_KP_ID',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_KP_ID_FIELD')
                ]
            ),
            new TextField(
                'UF_USER_ID',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_USER_ID_FIELD')
                ]
            ),
            new TextField(
                'UF_FILES',
                [
                    'title' => Loc::getMessage('INVOICE_ENTITY_UF_FILES_FIELD')
                ]
            ),
        ];
    }
}