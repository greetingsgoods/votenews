<?

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Config\Option;
use Bitrix\Main\IO\File;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class local_newsvote extends CModule
{
	const MODULE_ID = 'local.newsvote';
	var $MODULE_ID = 'local.newsvote';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(__DIR__ . "/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = Loc::getMessage("LOCAL_NEWSVOTE_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("LOCAL_NEWSVOTE_MODULE_DESC");

		$this->PARTNER_NAME = getMessage("LOCAL_NEWSVOTE_PARTNER_NAME");
		$this->PARTNER_URI = getMessage("LOCAL_NEWSVOTE_PARTNER_URI");

		$this->exclusionAdminFiles = array(
			'..',
			'.',
			'menu.php',
			'operation_description.php',
			'task_description.php'
		);
	}

	function getSitesIdsArray()
	{
		$ids = array();
		$rsSites = CSite::GetList($by = "sort", $order = "desc");
		while ($arSite = $rsSites->Fetch()) {
			$ids[] = $arSite["LID"];
		}

		return $ids;
	}

	function DoInstall()
	{

		global $APPLICATION;
		if ($this->isVersionD7()) {
			ModuleManager::registerModule($this->MODULE_ID);

			if (!$this->isTypeSite()) {
				$this->InstallDB();
			}

			$this->createNecessaryMailEvents();
			$this->InstallEvents();
			$this->InstallFiles();
		} else {
			$APPLICATION->ThrowException(Loc::getMessage("LOCAL_NEWSVOTE_INSTALL_ERROR_VERSION"));
		}

		$APPLICATION->IncludeAdminFile(Loc::getMessage("LOCAL_NEWSVOTE_INSTALL"), $this->GetPath() . "/install/step.php");
	}

	function isVersionD7()
	{
		return CheckVersion(ModuleManager::getVersion('main'), '14.00.00');
	}

	function isTypeSite()
	{
		return \Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/install/wizards');
	}

	function GetPath($notDocumentRoot = false)
	{
		if ($notDocumentRoot) {
			return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
		} else {
			return dirname(__DIR__);
		}
	}

	function InstallDB($arParams = array())
	{
		$this->createNecessaryIblocks();
		$this->createEntity();
	}

	function createEntity()
	{

		$rc = new Local\Newsvote\EntityTable;
		try {
			$rc::getEntity()->createDbTable();
		} catch (Exception $e) {
		}
		return true;
	}

	function createNecessaryIblocks()
	{
		if (CModule::IncludeModule("iblock")) {
			$dbIblockType = CIBlockType::GetList(
				array("SORT" => "ASC"),
				array("ID" => "news")
			);
			$iblockTypeID = 0;
			if ($arIblockType = $dbIblockType->Fetch()) {
				$iblockTypeID = $arIblockType["ID"];
			}

			if (!$iblockTypeID) {
				$obBlocktype = new CIBlockType;
				$res = $obBlocktype->Add(
					array(
						'ID' => 'news',
						'SECTIONS' => 'Y',
						'IN_RSS' => 'N',
						'SORT' => 1000,
						'LANG' => array(
							'en' => array(
								'NAME' => 'News',
								'SECTION_NAME' => 'Sections',
								'ELEMENT_NAME' => 'Elements'
							)
						),
						'ru' => array(
							'NAME' => GetMessage("IBLOCK_TYPE_NAME"),
							'SECTION_NAME' => GetMessage("IBLOCK_TYPE_SECTION_NAME"),
							'ELEMENT_NAME' => GetMessage("IBLOCK_TYPE_ELEMENTS_NAME")
						)
					)
				);
				if (!$res) {
					echo $obBlocktype->LAST_ERROR;
				}
			}
			$boolExistIBLOCK = (bool)IblockTable::getList(array(
				'filter' => array('CODE' => 'news', 'NAME' => GetMessage("IBLOCK_NAME")),
			))->fetch();
			if ($boolExistIBLOCK) {
				return true;
			}
			$ib = new CIBlock;
			$ID = $ib->Add(
				array(
					"ACTIVE" => "Y",
					"NAME" => GetMessage("IBLOCK_NAME"),
					"CODE" => "news",
					"LIST_PAGE_URL" => "#SITE_DIR#/news/",
					"SECTION_PAGE_URL" => "#SITE_DIR#/news/#SECTION_CODE#/",
					"DETAIL_PAGE_URL" => "#SITE_DIR#/news/#ELEMENT_CODE#/",
					"IBLOCK_TYPE_ID" => "news",
					"SORT" => 1000,
					"PICTURE" => false,
					"DESCRIPTION" => false,
					"DESCRIPTION_TYPE" => 'text',
					"GROUP_ID" => array("2" => "R"),
					"SITE_ID" => array('s1')
				)
			);
			if ($ID > 0) {
				$ibp = new CIBlockProperty;
				$ibp->Add(
					array(
						"NAME" => "PHOTOGALLERY",
						"ACTIVE" => "Y",
						"SORT" => "100",
						"CODE" => "PHOTOGALLERY",
						"PROPERTY_TYPE" => "E",
						"IBLOCK_ID" => $ID,
						"MULTIPLE" => "Y"
					)
				);
				$ibp->Add(
					array(
						"NAME" => "LIKE",
						"ACTIVE" => "Y",
						"SORT" => "200",
						"CODE" => "LIKE",
						"PROPERTY_TYPE" => "S",
						"IBLOCK_ID" => $ID,
						"USER_TYPE" => "UserID",
						"MULTIPLE" => "Y"
					)
				);
				$ibp->Add(
					array(
						"NAME" => "DISLIKE",
						"ACTIVE" => "Y",
						"SORT" => "200",
						"CODE" => "DISLIKE",
						"PROPERTY_TYPE" => "S",
						"IBLOCK_ID" => $ID,
						"USER_TYPE" => "UserID",
						"MULTIPLE" => "Y"
					)
				);
			} else {
				echo $ib->LAST_ERROR;
			}
		}
		return true;
	}

	function createNecessaryMailEvents()
	{
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		$fromfolder = function () {
			if ((stripos(dirname(__DIR__), 'local')) !== false) {
				return '/local/modules/';
			} else {
				return '/bitrix/modules/';
			}
		};

		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . $fromfolder() . self::MODULE_ID . '/install/templates')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.')
						continue;
					CopyDirFiles($p . '/' . $item, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/templates/' . $item, $ReWrite = True, $Recursive = True);
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'] . $fromfolder() . self::MODULE_ID . '/install/components')) {
			if ($dir = opendir($p)) {
				while (false !== $item = readdir($dir)) {
					if ($item == '..' || $item == '.')
						continue;
					CopyDirFiles($p . '/' . $item, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/' . $item, $ReWrite = True, $Recursive = True);
				}
				closedir($dir);
			}
		}

		if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/install/files')) {
			$this->copyArbitraryFiles();
		}

		return true;
	}

	function copyArbitraryFiles()
	{
		return true;
	}

	function DoUninstall()
	{

		global $APPLICATION;

		$context = Application::getInstance()->getContext();
		$request = $context->getRequest();

		$this->UnInstallFiles();
		$this->deleteNecessaryMailEvents();
		$this->UnInstallEvents();

		if ($request["savedata"] != "Y") {
			$this->UnInstallDB();
		}

		ModuleManager::unRegisterModule($this->MODULE_ID);

		$APPLICATION->IncludeAdminFile(Loc::getMessage("LOCAL_NEWSVOTE_UNINSTALL"), $this->GetPath() . "/install/unstep.php");
	}

	function UnInstallFiles()
	{
		\Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/' . $this->MODULE_ID . '/');

		\Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"] . '/bitrix/wizards/local/');

		if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin')) {
			DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . $this->GetPath() . '/install/admin/', $_SERVER["DOCUMENT_ROOT"] . '/bitrix/admin');
			if ($dir = opendir($path)) {
				while (false !== $item = readdir($dir)) {
					if (in_array($item, $this->exclusionAdminFiles))
						continue;
					File::deleteFile($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item);
				}
				closedir($dir);
			}
		}

		if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/install/files')) {
			$this->deleteArbitraryFiles();
		}

		return true;
	}

	function deleteArbitraryFiles()
	{
		$rootPath = $_SERVER["DOCUMENT_ROOT"];
		$localPath = $this->GetPath() . '/install/files';

		$dirIterator = new RecursiveDirectoryIterator($localPath, RecursiveDirectoryIterator::SKIP_DOTS);
		$iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);

		foreach ($iterator as $object) {
			if (!$object->isDir()) {
				$file = str_replace($localPath, $rootPath, $object->getPathName());
				File::deleteFile($file);
			}
		}
	}

	function deleteNecessaryMailEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		Option::delete($this->MODULE_ID);
		$this->deleteNecessaryIblocks();
		$this->deleteNecessaryUserFields();
		$this->deleteEntity();
	}

	function deleteEntity()
	{
		$connection = Application::getConnection()
			->query("DROP TABLE IF EXISTS a_newsvote;");
	}

	function deleteNecessaryIblocks()
	{
		return true;
	}

	function deleteNecessaryUserFields()
	{
		return true;
	}


}

?>
