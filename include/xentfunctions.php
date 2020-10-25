<?php
// $haystack = la string dans laquelle on veut chercher
// $needle = ce que l'on veut chercher
// ex : on veut savoir s'il y a une virgule dans une phrase
// 		instr($phrase, ",");
function instr($haystack, $needle, $insensitive = 0)
{
    if ($insensitive) {
        return (false !== mb_stristr($haystack, $needle)) ? true : false;
    }
  

    return (false !== mb_strpos($haystack, $needle)) ? true : false;
}

function getTopic($fct1, $fct2, $fct3, $order = '')
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $sql = 'SELECT ' . $fct3 . ', ' . $fct2 . ' FROM ' . $xoopsDB->prefix($fct1) . ' ';

    if (!empty($order)) {
        $sql .= 'ORDER BY ' . $order;
    }

    $result = $xoopsDB->query($sql);

    $thearray = [];

    while (false !== ($topic = $xoopsDB->fetchArray($result))) {
        $theid = htmlspecialchars($topic[$fct3], ENT_QUOTES | ENT_HTML5);

        $thename = htmlspecialchars($topic[$fct2], ENT_QUOTES | ENT_HTML5);

        $thearray[$theid] = $thename;
    }

    return $thearray;
}

// retourne le fct2 pour un id = fct3 donné dans la table fct1
function reference($fct1, $fct2, $fct3, $id)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $sql = 'SELECT ' . $fct3 . ', ' . $fct2 . ' FROM ' . $xoopsDB->prefix($fct1) . ' WHERE ' . $fct3 . "=$id";

    $result = $xoopsDB->query($sql);

    [$id, $champs] = $xoopsDB->fetchRow($result);

    $titres = $myts->displayTarea($champs);

    return $titres;
}

function makeSelect($caption, $name, $selected, $arrayOptions, $linesDisplayed = 1, $idMatters = 0, $multiple = false)
{
    $select = new XoopsFormSelect($caption, $name, $selected, $linesDisplayed, $multiple);

    if (1 == $idMatters) {
        $select->addOption(0, '---');
    }

    $select->addOptionArray($arrayOptions);

    return $select;
}

// exemple d'utilisation : if (uploadFile(XOOPS_ROOT_PATH.$xoopsModuleConfig['image_upload_dir'], explode(";", $xoopsModuleConfig['image_extension']), $xoopsModuleConfig['max_file_size'], $_POST["xoops_upload_file"][0]) === true){}
function uploadFile($dir, $allowedMimeTypes, $maxfilesize, $uploadedFile)
{
    require_once XOOPS_ROOT_PATH . '/class/uploader.php';

    $uploader = new XoopsMediaUploader($dir, $allowedMimeTypes, $maxfilesize, null, null);

    if (!empty($_FILES[$uploadedFile]['name'])) {
        if (file_exists($dir . '/' . $_FILES[$uploadedFile]['name'])) {
            // un fichier existe déja avec ce nom; à cet emplacement

            unlink($dir . '/' . $_FILES[$uploadedFile]['name']);
        }
    }

    if (!empty($uploadedFile) || '' != $uploadedFile) {
        if (('' == $_FILES[$uploadedFile]['tmp_name'] || !is_readable($_FILES[$uploadedFile]['tmp_name']))) {
            // ici on retourne true parce qu'il n'y a rien ans la boîte texte

            // Le champ n'est pas obligatoire donc le champ vide est accepté

            return false;
        }  

        if ($uploader->fetchMedia($uploadedFile) && $uploader->upload($uploadedFile)) {
            chmod($dir . '/' . $_FILES[$uploadedFile]['name'], 0755);

            return true;
        }  

        $uploader->getErrors();

        // Erreur dans le type du fichier ou

        // le fichier est trop grand

        return false;
    }
}

function makeNoYesArray()
{
    $arr = [];

    $arr[0] = _AM_XENT_NO;

    $arr[1] = _AM_XENT_YES;

    return $arr;
}

function convertIntBinIntoText($int)
{
    if (0 == $int) {
        return _AM_XENT_NO;
    } elseif (1 == $int) {
        return _AM_XENT_YES;
    }
}
