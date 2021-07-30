<?php
namespace GetCode\Entity;
use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\TextField;

Loc::loadMessages(__FILE__);

/**
 * Class RtiuTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_ORDER_ID int optional
 * <li> UF_NAME text optional
 * <li> UF_DATE text optional
 * <li> UF_SUMM text optional
 * <li> UF_FILES text optional
 * </ul>
 *
 * @package Bitrix\Rtiu
 **/
class CustomerRTIUTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'gk_rtiu';
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
                    'title' => Loc::getMessage('RTIU_ENTITY_ID_FIELD')
                ]
            ),
            new IntegerField(
                'UF_ORDER_ID',
                [
                    'title' => Loc::getMessage('RTIU_ENTITY_UF_ORDER_ID_FIELD')
                ]
            ),
            new TextField(
                'UF_NAME',
                [
                    'title' => Loc::getMessage('RTIU_ENTITY_UF_NAME_FIELD')
                ]
            ),
            new TextField(
                'UF_DATE',
                [
                    'title' => Loc::getMessage('RTIU_ENTITY_UF_DATE_FIELD')
                ]
            ),
            new TextField(
                'UF_SUMM',
                [
                    'title' => Loc::getMessage('RTIU_ENTITY_UF_SUMM_FIELD')
                ]
            ),
            new TextField(
                'UF_FILES',
                [
                    'title' => Loc::getMessage('RTIU_ENTITY_UF_FILES_FIELD')
                ]
            ),
            new TextField(
                'UF_USER_ID',
                [
                    'title' => Loc::getMessage('RTIU_ENTITY_UF_USER_ID_FIELD')
                ]
            ),
        ];
    }
}