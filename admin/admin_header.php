<?php

//echo "<link rel='stylesheet' type='text/css' media='all' href='include/admin.css'>";

require __DIR__ . '/admin_buttons.php';
include '../../../mainfile.php';
require dirname(__DIR__, 3) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsmodule.php';
require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once dirname(__DIR__) . '/include/functions.php';
require_once dirname(__DIR__) . '/class/xent_jobs.php';
require_once dirname(__DIR__) . '/class/xent_users.php';
require_once dirname(__DIR__) . '/class/xent_titles.php';
require_once dirname(__DIR__) . '/class/xent_typesposte.php';
require_once dirname(__DIR__) . '/class/xent_locations.php';

global $xoopsModule;

$versioninfo = $moduleHandler->get($xoopsModule->getVar('mid'));
$module_tables = $versioninfo->getInfo('tables');

if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname('xentgen');

    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 1, _NOPERM);

        exit();
    }
} else {
    redirect_header(XOOPS_URL . '/', 1, _NOPERM);

    exit();
}

$module_id = $xoopsModule->getVar('mid');
$oAdminButton = new AdminButtons();
$oAdminButton->AddTitle(_AM_GEN_ADMINMENUTITLE);

$oAdminButton->AddButton(_AM_GEN_INDEX, 'index.php', 'index');
$oAdminButton->AddButton(_AM_GEN_ADMINUSERS, 'adminusers.php', 'adminusers');
$oAdminButton->AddButton(_AM_GEN_ADMINJOBS, 'adminjobs.php', 'adminjobs');
$oAdminButton->AddButton(_AM_GEN_ADMINTITLES, 'admintitles.php', 'admintitles');
$oAdminButton->AddButton(_AM_GEN_ADMINTYPESPOSTE, 'admintypesposte.php', 'admintypesposte');
$oAdminButton->AddButton(_AM_GEN_ADMINLOCATIONS, 'adminlocations.php', 'adminlocations');

$oAdminButton->AddTopLink(_AM_GEN_PREFERENCES, XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $module_id);
$oAdminButton->addTopLink(_AM_GEN_UPDATEMODULE, XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=xentgen');

$myts = MyTextSanitizer::getInstance();
