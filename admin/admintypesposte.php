<?php

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('admintypesposte');

OpenTable();
echo "<div class='adminHeader'>" . _AM_GEN_ADMINTYPESPOSTETITLE . '</div><br>';

function TPShowTp()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTypesPoste = new XentTypesPoste();

    $myts = MyTextSanitizer::getInstance();

    $result = $xentTypesPoste->getAllTypesPoste();

    echo "<div align='right' class='adminActionMenu'><a href='admintypesposte.php?op=TPAddTp'>" . _AM_GEN_ADDTYPEPOSTE . '</a></div>';

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
                    <th>" . _AM_GEN_NAME . '</th>
                    <th>' . _AM_GEN_OPTIONS . '</th>
                </tr>';

    while (false !== ($typesposte = $xoopsDB->fetchArray($result))) {
        $xentTypesPoste->setIdTypePoste($typesposte['ID_TYPEPOSTE']);

        $xentTypesPoste->setTypePosteName($typesposte['typeposte']);

        echo "
            	<tr>
                    <td class='even'>" . $myts->displayTarea($xentTypesPoste->getTypePosteName()) . "</td>
                    <td class='even'><a href='admintypesposte.php?op=TPEditTp&id=" . $typesposte['ID_TYPEPOSTE'] . "'>" . _AM_GEN_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function TPAddTp()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTypesPoste = new XentTypesPoste();

    $myts = MyTextSanitizer::getInstance();

    if (!empty($_GET['typeposte'])) {
        $xentTypesPoste->setTypePosteName($_GET['typeposte']);
    } else {
        $xentTypesPoste->setTypePosteName('[fr][/fr][en][/en]');
    }

    $sform = new XoopsThemeForm(_AM_GEN_ADDTYPEPOSTE, 'addtypeposte', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText(_AM_GEN_TYPEPOSTE, 'typeposte', 50, 255, $xentTypesPoste->getTypePosteName()));

    $save_button = new XoopsFormButton('', 'add', _AM_GEN_ADD, 'submit');

    $save_button->setExtra("onmouseover='document.addtypeposte.op.value=\"TPSaveAddTp\"'");

    $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

    $cancel_button->setExtra("onmouseover='document.addtypeposte.op.value=\"TPShowTp\"'");

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $button_tray->addElement($cancel_button);

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', ''));

    $sform->display();
}

function TPSaveAddTp($typeposte)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTypesPoste = new XentTypesPoste();

    $xentTypesPoste->setTypePosteName($typeposte);

    $xentTypesPoste->add();
}

function TPEditTp()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTypesPoste = new XentTypesPoste();

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
        $typeposte = $xentTypesPoste->getTypePoste($id);

        if (!empty($typeposte['ID_TYPEPOSTE'])) {
            $xentTypesPoste->setIdTypePoste($typeposte['ID_TYPEPOSTE']);

            $xentTypesPoste->setTypePosteName($typeposte['typeposte']);

            $sform = new XoopsThemeForm(_AM_GEN_EDIT . ' - ' . $myts->displayTarea($xentTypesPoste->getTypePosteName()), 'edittypeposte', xoops_getenv('PHP_SELF'));

            $sform->setExtra('enctype="multipart/form-data"');

            $sform->addElement(new XoopsFormText(_AM_GEN_TYPEPOSTE, 'typeposte', 50, 255, $xentTypesPoste->getTypePosteName()));

            $save_button = new XoopsFormButton('', 'add', _AM_GEN_MODIFY, 'submit');

            $save_button->setExtra("onmouseover='document.edittypeposte.op.value=\"TPSaveEditTp\"'");

            $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_DELETE, 'submit');

            $cancel_button->setExtra("onmouseover='document.edittypeposte.op.value=\"TPAreYouSureToDeleteTp\"'");

            $button_tray = new XoopsFormElementTray('', '');

            $button_tray->addElement($save_button);

            $button_tray->addElement($cancel_button);

            $sform->addElement($button_tray);

            $sform->addElement(new XoopsFormHidden('id', $xentTypesPoste->getIdTypePoste()));

            $sform->addElement(new XoopsFormHidden('op', ''));

            $sform->display();
        }
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function TPSaveEditTp($id, $typeposte)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTypesPoste = new XentTypesPoste();

    $xentTypesPoste->setIdTypePoste($id);

    $xentTypesPoste->setTypePosteName($typeposte);

    $xentTypesPoste->update();
}

function TPAreYouSureToDeleteTp($id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    $xentTypesPoste = new XentTypesPoste();

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $typeposte = $xentTypesPoste->getTypePoste($id);

    if (!empty($typeposte['ID_TYPEPOSTE'])) {
        $sform = new XoopsThemeForm(_AM_GEN_AREYOUSUREDELETE, 'deltypeposte', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(new XoopsFormLabel(_AM_GEN_TYPEPOSTE, $myts->displayTarea($typeposte['typeposte'])));

        $delete_button = new XoopsFormButton('', 'add', _AM_GEN_DELETE, 'submit');

        $delete_button->setExtra("onmouseover='document.deltypeposte.op.value=\"TPDeleteTp\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.deltypeposte.op.value=\"TPEditTp\"'");

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

function TPDeleteTp($id)
{
    $xentTypesPoste = new XentTypesPoste();

    $xentTypesPoste->delete($id);
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

switch ($op) {
    case 'TPAddTp':
        TPAddTp();
        break;
    case 'TPSaveAddTp':
        TPSaveAddTp($typeposte);
        break;
    case 'TPEditTp':
        TPEditTp();
        break;
    case 'TPSaveEditTp':
        TPSaveEditTp($id, $typeposte);
        break;
    case 'TPAreYouSureToDeleteTp':
        TPAreYouSureToDeleteTp($id);
        break;
    case 'TPDeleteTp':
        TPDeleteTp($id);
        break;
    default:
        TPShowTp();
        break;
}

// *************************** Fin de NTS **********************************

buildTypesPosteActionMenu();

CloseTable();

xoops_cp_footer();
