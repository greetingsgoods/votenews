<?php

namespace Local\Newsvote;


use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\Date;

Loader::includeModule('highloadblock');

class HLTable
{

	public $MODULE_ID = "local.newsvote";

	public function __construct($arIncm = [])
	{

	}

}

