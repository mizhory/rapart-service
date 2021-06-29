<?php
namespace GetCode\Entity;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\TextField;

Loc::loadMessages(__FILE__);

/**
 * Class StatusesTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_XML_ID text optional
 * <li> UF_NAME text optional
 * <li> UF_STATUS_IMG int optional
 * </ul>
 *
 * @package Bitrix\Statuses
 **/

class StatusesTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'gk_statuses';
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
					'title' => Loc::getMessage('STATUSES_ENTITY_ID_FIELD')
				]
			),
			new TextField(
				'UF_XML_ID',
				[
					'title' => Loc::getMessage('STATUSES_ENTITY_UF_XML_ID_FIELD')
				]
			),
			new TextField(
				'UF_NAME',
				[
					'title' => Loc::getMessage('STATUSES_ENTITY_UF_NAME_FIELD')
				]
			),
			new IntegerField(
				'UF_STATUS_IMG',
				[
					'title' => Loc::getMessage('STATUSES_ENTITY_UF_STATUS_IMG_FIELD')
				]
			),
		];
	}
}