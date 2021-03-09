<?

use Bitrix\Main\ModuleManager,
    Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (class_exists("nizamov.blogpostformext")) {
    return;
}

class nizamov_blogpostformext extends CModule
{
    function __construct()
    {
        $arModuleVersion = [];
        include(dirname(__FILE__) . "/version.php");
        $this->MODULE_ID = 'nizamov.blogpostformext';
        $this->MODULE_NAME = 'Дата публикации для постов';
        $this->MODULE_DESCRIPTION = '';
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
    }

    public function RegisterDepedencies()
    {
        RegisterModuleDependences(
            "main",
            "OnEpilog",
            "nizamov.blogpostformext",
            "\Nizamov\BlogPostFormExt\Events",
            "onEpilogEvent"
        );

        CAgent::AddAgent(
            "Nizamov\BlogPostFormExt\BlogPostAgent::checkDraftPosts();",
            "nizamov.blogpostformext",
            "N",
            60,
            '',
            'Y'
        );
    }

    public function DoInstall()
    {
        global $APPLICATION;

        if (!CheckVersion(ModuleManager::getVersion('main'), '14.0.0')) {
            $APPLICATION->ThrowException('Ваша система не поддерживает D7');
        } else {
            ModuleManager::RegisterModule($this->MODULE_ID);
            $this->RegisterDepedencies();
        }

        $APPLICATION->IncludeAdminFile(
            "Установка модуля nizamov.blogpostformext",
            dirname(__FILE__) . "/step.php"
        );
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        \CAgent::RemoveModuleAgents("nizamov.blogpostformext");

        UnRegisterModuleDependences(
            "main",
            "OnEpilog",
            "nizamov.blogpostformext",
            "\Nizamov\BlogPostFormExt\Events",
            "onEpilogEvent"
        );

        $APPLICATION->IncludeAdminFile(
            "Деинсталляция модуля nizamov.blogpostformext",
            dirname(__FILE__) . "/unstep.php"
        );
    }
}
