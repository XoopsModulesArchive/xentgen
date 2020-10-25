<?php

require __DIR__ . '/admin_header.php';

require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

xoops_cp_header();
echo $oAdminButton->renderButtons('options');

function reference_job()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $fct1 = 'xent_gen_reference';    //table ds la bd
    $fct2 = 'reference_job';       //champ ds la bd
    $fct3 = 'id';    //id du champ
    $fct4 = '';

    $status = '';

    OpenTable();

    echo _AM_XENT_CR_REFERENCE;

    //ADD ENTRY

    echo "<form action='options.php' method='post'>
<input type='text' name='entry' size='34' maxlength='255'>

<input type='hidden' name='op' value='ADDOPTIONS'><br><br>";

    echo "

<input type='hidden' name='fct1' value='" . $fct1 . "'>
<input type='hidden' name='fct2' value='" . $fct2 . "'>
<input type='hidden' name='fct3' value='" . $fct3 . "'>
<input type='hidden' name='fct4' value='" . $fct4 . "'>
<input type='hidden' name='status' value=''>
<input type='submit' value='" . _AM_XENT_CR_ADD . "'>

";

    echo '</form>';

    CloseTable();

    echo '<br>';

    OpenTable();

    echo '<br>';

    //EDIT OR DELETE ENTRY

    echo "<form action='options.php' method='post' name='options'>";

    echo '<select name="entryid">';

    $result = $xoopsDB->query('SELECT id, reference_job FROM ' . $xoopsDB->prefix('xent_gen_reference') . ' ORDER BY id');

    $myts = MyTextSanitizer::getInstance();

    while (list($titres_id, $titres) = $xoopsDB->fetchRow($result)) {
        $titres = htmlspecialchars($titres, ENT_QUOTES | ENT_HTML5);

        echo "<option value='" . $titres_id . "'>" . $titres . '</option>';
    }

    echo '</select>';

    //echo "<br>";

    echo '<input type="hidden" name="fct1" value="' . $fct1 . '">
			  <input type="hidden" name="fct2" value="' . $fct2 . '">
			  <input type="hidden" name="fct3" value="' . $fct3 . '">
              <input type="hidden" name=ok" value="0">
              <input type="hidden" name="op" id="op" value="">
              <input type="hidden" name="fct4" value="' . $fct4 . '">
 			  <input type="hidden" name="status" value="">
              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPEDIT . '" onclick=document.forms["options"].op.value="EDITOPTIONS">
              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPDELETE . '" onclick=document.forms["options"].op.value="DELETEOPTIONS">
              ';

    echo '</form>';

    CloseTable();
}

function titres()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $fct1 = 'xent_gen_titres';    //table ds la bd
    $fct2 = 'titres';       //champ ds la bd
    $fct3 = 'id_titres';    //id du champ
    $fct4 = 'description';

    $status = 'status';

    OpenTable();

    echo _AM_XENT_CR_TITRE;

    //ADD ENTRY

    echo "<form action='options.php' method='post'>
<input type='text' name='entry' size='34' maxlength='255'>

<input type='hidden' name='op' value='ADDOPTIONS'><br><br>";

    echo _AM_XENT_CR_DESCRIPTION;

    echo "<br><textarea name='entrydesc' cols='34' rows='6'></textarea><br><br>
<input type='checkbox' name='status' value='1' checked> " . _AM_XENT_CR_AFFICHE . "
<input type='hidden' name='fct1' value='" . $fct1 . "'>
<input type='hidden' name='fct2' value='" . $fct2 . "'>
<input type='hidden' name='fct3' value='" . $fct3 . "'>
<input type='hidden' name='fct4' value='" . $fct4 . "'>
<input type='submit' value='" . _AM_XENT_CR_ADD . "'>

";

    echo '</form>';

    CloseTable();

    echo '<br>';

    OpenTable();

    echo '<br>';

    //EDIT OR DELETE ENTRY

    echo "<form action='options.php' method='post' name='options'>";

    echo '<select name="entryid">';

    $result = $xoopsDB->query('SELECT id_titres, titres FROM ' . $xoopsDB->prefix('xent_gen_titres') . ' ORDER BY id_titres');

    $myts = MyTextSanitizer::getInstance();

    while (list($titres_id, $titres) = $xoopsDB->fetchRow($result)) {
        $titres = htmlspecialchars($titres, ENT_QUOTES | ENT_HTML5);

        echo "<option value='" . $titres_id . "'>" . $titres . '</option>';
    }

    echo '</select>';

    //echo "<br>";

    echo '<input type="hidden" name="fct1" value="' . $fct1 . '">
			  <input type="hidden" name="fct2" value="' . $fct2 . '">
			  <input type="hidden" name="fct3" value="' . $fct3 . '">
              <input type="hidden" name="fct4" value="' . $fct4 . '">
 			  <input type="hidden" name="status" value="">
              <input type="hidden" name=ok" value="0">
              <input type="hidden" name="op" id="op" value="">

              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPEDIT . '" onclick=document.forms["options"].op.value="EDITOPTIONS">
              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPDELETE . '" onclick=document.forms["options"].op.value="DELETEOPTIONS">
              ';

    echo '</form>';

    CloseTable();
}

function locations()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $fct1 = 'xent_gen_locations';

    $fct2 = 'locations';

    $fct3 = 'id_locations';

    $fct4 = '';

    $status = '';

    OpenTable();

    echo _AM_XENT_CR_LOCATIONS;

    //ADD ENTRY

    echo "<form action='options.php' method='post'>
<input type='text' name='entry' size='34' maxlength='255'>
<input type='hidden' name='fct1' value='" . $fct1 . "'>
<input type='hidden' name='fct2' value='" . $fct2 . "'>
<input type='hidden' name='fct3' value='" . $fct3 . "'>
<input type='hidden' name='fct4' value=''>
<input type='hidden' name='status' value=''>
<input type='hidden' name='entrydesc' value=''>

<input type='hidden' name='op' value='ADDOPTIONS'><input type='submit' value='" . _AM_XENT_CR_ADD . "'>";

    echo '</form>';

    echo '<br>';

    //EDIT OR DELETE ENTRY

    echo "<form action='options.php' method='post' name='options'>";

    echo '<select name="entryid">';

    $result = $xoopsDB->query('SELECT id_locations, locations FROM ' . $xoopsDB->prefix('xent_gen_locations') . ' ORDER BY id_locations');

    $myts = MyTextSanitizer::getInstance();

    while (list($locations_id, $locations) = $xoopsDB->fetchRow($result)) {
        $locations = htmlspecialchars($locations, ENT_QUOTES | ENT_HTML5);

        echo "<option value='" . $locations_id . "'>" . $locations . '</option>';
    }

    echo '</select>';

    // echo "<br>";

    echo '<input type="hidden" name="fct1" value="' . $fct1 . '">
			  <input type="hidden" name="fct2" value="' . $fct2 . '">
			  <input type="hidden" name="fct3" value="' . $fct3 . '">
              <input type="hidden" name="fct4" value="">
              <input type="hidden" name=ok" value="0">
              <input type="hidden" name="op" id="op" value="">
			  <input type="hidden" name="status" value="">
              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPEDIT . '" onclick=document.forms["options"].op.value="EDITOPTIONS">
              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPDELETE . '" onclick=document.forms["options"].op.value="DELETEOPTIONS">
              ';

    echo '</form>';

    CloseTable();
}

function status()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $fct1 = 'xent_gen_status';

    $fct2 = 'status';

    $fct3 = 'id_status';

    $fct4 = '';

    $status = '';

    OpenTable();

    echo _AM_XENT_CR_STATUS;

    //ADD ENTRY

    echo "<form action='options.php' method='post'>
<input type='text' name='entry' size='34' maxlength='255'>
<input type='hidden' name='fct1' value='" . $fct1 . "'>
<input type='hidden' name='fct2' value='" . $fct2 . "'>
<input type='hidden' name='fct3' value='" . $fct3 . "'>
<input type='hidden' name='status' value=''>
<input type='hidden' name='fct4' value=''>
<input type='hidden' name='entrydesc' value=''>
<input type='hidden' name='op' value='ADDOPTIONS'><input type='submit' value='" . _AM_XENT_CR_ADD . "'>";

    echo '</form>';

    echo '<br>';

    //EDIT OR DELETE ENTRY

    echo "<form action='options.php' method='post' name='options'>";

    echo '<select name="entryid">';

    $result = $xoopsDB->query('SELECT id_status, status FROM ' . $xoopsDB->prefix('xent_gen_status') . ' ORDER BY id_status');

    $myts = MyTextSanitizer::getInstance();

    while (list($status_id, $status) = $xoopsDB->fetchRow($result)) {
        $status = htmlspecialchars($status, ENT_QUOTES | ENT_HTML5);

        echo "<option value='" . $status_id . "'>" . $status . '</option>';
    }

    echo '</select>';

    //  echo "<br>";

    echo '<input type="hidden" name="fct1" value="' . $fct1 . '">
			  <input type="hidden" name="fct2" value="' . $fct2 . '">
			  <input type="hidden" name="fct3" value="' . $fct3 . '">
              <input type="hidden" name="fct4" value="">
 			  <input type="hidden" name="status" value="">
              <input type="hidden" name=ok" value="0">
              <input type="hidden" name="op" id="op" value="">

              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPEDIT . '" onclick=document.forms["options"].op.value="EDITOPTIONS">
              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPDELETE . '" onclick=document.forms["options"].op.value="DELETEOPTIONS">
              ';

    echo '</form>';

    CloseTable();
}

function typeposte()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    $fct1 = 'xent_gen_typeposte';

    $fct2 = 'typeposte';

    $fct3 = 'id_typeposte';

    $fct4 = '';

    $status = '';

    OpenTable();

    echo _AM_XENT_CR_TYPEPOSTE;

    //ADD ENTRY

    echo "<form action='options.php' method='post'>
<input type='text' name='entry' size='34' maxlength='255'>
<input type='hidden' name='fct1' value='" . $fct1 . "'>
<input type='hidden' name='fct2' value='" . $fct2 . "'>
<input type='hidden' name='fct3' value='" . $fct3 . "'>
<input type='hidden' name='fct4' value=''>
<input type='hidden' name='status' value=''>
<input type='hidden' name='entrydesc' value=''>
<input type='hidden' name='op' value='ADDOPTIONS'><input type='submit' value='" . _AM_XENT_CR_ADD . "'>";

    echo '</form>';

    echo '<br>';

    //EDIT OR DELETE ENTRY

    echo "<form action='options.php' method='post' name='options'>";

    echo '<select name="entryid">';

    $result = $xoopsDB->query('SELECT id_typeposte, typeposte FROM ' . $xoopsDB->prefix('xent_gen_typeposte') . ' ORDER BY id_typeposte');

    $myts = MyTextSanitizer::getInstance();

    while (list($typeposte_id, $typeposte) = $xoopsDB->fetchRow($result)) {
        $typeposte = htmlspecialchars($typeposte, ENT_QUOTES | ENT_HTML5);

        echo "<option value='" . $typeposte_id . "'>" . $typeposte . '</option>';
    }

    echo '</select>';

    //echo "<br>";

    echo '<input type="hidden" name="fct1" value="' . $fct1 . '">
			  <input type="hidden" name="fct2" value="' . $fct2 . '">
			  <input type="hidden" name="fct3" value="' . $fct3 . '">
              <input type="hidden" name="fct4" value="">
 			  <input type="hidden" name="status" value="">
              <input type="hidden" name=ok" value="0">
              <input type="hidden" name="op" id="op" value="">

              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPEDIT . '" onclick=document.forms["options"].op.value="EDITOPTIONS">
              <input type="submit" class="formButton" name="" id="" value="' . _AM_XENT_CR_OPDELETE . '" onclick=document.forms["options"].op.value="DELETEOPTIONS">
              ';

    echo '</form>';

    CloseTable();
}

function DELETEOPTIONS($entryid, $fct1, $fct2, $fct3, $ok = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $myts;

    global $xoopsDB, $xoopsConfig, $xoopsModule;

    if (1 == $ok) {
        $xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix($fct1) . ' WHERE ' . $fct3 . "=$entryid");

        redirect_header('options.php?op=' . $fct2, 1, _AM_PGSA_DBUPDATED);

        exit();
    }  

    OpenTable();

    $result = $xoopsDB->query('SELECT ' . $fct3 . ', ' . $fct2 . ' FROM ' . $xoopsDB->prefix($fct1) . ' WHERE ' . $fct3 . "=$entryid");

    [$entryid, $entry] = $xoopsDB->fetchRow($result);

    $entry = htmlspecialchars($entry, ENT_QUOTES | ENT_HTML5);

    echo '<big><b>' . _AM_PGSA_TITLE . '</big></b>';

    echo "<h4 style='text-align:left;'>" . _AM_XENT_CR_DELETECONFIRM . "</h4>
                <form action='options.php' method='post'>
                <input type='hidden' name='entryid' value='$entryid'>
                <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
                        <tr>
                        <td class='bg2'>
                        <table width='100%' valign='top' border='0' cellpadding='4' cellspacing='1'>
                                <tr>
                                <td class='bg3' width='30%'><b>" . _AM_XENT_CR_OPTIONS . "</b></td>
                                <td class='bg1'>" . $entry . '</td>
                                </tr>
                        </table>
                        </td>
                        </tr>
                </table>
                </form>';

    echo "<table valign='top'><tr>";

    echo "<td width='30%' valign='top'><span style='color:#ff0000;'><b>" . _AM_XENT_CR_WANTDEL . '</b></span></td>';

    echo "<td width='3%'>\n";

    echo myTextForm("options.php?op=DELETEOPTIONS&entryid=$entryid&fct1=$fct1&fct2=$fct2&fct3=$fct3&ok=1", _AM_XENT_CR_YES);

    echo "</td><td>\n";

    echo myTextForm('options.php?op=' . $fct2, _AM_XENT_CR_NO);

    echo "</td></tr></table>\n";

    CloseTable();
}

function ADDOPTIONS($entry, $entrydesc, $fct1, $fct2, $fct3, $fct4, $status)
{
    global $xoopsDB, $eh, $myts;

    $entry = $myts->addSlashes($entry);

    $newid = '0';

    //$newid = $xoopsDB->genId($xoopsDB->prefix($fct1)."_id_table_seq");

    if ('' == $fct4) {
        $sql = sprintf('INSERT INTO %s (' . $fct3 . ', ' . $fct2 . ") VALUES (%u, '%s')", $xoopsDB->prefix($fct1), $newid, $entry);
    } else {
        //echo "CECI EST UN ECHO0";

        if ('' == $status) {
            $status = 0;

        //echo "CECI EST UN ECHO1 :";
            //echo $status;
        } else {
            $status = (int)$status;

            //echo "CECI EST UN ECHO2 :";

            echo $status;
        }

        $description = ', ' . $fct4 . ', status';

        $sql = sprintf('INSERT INTO %s (' . $fct3 . ', ' . $fct2 . $description . ") VALUES (%u, '%s', '%s', '%u')", $xoopsDB->prefix($fct1), $newid, $entry, $entrydesc, $status);
    }

    //echo ($sql);

    $xoopsDB->query($sql) or $eh::show('0013');

    // Si y'a pas d'erreurs ds la requete ci dessus, on redirige vers la page d'accueil ADMIN

    redirect_header('options.php?op=' . $fct2, 1, _AM_XENT_CR_DBUPDATED);

    exit();
}

function EDITOPTIONS($entryid, $fct1, $fct2, $fct3, $fct4)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    if ('' == $fct4) {
        $description = '';
    } else {
        $description = ', ' . $fct4 . ', status';
    }

    $result = $xoopsDB->query('SELECT ' . $fct3 . ', ' . $fct2 . $description . ' FROM ' . $xoopsDB->prefix($fct1) . ' WHERE ' . $fct3 . "=$entryid");

    if ('' == $fct4) {
        [$entryid, $entry] = $xoopsDB->fetchRow($result);
    } else {
        [$entryid, $entry, $entrydesc, $status] = $xoopsDB->fetchRow($result);
    }

    $myts = MyTextSanitizer::getInstance();

    $entry = htmlspecialchars($entry, ENT_QUOTES | ENT_HTML5);

    OpenTable();

    echo '<big><b>' . _AM_XENT_CR_TITLE . "</big></b>
        <h4 style='text-align:left;'>" . _AM_XENT_CR_EDITMENUITEM . "</h4>
        <form action='options.php' method='post'>

        <table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
        <tr>
        <td class='bg2'>
                <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr>
                <td class='bg3'><b>" . _AM_XENT_CR_NAME . "</b></td>
                <td class='bg1'>
                	<input type='text' name='entry' size='50' maxlength='255' value='$entry'><br><br>
                    ";

    if ('' == $fct4) {
    } else {
        if (1 == $status) {
            $Checked = 'checked';
        } else {
            $Checked = '';
        }

        echo "<textarea name='entrydesc' cols='34' rows='6'>$entrydesc</textarea><br><br>";

        echo "<input type='checkbox' name='status' value='1' " . $Checked . '> ' . _AM_XENT_CR_AFFICHE;
    }

    //echo "<textarea name='entrydesc' cols='34' rows='6'>$entrydesc</textarea>";

    echo "</td>
                </tr>


                <tr>
                <td class='bg3'>&nbsp;</td>
                <td class='bg1'>
                <input type='hidden' name='entryid' value='" . $entryid . "'>
                <input type='hidden' name='fct1' value='" . $fct1 . "'>
			    <input type='hidden' name='fct2' value='" . $fct2 . "'>
			    <input type='hidden' name='fct3' value='" . $fct3 . "'>
                <input type='hidden' name='fct4' value='" . $fct4 . "'>
                <input type='hidden' name='op' value='SAVEOPTIONS'>
                <input type='submit' value='" . _AM_XENT_CR_SAVE . "'></td>
                </tr>
                </table>
        </td>
        </tr>
        </table>

        </form>";

    CloseTable();
}

function SAVEOPTIONS($entryid, $entrydesc, $entry, $fct1, $fct2, $fct3, $fct4, $status)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $entry = $myts->addSlashes(trim($entry));

    //$xoopsDB->query("UPDATE ".$xoopsDB->prefix($fct1)." SET ".$fct2."='$entry' WHERE ".$fct3."=$entryid");

    if ('' == $fct4) {
        $xoopsDB->query('UPDATE ' . $xoopsDB->prefix($fct1) . ' SET ' . $fct2 . "='$entry' WHERE " . $fct3 . "=$entryid");
    } else {
        if (empty($status)) {
            $status = 0;
        } else {
            $status = (int)$status;
        }

        $sql = 'UPDATE ' . $xoopsDB->prefix($fct1) . " SET $fct2='$entry', $fct4='$entrydesc', status='$status' WHERE $fct3=$entryid";

        //echo $sql;

        $xoopsDB->query($sql);
    }

    /*
            echo "<br>1-";
            echo $fct1;
            echo "<br>2-";
            echo $fct2;
            echo "<br>3-";
            echo $fct3;
            echo "<br>4-";
            echo $entry;
            echo "<br>5-";
            echo $entryid;*/

    redirect_header('options.php?op=' . $fct2, 1, _AM_XENT_CR_DBUPDATED);

    exit();
}

function admin()
{
    OpenTable();

    echo "<br><a href='options.php?op=titres'>" . _AM_XENT_CR_TITRE . '</a>
              <br>' . _AM_XENT_CR_LOCATIONS . '</a>
              <br>' . _AM_XENT_CR_STATUS . '</a>
              <br>' . _AM_XENT_CR_TYPEPOSTE . "</a><br><br>
              <a href='options.php?op=reference'><br>" . _AM_XENT_CR_REFERENCE . '</a><br><br>';

    CloseTable();

    echo '<br>';
}

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

//echo "Ceci est un test : ".$_POST['status'];

switch ($op) {
    case 'reference':
        reference_job();
        break;
    case 'titres':
        titres();
        break;
    case 'typeposte':
        typeposte();
        break;
    case 'locations':
        locations();
        break;
    case 'status':
        status();
        break;
    case 'ADDOPTIONS':
        ADDOPTIONS($entry, $entrydesc, $fct1, $fct2, $fct3, $fct4, $status);
        break;
    case 'DELETEOPTIONS':
        DELETEOPTIONS($entryid, $fct1, $fct2, $fct3, $status, $ok);
        break;
    case 'EDITOPTIONS':
        EDITOPTIONS($entryid, $fct1, $fct2, $fct3, $fct4, $status);
        break;
    case 'SAVEOPTIONS':
        SAVEOPTIONS($entryid, $entrydesc, $entry, $fct1, $fct2, $fct3, $fct4, $status);
        break;
    //case "delok":
    //      delok($fct3, $ok);
    //    break;
    default:
        admin();
        break;
}
xoops_cp_footer();
