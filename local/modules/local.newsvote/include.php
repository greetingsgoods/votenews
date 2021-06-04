<?

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses('local.newsvote', array(
	'Local\Newsvote\EntityTable' => 'lib/entity.php',
));
