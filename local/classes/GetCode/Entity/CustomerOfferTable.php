<?php
namespace GetCode\Entity;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\TextField;

Loc::loadMessages(__FILE__);

/**
 * Class OfferTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_CO_ID int optional
 * <li> UF_XML_ID text optional
 * <li> UF_CO_FILE int optional
 * <li> UF_USER_ID int optional
 * <li> UF_ITEM_ID int optional
 * <li> UF_ORDER_ID int optional
 * <li> UF_STATUS int optional
 * </ul>
 *
 * @package Bitrix\Customer
 **/

class CustomerOfferTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'gk_customer_offer';
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
					'title' => Loc::getMessage('OFFER_ENTITY_ID_FIELD')
				]
			),
			new IntegerField(
				'UF_CO_ID',
				[
					'title' => Loc::getMessage('OFFER_ENTITY_UF_CO_ID_FIELD')
				]
			),
			new TextField(
				'UF_XML_ID',
				[
					'title' => Loc::getMessage('OFFER_ENTITY_UF_XML_ID_FIELD')
				]
			),
			new IntegerField(
				'UF_CO_FILE',
				[
					'title' => Loc::getMessage('OFFER_ENTITY_UF_CO_FILE_FIELD')
				]
			),
			new IntegerField(
				'UF_USER_ID',
				[
					'title' => Loc::getMessage('OFFER_ENTITY_UF_USER_ID_FIELD')
				]
			),
			new IntegerField(
				'UF_ITEM_ID',
				[
					'title' => Loc::getMessage('OFFER_ENTITY_UF_ITEM_ID_FIELD')
				]
			),
			new IntegerField(
				'UF_ORDER_ID',
				[
					'title' => Loc::getMessage('OFFER_ENTITY_UF_ORDER_ID_FIELD')
				]
			),
			new IntegerField(
				'UF_STATUS',
				[
					'title' => Loc::getMessage('OFFER_ENTITY_UF_STATUS_FIELD')
				]
			),
		];
	}
}