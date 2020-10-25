<?php

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('adminjobs');

OpenTable();
echo "<div class='adminHeader'>" . _AM_GEN_ADMINJOBSTITLE . '</div><br>';

function JOBSShowJobs()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentJobs = new XentJobs();

    $myts = MyTextSanitizer::getInstance();

    $result = $xentJobs->getAllJobs();

    echo "<div align='right' class='adminActionMenu'><a href='adminjobs.php?op=JOBSAddJob'>" . _AM_GEN_ADDJOB . '</a></div>';

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
                    <th>" . _AM_GEN_NAME . '</th>
                    <th>' . _AM_GEN_OPTIONS . '</th>
                </tr>';

    while (false !== ($jobs = $xoopsDB->fetchArray($result))) {
        $xentJobs->setIdJob($jobs['ID_JOB']);

        $xentJobs->setJobName($jobs['job']);

        echo "
            	<tr>
                    <td class='even'>" . $myts->displayTarea($xentJobs->getJobName()) . "</td>
                    <td class='even'><a href='adminjobs.php?op=JOBSEditJob&id=" . $jobs['ID_JOB'] . "'>" . _AM_GEN_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function JOBSAddJob()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentJobs = new XentJobs();

    $myts = MyTextSanitizer::getInstance();

    if (!empty($_GET['job'])) {
        $xentJobs->setJobName($_GET['job']);
    } else {
        $xentJobs->setJobName('[fr][/fr][en][/en]');
    }

    if (!empty($_GET['description'])) {
        $xentJobs->setDescription($_GET['description']);
    } else {
        $xentJobs->setDescription('');
    }

    $sform = new XoopsThemeForm(_AM_GEN_ADDJOB, 'addjob', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText(_AM_GEN_JOB, 'job', 50, 255, $xentJobs->getJobName()));

    $sform->addElement(new XoopsFormTextArea(_AM_GEN_DESCRIPTION, 'desc', $xentJobs->getDescription()));

    $save_button = new XoopsFormButton('', 'add', _AM_GEN_ADD, 'submit');

    $save_button->setExtra("onmouseover='document.addjob.op.value=\"JOBSSaveAddJob\"'");

    $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

    $cancel_button->setExtra("onmouseover='document.addjob.op.value=\"JOBSShowJob\"'");

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $button_tray->addElement($cancel_button);

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', ''));

    $sform->display();
}

function JOBSSaveAddJob($job, $description)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentJobs = new XentJobs();

    $xentJobs->setJobName($job);

    $xentJobs->setDescription($description);

    $xentJobs->add();
}

function JOBSEditJob()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentJobs = new XentJobs();

    $myts = MyTextSanitizer::getInstance();

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
        $job = $xentJobs->getJob($id);

        $xentJobs->setIdJob($job['ID_JOB']);

        $xentJobs->setJobName($job['job']);

        $xentJobs->setDescription($job['description']);

        $sform = new XoopsThemeForm(_AM_GEN_EDIT . ' - ' . $myts->displayTarea($xentJobs->getJobName()), 'editjob', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(new XoopsFormText(_AM_GEN_JOB, 'job', 50, 255, $xentJobs->getJobName()));

        $sform->addElement(new XoopsFormTextArea(_AM_GEN_DESCRIPTION, 'desc', $xentJobs->getDescription()));

        $save_button = new XoopsFormButton('', 'add', _AM_GEN_MODIFY, 'submit');

        $save_button->setExtra("onmouseover='document.editjob.op.value=\"JOBSSaveEditJob\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_DELETE, 'submit');

        $cancel_button->setExtra("onmouseover='document.editjob.op.value=\"JOBSAreYouSureToDeleteJob\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($save_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $xentJobs->getIdJob()));

        $sform->addElement(new XoopsFormHidden('op', ''));

        $sform->display();
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function JOBSSaveEditJob($id, $job, $description)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentJobs = new XentJobs();

    $xentJobs->setIdJob($id);

    $xentJobs->setJobName($job);

    $xentJobs->setDescription($description);

    $xentJobs->update();
}

function JOBSAreYouSureToDeleteJob($id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    $xentJobs = new XentJobs();

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $job = $xentJobs->getJob($id);

    if (!empty($job['ID_JOB'])) {
        $sform = new XoopsThemeForm(_AM_GEN_AREYOUSUREDELETE, 'deljob', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(new XoopsFormLabel(_AM_GEN_JOB, $myts->displayTarea($job['job'])));

        $delete_button = new XoopsFormButton('', 'add', _AM_GEN_DELETE, 'submit');

        $delete_button->setExtra("onmouseover='document.deljob.op.value=\"JOBSDeleteJob\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.deljob.op.value=\"JOBSEditJob\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($delete_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $id));

        $sform->addElement(new XoopsFormHidden('op', ''));

        $sform->display();
    }  

    // aucune job, msg d'erreur
}

function JOBSDeleteJob($id)
{
    $xentJobs = new XentJobs();

    $xentJobs->delete($id);
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

switch ($op) {
    case 'JOBSAddJob':
        JOBSAddJob();
        break;
    case 'JOBSSaveAddJob':
        JOBSSaveAddJob($job, $desc);
        break;
    case 'JOBSEditJob':
        JOBSEditJob();
        break;
    case 'JOBSSaveEditJob':
        JOBSSaveEditJob($id, $job, $desc);
        break;
    case 'JOBSAreYouSureToDeleteJob':
        JOBSAreYouSureToDeleteJob($id);
        break;
    case 'JOBSDeleteJob':
        JOBSDeleteJob($id);
        break;
    default:
        JOBSShowJobs();
        break;
}

// *************************** Fin de NTS **********************************

buildJobsActionMenu();

CloseTable();

xoops_cp_footer();
