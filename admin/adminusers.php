<?php

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

$xentUsers = new XentUsers();
$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('adminusers');

OpenTable();
echo "<div class='adminHeader'>" . _AM_GEN_ADMINUSERSTITLE . ' (' . $xentUsers->countUsers() . ')</div><br>';

function USERSShowGEN()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentUsers = new XentUsers();

    buildAlphabeticalSearch();

    echo '<br>';

    buildUsersActionMenu();

    if (!empty($_GET['sort'])) {
        $sort = $_GET['sort'];
    } else {
        $sort = '';
    }

    #$xentUsers->synchronize();

    $result = $xentUsers->getAllUsers($sort);

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
            		<th>" . _AM_GEN_IMAGE . '</th>
                    <th>' . _AM_GEN_NAME . '</th>
                    <th>' . _AM_GEN_OPTIONS . '</th>
                </tr>';

    while (false !== ($cie_users = $xoopsDB->fetchArray($result))) {
        $xentUsers->setIdUser($cie_users['ID_USER']);

        $xentUsers->setName($cie_users['name']);

        $xentUsers->setPictPro($cie_users['pictpro']);

        $tmp = $xentUsers->getPictPro();

        if (!empty($tmp)) {
            $tmp = $xentUsers->getPictProPath();

            $pictpro = "<center><img height='30%' width='30%' src='" . $xentUsers->getPictProPath() . "'></img>";
        } else {
            $pictpro = '';
        }

        echo "
            	<tr>
                	<td class='even' width='15%'>" . $pictpro . "</td>
                    <td class='even'>" . $xentUsers->getName() . "</td>
                    <td class='even'><a href='adminusers.php?op=USERSEdit&id=" . $cie_users['ID_USER'] . "'>" . _AM_GEN_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function USERSEdit()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentUsers = new XentUsers();

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
        } else {
            $id = 0;
        }
    }

    if (0 != $id) {
        $user = $xentUsers->getUser($id);

        $xentUsers->setName($user['name']);

        $xentUsers->setIdUser($user['ID_USER']);

        $xentUsers->setIdJob($user['id_job']);

        $xentUsers->setIdTitle($user['id_title']);

        $xentUsers->setIdLocation($user['id_location']);

        $xentUsers->setPictPro($user['pictpro']);

        $xentUsers->setPriority($user['priority']);

        $xentUsers->setIdTypePoste($user['id_typeposte']);

        $tmp = $xentUsers->getPictPro();

        if (!empty($tmp)) {
            #$img = "<img src='".XOOPS_URL.$xoopsModuleConfig['image_upload_dir']."/".$xentUsers->getPictPro()."'></img>";

            $colimage = $xentUsers->getPictPro();

            $img = "<img src='" . XOOPS_URL . $xoopsModuleConfig['image_upload_dir'] . '/' . $colimage;
        } else {
            #$img = "<img src='".XOOPS_URL.$xoopsModuleConfig['image_upload_dir']."/blank.png'></img>";

            $colimage = 'blank.png';

            $img = "<img src='" . XOOPS_URL . $xoopsModuleConfig['image_upload_dir'] . '/' . $colimage;
        }

        $xentUsers->setCareerSummary($user['career_summary']);

        $tmp = $xentUsers->getCareerSummary();

        if (empty($tmp)) {
            $xentUsers->setCareerSummary('[fr][/fr][en][/en]');
        }

        $sform = new XoopsThemeForm(_AM_GEN_EDIT . ' - ' . $xentUsers->getName(), 'editxentuser', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $thearray = getTopic($module_tables[2], 'job', 'ID_JOB', 'job');

        $sform->addElement(makeSelect(_AM_GEN_JOB, 'job_select', $xentUsers->getIdJob(), $thearray, 1, 1));

        $hModule = xoops_getHandler('module');

        $xEntModule = $hModule->getByDirname('xentteam');

        if ($xEntModule) {
            require_once XOOPS_ROOT_PATH . '/modules/xentteam/class/xent_team_expertise.php';

            $thearray = getTopic(XENT_DB_XENT_TEAM_EXPERTISE_ITEM, 'name', 'ID_EXPERTISEITEM', 'name');

            $sform->addElement(makeSelect(_AM_TEAM_EXPERTISE, 'expertise_select', $xentTeamExpertise->getArrayUserExpertise($id), $thearray, 7, 0, true));
        }

        $thearray = getTopic($module_tables[1], 'title', 'ID_TITLE', 'title');

        $sform->addElement(makeSelect(_AM_GEN_TITLE, 'title_select', $xentUsers->getIdTitle(), $thearray, 1, 1));

        $thearray = getTopic($module_tables[4], 'typeposte', 'ID_TYPEPOSTE', 'typeposte');

        $sform->addElement(makeSelect(_AM_GEN_TYPEPOSTE, 'typeposte_select', $xentUsers->getIdTypePoste(), $thearray, 1, 1));

        $thearray = getTopic($module_tables[3], 'city', 'ID_LOCATION', 'city');

        $sform->addElement(makeSelect(_AM_GEN_LOCATION, 'locations_select', $xentUsers->getIdLocation(), $thearray, 1, 1));

        $sform->addElement(new XoopsFormTextArea(_AM_GEN_CAREERSUMMARY, 'career_summary', $xentUsers->getCareerSummary()));

        $sform->addElement(new XoopsFormText(_AM_GEN_PRIORITY, 'priority', 10, 2, $xentUsers->getPriority()));

        // preloaded image

        $graph_array = XoopsLists:: getImgListAsArray(XOOPS_ROOT_PATH . $xoopsModuleConfig['image_upload_dir']);

        $colimage_select = new XoopsFormSelect('', 'colimage', $colimage);

        $colimage_select->addOptionArray($graph_array);

        $colimage_select->setExtra("onchange='showImgSelected(\"image3\", \"colimage\", \"" . $xoopsModuleConfig['image_upload_dir'] . '", "", "' . XOOPS_URL . "\")'");

        $sform->addElement($colimage_select);

        $sform->addElement(new XoopsFormLabel('', '<br><br>' . $img . "' name='image3' id='image3' alt=''>"));

        $sform->addElement(new XoopsFormFile('', 'pict', $xoopsModuleConfig['max_file_size']));

        $save_button = new XoopsFormButton('', 'add', _AM_GEN_SAVE, 'submit');

        $save_button->setExtra("onmouseover='document.editxentuser.op.value=\"USERSSaveEdit\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.editxentuser.op.value=\"USERSShowGEN\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($save_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $xentUsers->getIdUser()));

        $sform->addElement(new XoopsFormHidden('op', 'GENSaveEdit'));

        $sform->display();
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function USERSSaveEdit($ID_USER, $id_job, $id_title, $typeposte, $locations, $pictpro, $career_summary, $priority)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentUser = new XentUsers();

    $xentUser->setIdUser($ID_USER);

    $xentUser->setIdJob($id_job);

    $xentUser->setIdTitle($id_title);

    $xentUser->setIdLocation($locations);

    $xentUser->setPictPro($pictpro);

    $xentUser->setCareerSummary($career_summary);

    $xentUser->setPriority($priority);

    $xentUser->setIdTypePoste($typeposte);

    $xentUser->update();
}

function USERSImportShow()
{
    $sform = new XoopsThemeForm(_AM_GEN_IMPORT, 'importgroup', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $thearray = getTopic('groups', 'name', 'groupid');

    $sform->addElement(makeSelect(_AM_GEN_IMPORTGROUPUSERS, 'select_importgroup', 1, $thearray, 3, 0));

    $save_button = new XoopsFormButton('', 'add', _AM_GEN_IMPORT, 'submit');

    $save_button->setExtra("onmouseover='document.importgroup.op.value=\"USERSImportSave\"'");

    $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

    $cancel_button->setExtra("onmouseover='document.importgroup.op.value=\"USERSShowGEN\"'");

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $button_tray->addElement($cancel_button);

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', ''));

    $sform->display();
}

function USERSImportSave($id_group)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentUsers = new XentUsers();

    $result = $xentUsers->getUsersToImport($id_group);

    while (false !== ($users_to_import = $xoopsDB->fetchArray($result))) {
        $xentUsers->setIdUser($users_to_import['uid']);

        $xentUsers->setIdJob(0);

        $xentUsers->setIdTitle(0);

        $xentUsers->setPictPro('');

        $xentUsers->setCareerSummary('');

        $xentUsers->setPriority(0);

        $xentUsers->setIdTypePoste(0);

        $xentUsers->setIdLocation(0);

        $xentUsers->add(1);
    }

    redirect_header('adminusers.php', 2, _AM_GEN_IMPORTINPROGRESS);
}

function USERSDbCleanUpShow()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $sform = new XoopsThemeForm(_AM_GEN_DBCLEANUP, 'dbcleanup', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $save_button = new XoopsFormButton('', 'add', _AM_GEN_YES, 'submit');

    $save_button->setExtra("onmouseover='document.dbcleanup.op.value=\"GENDbCleanUpSave\"'");

    $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_NO, 'submit');

    $cancel_button->setExtra("onmouseover='document.dbcleanup.op.value=\"GENShowGEN\"'");

    $button_tray = new XoopsFormElementTray(_AM_GEN_DBCLEANUPCONFIRM, '');

    $button_tray->addElement($save_button);

    $button_tray->addElement($cancel_button);

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', ''));

    $sform->display();
}

function USERSDbCleanUpSave()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentUsers = new XentUsers();

    $xentUsers->dbCleanUp();

    GENShowGEN();
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

switch ($op) {
    case 'USERSShowGEN':
        USERSShowGEN();
        break;
    case 'USERSEdit':
        USERSEdit();
        break;
    case 'USERSSaveEdit':

        if (!empty($HTTP_POST_FILES['pict']['name'])) {
            if (true === uploadFile(XOOPS_ROOT_PATH . $xoopsModuleConfig['image_upload_dir'], explode(';', $xoopsModuleConfig['image_extension']), $xoopsModuleConfig['max_file_size'], $_POST['xoops_upload_file'][0])) {
                $pictpro = $HTTP_POST_FILES['pict']['name'];
            } else {
                $pictpro = '';

                echo _AM_GEN_IMAGEUPLOADERROR;
            }
        } else {
            $pictpro = $colimage;
        }

        if (empty($expertise_select)) {
            $expertise_select = [];
        }

        USERSSaveEdit($id, $job_select, $title_select, $typeposte_select, $locations_select, $pictpro, $career_summary, $priority);
        break;
    case 'USERSImportShow':
        USERSImportShow();
        break;
    case 'USERSImportSave':
        USERSImportSave($select_importgroup);
        break;
    default:
        USERSShowGEN();
        break;
}

// *************************** Fin de NTS **********************************

buildUsersActionMenu();

CloseTable();

xoops_cp_footer();
