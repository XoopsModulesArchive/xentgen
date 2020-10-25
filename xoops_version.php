<?php
// ------------------------------------------------------------------------- //
//                  Module xentGen pour Xoops 2.0.7                     //
//                              Version:  1.0                                //
// ------------------------------------------------------------------------- //
// Author: Milhouse                                        				     //
// Purpose:                           				     //
// email: hotkart@hotmail.com                                                //
// URLs:                      												 //
//---------------------------------------------------------------------------//
global $xoopsModuleConfig;
require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';
$modversion['name'] = _MI_GEN_NAME;
$modversion['version'] = '1.0';
$modversion['description'] = _MI_GEN_DESC;
$modversion['credits'] = 'M4D3L, marcan and i might forget some people';
$modversion['author'] = 'Ecrit pour Xoops2<br>par Alexandre Parent (Milhouse)';
$modversion['license'] = '';
$modversion['official'] = 1;
$modversion['image'] = 'images/xent_gen_logo.png';
$modversion['help'] = '';
$modversion['dirname'] = 'xentgen';

// MYSQL FILE
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file
//If you hack this modules, dont change the order of the table.
//All
$modversion['tables'][0] = 'xent_gen_users';
$modversion['tables'][1] = 'xent_gen_titles';
$modversion['tables'][2] = 'xent_gen_jobs';
$modversion['tables'][3] = 'xent_gen_locations';
$modversion['tables'][4] = 'xent_gen_typeposte';
$modversion['tables'][5] = 'xent_gen_expertise_cat';
//$modversion['tables'][6] = "xent_gen_expertise_cat_lang";
$modversion['tables'][7] = 'xent_gen_expertise_item';
//$modversion['tables'][8] = "xent_gen_expertise_lang";
$modversion['tables'][9] = 'xent_gen_expertise_link_users';
$modversion['tables'][10] = 'xent_gen_techskill_cat';
//$modversion['tables'][11] = "xent_gen_techskill_cat_lang";
$modversion['tables'][12] = 'xent_gen_techskill_item';
//$modversion['tables'][13] = "xent_gen_techskill_lang";
$modversion['tables'][14] = 'xent_gen_techskill_link_users';

$modversion['onInstall'] = 'include/installscript.php';
//$modversion['onUninstall'] = 'include/uninstallscript.php';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 0;

$modversion['config'][1]['name'] = 'image_upload_dir';
$modversion['config'][1]['title'] = '_MI_GEN_CONFIG_IMGUD';
$modversion['config'][1]['description'] = '_MI_GEN_CONFIG_IMGUDDESC';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = '';

$modversion['config'][2]['name'] = 'image_extension';
$modversion['config'][2]['title'] = '_MI_GEN_CONFIG_IMGEXT';
$modversion['config'][2]['description'] = '_MI_GEN_CONFIG_IMGEXTDESC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = 'image/gif;image/pjpeg;image/x-png';

$modversion['config'][3]['name'] = 'max_file_size';
$modversion['config'][3]['title'] = '_MI_GEN_CONFIG_MAXFILESIZE';
$modversion['config'][3]['description'] = '_MI_GEN_CONFIG_EXPERTISETEXTD';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'text';
$modversion['config'][3]['default'] = '250000';

$modversion['config'][4]['name'] = 'debug';
$modversion['config'][4]['title'] = '_MI_GEN_CONFIG_DEBUG';
$modversion['config'][4]['description'] = '_MI_GEN_CONFIG_DEBUGDESC';
$modversion['config'][4]['formtype'] = 'yesno';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = '0';

$modversion['config'][5]['name'] = 'display_location';
$modversion['config'][5]['title'] = '_MI_GEN_CONFIG_DISPLOC';
$modversion['config'][5]['description'] = '_MI_GEN_DISPLOC_DEBUGDESC';
$modversion['config'][5]['formtype'] = 'select';
$modversion['config'][5]['valuetype'] = 'int';
$modversion['config'][5]['options'] = [_MI_GEN_CONFIG_DISPLOC_VILLEPROVINCE => '1', _MI_GEN_CONFIG_DISPLOC_VILLEPAYS => '2', _MI_GEN_CONFIG_DISPLOC_PROVINCEPAYS => '3'];
$modversion['config'][5]['default'] = '1';
