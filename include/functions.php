<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xentfunctions.php';

function makeImageWhereToDisplayArray()
{
    $arr = [];

    $arr[0] = _AM_GEN_IMAGEWHERETODISPLAYEDOPT0;

    $arr[1] = _AM_GEN_IMAGEWHERETODISPLAYEDOPT1;

    $arr[2] = _AM_GEN_IMAGEWHERETODISPLAYEDOPT2;

    return $arr;
}

//    function makeNoYesArray(){
//    	$arr = array();
//
//        $arr[0] = _AM_GEN_NO;
//        $arr[1] = _AM_GEN_YES;
//
//        return $arr;
//    }

function buildAlphabeticalSearch()
{
    echo "<center>|&nbsp;<a href='adminusers.php'>Tous</a>&nbsp;|";

    for ($x = 65; $x <= 90; $x++) {
        echo "&nbsp;<a href='adminusers.php?sort=" . chr($x) . "'>" . chr($x) . '</a>&nbsp|';
    }

    echo '</center>';
}

function buildUsersActionMenu()
{
    echo "<br><div class='adminActionMenu'><a href=adminusers.php class='adminActionMenu'>" . _AM_GEN_ADMINUSERSTITLE . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo "<a href=adminusers.php?op=USERSImportShow class='adminActionMenu'>" . _AM_GEN_IMPORT . '</a></div>';
}

function buildJobsActionMenu()
{
    echo "<br><div class='adminActionMenu'><a href=adminjobs.php class='adminActionMenu'>" . _AM_GEN_ADMINJOBSTITLE . '</a></div>';
}

function buildTitlesActionMenu()
{
    echo "<br><div class='adminActionMenu'><a href=admintitles.php class='adminActionMenu'>" . _AM_GEN_ADMINTITLESTITLE . '</a></div>';
}

function buildTypesPosteActionMenu()
{
    echo "<br><div class='adminActionMenu'><a href=admintypesposte.php class='adminActionMenu'>" . _AM_GEN_ADMINTYPESPOSTETITLE . '</a></div>';
}

function buildLocationsActionMenu()
{
    echo "<br><div class='adminActionMenu'><a href=adminlocations.php class='adminActionMenu'>" . _AM_GEN_ADMINLOCATIONSTITLE . '</a></div>';
}
