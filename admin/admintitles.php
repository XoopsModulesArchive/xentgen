<?php

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('admintitles');

OpenTable();
echo "<div class='adminHeader'>" . _AM_GEN_ADMINTITLESTITLE . '</div><br>';

function TITLESShowTitles()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTitles = new XentTitles();

    $myts = MyTextSanitizer::getInstance();

    $result = $xentTitles->getAllTitles();

    echo "<div align='right' class='adminActionMenu'><a href='admintitles.php?op=TITLESAddTitle'>" . _AM_GEN_ADDTITLE . '</a></div>';

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
                    <th>" . _AM_GEN_NAME . '</th>
                    <th>' . _AM_GEN_OPTIONS . '</th>
                </tr>';

    while (false !== ($titles = $xoopsDB->fetchArray($result))) {
        $xentTitles->setIdTitle($titles['ID_TITLE']);

        $xentTitles->setTitleName($titles['title']);

        echo "
            	<tr>
                    <td class='even'>" . $myts->displayTarea($xentTitles->getTitleName()) . "</td>
                    <td class='even'><a href='admintitles.php?op=TITLESEditTitle&id=" . $titles['ID_TITLE'] . "'>" . _AM_GEN_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function TITLESAddTitle()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTitles = new XentTitles();

    $myts = MyTextSanitizer::getInstance();

    if (!empty($_GET['title'])) {
        $xentTitles->setTitleName($_GET['title']);
    } else {
        $xentTitles->setTitleName('[fr][/fr][en][/en]');
    }

    $sform = new XoopsThemeForm(_AM_GEN_ADDTITLE, 'addtitle', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText(_AM_GEN_TITLE, 'title', 50, 255, $xentTitles->getTitleName()));

    $save_button = new XoopsFormButton('', 'add', _AM_GEN_ADD, 'submit');

    $save_button->setExtra("onmouseover='document.addtitle.op.value=\"TITLESSaveAddTitle\"'");

    $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

    $cancel_button->setExtra("onmouseover='document.addtitle.op.value=\"TITLESShowTitles\"'");

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $button_tray->addElement($cancel_button);

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', ''));

    $sform->display();
}

function TITLESSaveAddTitle($title)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTitles = new XentTitles();

    $xentTitles->setTitleName($title);

    $xentTitles->add();
}

function TITLESEditTitle()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTitles = new XentTitles();

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
        $title = $xentTitles->getTitle($id);

        if (!empty($title['ID_TITLE'])) {
            $xentTitles->setIdTitle($title['ID_TITLE']);

            $xentTitles->setTitleName($title['title']);

            $sform = new XoopsThemeForm(_AM_GEN_EDIT . ' - ' . $myts->displayTarea($xentTitles->getTitleName()), 'edittitle', xoops_getenv('PHP_SELF'));

            $sform->setExtra('enctype="multipart/form-data"');

            $sform->addElement(new XoopsFormText(_AM_GEN_TITLE, 'title', 50, 255, $xentTitles->getTitleName()));

            $save_button = new XoopsFormButton('', 'add', _AM_GEN_MODIFY, 'submit');

            $save_button->setExtra("onmouseover='document.edittitle.op.value=\"TITLESSaveEditTitle\"'");

            $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_DELETE, 'submit');

            $cancel_button->setExtra("onmouseover='document.edittitle.op.value=\"TITLESAreYouSureToDeleteTitle\"'");

            $button_tray = new XoopsFormElementTray('', '');

            $button_tray->addElement($save_button);

            $button_tray->addElement($cancel_button);

            $sform->addElement($button_tray);

            $sform->addElement(new XoopsFormHidden('id', $xentTitles->getIdTitle()));

            $sform->addElement(new XoopsFormHidden('op', ''));

            $sform->display();
        }
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function TITLESSaveEditTitle($id, $title)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTitles = new XentTitles();

    $xentTitles->setIdTitle($id);

    $xentTitles->setTitleName($title);

    $xentTitles->update();
}

function TITLESAreYouSureToDeleteTitle($id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    $xentTitles = new XentTitles();

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $title = $xentTitles->getTitle($id);

    if (!empty($title['ID_TITLE'])) {
        $sform = new XoopsThemeForm(_AM_GEN_AREYOUSUREDELETE, 'deltitle', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(new XoopsFormLabel(_AM_GEN_TITLE, $myts->displayTarea($title['title'])));

        $delete_button = new XoopsFormButton('', 'add', _AM_GEN_DELETE, 'submit');

        $delete_button->setExtra("onmouseover='document.deltitle.op.value=\"TITLESDeleteTitle\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.deltitle.op.value=\"TITLESEditTitle\"'");

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

function TITLESDeleteTitle($id)
{
    $xentTitles = new XentTitles();

    $xentTitles->delete($id);
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

switch ($op) {
    case 'TITLESAddTitle':
        TITLESAddTitle();
        break;
    case 'TITLESSaveAddTitle':
        TITLESSaveAddTitle($title);
        break;
    case 'TITLESEditTitle':
        TITLESEditTitle();
        break;
    case 'TITLESSaveEditTitle':
        TITLESSaveEditTitle($id, $title);
        break;
    case 'TITLESAreYouSureToDeleteTitle':
        TITLESAreYouSureToDeleteTitle($id);
        break;
    case 'TITLESDeleteTitle':
        TITLESDeleteTitle($id);
        break;
    default:
        TITLESShowTitles();
        break;
}

// *************************** Fin de NTS **********************************

buildTitlesActionMenu();

CloseTable();

xoops_cp_footer();
