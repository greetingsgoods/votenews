<?php


namespace Local\Newsvote;

use Bitrix\Main\Entity\Validator\RegExp;
use Bitrix\Main\ORM\Data;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\Localization\Loc;
use Exception;

class EntityTable extends Data\DataManager
{

	public static function getTableName()
	{
		return "a_newsvote";
	}

	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('LOCAL_NEWSVOTE_ENTITY_ID_FIELD'),
			),
			'IP' => array(
				'data_type' => 'text',
				'default_value' => '',
				'title' => Loc::getMessage('LOCAL_NEWSVOTE_ENTITY_IP_FIELD'),
			),
			'elementID' => array(
				'data_type' => 'integer',
				'default_value' => '',
				'title' => Loc::getMessage('LOCAL_NEWSVOTE_ENTITY_IDELEMENT_FIELD'),
			),
			'iblocktID' => array(
				'data_type' => 'integer',
				'default_value' => '',
				'title' => Loc::getMessage('LOCAL_NEWSVOTE_ENTITY_IDIBLOCK_FIELD'),
			),
			'vote' => array(
				'data_type' => 'boolean',
				'default_value' => false,
				'values' => array('N', 'Y'),
				'title' => Loc::getMessage('LOCAL_NEWSVOTE_ENTITY_VOTE_FIELD'),
			)
		);
	}

	public static function validationPhone()
	{
		return array(
			new RegExp('/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/')
		);
	}

	public static function validationEmail()
	{
		return array(
			new RegExp('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/')
		);
	}


}
