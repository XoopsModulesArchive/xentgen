<?php

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('adminlocations');

OpenTable();
echo "<div class='adminHeader'>" . _AM_GEN_ADMINLOCATIONSTITLE . '</div><br>';

function LOCATIONSShowLocations()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentLocations = new XentLocations();

    $myts = MyTextSanitizer::getInstance();

    $result = $xentLocations->getAllLocations();

    echo "<div align='right' class='adminActionMenu'><a href='adminlocations.php?op=LOCATIONSAddLocation'>" . _AM_GEN_ADDLOCATION . '</a></div>';

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
                    <th>" . _AM_GEN_NAME . '</th>
                    <th>' . _AM_GEN_OPTIONS . '</th>
                </tr>';

    while (false !== ($locations = $xoopsDB->fetchArray($result))) {
        $xentLocations->setIdLocation($locations['ID_LOCATION']);

        $xentLocations->setAddress($locations['address']);

        $xentLocations->setCity($locations['city']);

        $xentLocations->setState($locations['state']);

        $xentLocations->setCountry($locations['country']);

        $xentLocations->setZipCode($locations['zipcode']);

        echo "
            	<tr>
                    <td class='even'>" . $myts->displayTarea($xentLocations->getAddress()) . '<br>' . $myts->displayTarea($xentLocations->getCity());

        $tmp = $myts->displayTarea($xentLocations->getState());

        if (!empty($tmp)) {
            echo ', ' . $myts->displayTarea($xentLocations->getState());
        }

        echo ', ' . $myts->displayTarea($xentLocations->getCountry()) . '<br>' . $myts->displayTarea($xentLocations->getZipCode()) . "</td>
                    <td class='even'><a href='adminlocations.php?op=LOCATIONSEditLocation&id=" . $locations['ID_LOCATION'] . "'>" . _AM_GEN_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function LOCATIONSAddLocation()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentLocations = new XentLocations();

    $myts = MyTextSanitizer::getInstance();

    if (!empty($_GET['address'])) {
        $xentLocations->setAddress($_GET['address']);
    } else {
        $xentLocations->setAddress('[fr][/fr][en][/en]');
    }

    if (!empty($_GET['city'])) {
        $xentLocations->setCity($_GET['city']);
    } else {
        $xentLocations->setCity('[fr][/fr][en][/en]');
    }

    if (!empty($_GET['state'])) {
        $xentLocations->setState($_GET['state']);
    } else {
        $xentLocations->setState('[fr][/fr][en][/en]');
    }

    if (!empty($_GET['country'])) {
        $xentLocations->setCountry($_GET['country']);
    } else {
        $xentLocations->setCountry('CA');
    }

    if (!empty($_GET['zipcode'])) {
        $xentLocations->setZipCode($_GET['zipcode']);
    } else {
        $xentLocations->setZipCode('');
    }

    $sform = new XoopsThemeForm(_AM_GEN_ADDLOCATION, 'addlocation', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText(_AM_GEN_ADDRESS, 'address', 50, 255, $xentLocations->getAddress()), true);

    $sform->addElement(new XoopsFormText(_AM_GEN_CITY, 'city', 50, 255, $xentLocations->getCity()), true);

    $sform->addElement(new XoopsFormText(_AM_GEN_STATE, 'state', 50, 255, $xentLocations->getState()), false);

    $country_select = new XoopsFormSelectCountry(_AM_GEN_COUNTRY, 'country_select', $xentLocations->getCountryCode(), 1);

    $country_select->setExtra("onChange='document.addlocation.country.value=document.addlocation.country_select.options[document.addlocation.country_select.selectedIndex].value'");

    $sform->addElement($country_select, true);

    $sform->addElement(new XoopsFormText(_AM_GEN_ZIPCODE, 'zipcode', 10, 10, $xentLocations->getZipCode()), true);

    $save_button = new XoopsFormButton('', 'add', _AM_GEN_ADD, 'submit');

    $save_button->setExtra("onmouseover='document.addlocation.op.value=\"LOCATIONSSaveAddLocation\"'");

    $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

    $cancel_button->setExtra("onmouseover='document.addlocation.op.value=\"LOCATIONSShowLocations\"'");

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $button_tray->addElement($cancel_button);

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', ''));

    $sform->addElement(new XoopsFormHidden('country', ''));

    $sform->display();
}

function LOCATIONSSaveAddLocation($address, $city, $state, $country, $zipcode)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentLocations = new XentLocations();

    $xentLocations->setAddress($address);

    $xentLocations->setCity($city);

    $xentLocations->setState($state);

    $xentLocations->setCountry($country);

    $xentLocations->setZipCode($zipcode);

    $xentLocations->add();
}

function LOCATIONSEditLocation()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentLocations = new XentLocations();

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
        $location = $xentLocations->getLocation($id);

        if (!empty($location['ID_LOCATION'])) {
            $xentLocations->setIdLocation($location['ID_LOCATION']);

            $xentLocations->setAddress($location['address']);

            $xentLocations->setCity($location['city']);

            $xentLocations->setState($location['state']);

            $xentLocations->setCountry($location['country']);

            $xentLocations->setZipCode($location['zipcode']);

            $sform = new XoopsThemeForm(_AM_GEN_EDIT, 'editlocation', xoops_getenv('PHP_SELF'));

            $sform->setExtra('enctype="multipart/form-data"');

            $sform->addElement(new XoopsFormText(_AM_GEN_ADDRESS, 'address', 50, 255, $xentLocations->getAddress()), true);

            $sform->addElement(new XoopsFormText(_AM_GEN_CITY, 'city', 50, 255, $xentLocations->getCity()), true);

            $sform->addElement(new XoopsFormText(_AM_GEN_STATE, 'state', 50, 255, $xentLocations->getState()), false);

            $country_select = new XoopsFormSelectCountry(_AM_GEN_COUNTRY, 'country_select', $xentLocations->getCountryCode(), 1);

            $country_select->setExtra("onChange='document.editlocation.country.value=document.editlocation.country_select.options[document.editlocation.country_select.selectedIndex].value'");

            $sform->addElement($country_select, true);

            $sform->addElement(new XoopsFormText(_AM_GEN_ZIPCODE, 'zipcode', 10, 10, $xentLocations->getZipCode()), true);

            $save_button = new XoopsFormButton('', 'add', _AM_GEN_MODIFY, 'submit');

            $save_button->setExtra("onmouseover='document.editlocation.op.value=\"LOCATIONSSaveEditLocation\"'");

            $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_DELETE, 'submit');

            $cancel_button->setExtra("onmouseover='document.editlocation.op.value=\"LOCATIONSAreYouSureToDeleteLocation\"'");

            $button_tray = new XoopsFormElementTray('', '');

            $button_tray->addElement($save_button);

            $button_tray->addElement($cancel_button);

            $sform->addElement($button_tray);

            $sform->addElement(new XoopsFormHidden('op', ''));

            $sform->addElement(new XoopsFormHidden('country', ''));

            $sform->addElement(new XoopsFormHidden('id', $xentLocations->getIdLocation()));

            $sform->display();
        }
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function LOCATIONSSaveEditLocation($id, $address, $city, $state, $country, $zipcode)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentLocations = new XentLocations();

    $xentLocations->setIdLocation($id);

    $xentLocations->setAddress($address);

    $xentLocations->setCity($city);

    $xentLocations->setState($state);

    $xentLocations->setCountry($country);

    $xentLocations->setZipCode($zipcode);

    $xentLocations->update();
}

function LOCATIONSAreYouSureToDeleteLocation($id)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    $xentLocations = new XentLocations();

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $location = $xentLocations->getLocation($id);

    if (!empty($location['ID_LOCATION'])) {
        $xentLocations->setIdLocation($location['ID_LOCATION']);

        $xentLocations->setAddress($location['address']);

        $xentLocations->setCity($location['city']);

        $xentLocations->setState($location['state']);

        $xentLocations->setCountry($location['country']);

        $xentLocations->setZipCode($location['zipcode']);

        $sform = new XoopsThemeForm(_AM_GEN_AREYOUSUREDELETE, 'dellocation', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $str = $myts->displayTarea($xentLocations->getAddress()) . "\n" . $myts->displayTarea($xentLocations->getCity());

        $tmp = $myts->displayTarea($xentLocations->getState());

        if (!empty($tmp)) {
            $str .= ', ' . $myts->displayTarea($xentLocations->getState());
        }

        $str .= ', ' . $myts->displayTarea($xentLocations->getCountry()) . "\n" . $myts->displayTarea($xentLocations->getZipCode());

        $sform->addElement(new XoopsFormLabel(_AM_GEN_LOCATION, $myts->displayTarea($str)));

        $delete_button = new XoopsFormButton('', 'add', _AM_GEN_DELETE, 'submit');

        $delete_button->setExtra("onmouseover='document.dellocation.op.value=\"LOCATIONSDeleteLocation\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_GEN_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.dellocation.op.value=\"LOCATIONSEditLocation\"'");

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

function LOCATIONSDeleteLocation($id)
{
    $xentLocations = new XentLocations();

    $xentLocations->delete($id);
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

switch ($op) {
    case 'LOCATIONSAddLocation':
        LOCATIONSAddLocation();
        break;
    case 'LOCATIONSSaveAddLocation':
        LOCATIONSSaveAddLocation($address, $city, $state, $country, $zipcode);
        break;
    case 'LOCATIONSEditLocation':
        LOCATIONSEditLocation();
        break;
    case 'LOCATIONSSaveEditLocation':
        LOCATIONSSaveEditLocation($id, $address, $city, $state, $country, $zipcode);
        break;
    case 'LOCATIONSAreYouSureToDeleteLocation':
        LOCATIONSAreYouSureToDeleteLocation($id);
        break;
    case 'LOCATIONSDeleteLocation':
        LOCATIONSDeleteLocation($id);
        break;
    default:
        LOCATIONSShowLocations();
        break;
}

// *************************** Fin de NTS **********************************

buildLocationsActionMenu();

CloseTable();

xoops_cp_footer();
