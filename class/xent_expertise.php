<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';
$xentExpertise = new XentExpertise();

class XentExpertise
{
    public $alwaysshownitem;

    public $db;

    public $displayitem;

    public $expertise;

    public $idcat;

    public $idcatitem;

    public $iditem;

    public $id_user;

    public $namecat;

    public $namecatitem;

    public $nameitem;

    public $prioritycat;

    public $language;

    public $defaultlang;

    // constructor

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
    }

    // setters

    public function setDefaultLang($defaultlang)
    {
        $this->defaultlang = $defaultlang;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function setAlwaysShownItem($alwaysShowItem)
    {
        $this->alwaysshownitem = $alwaysShowItem;
    }

    public function setDisplayItem($displayItem)
    {
        $this->displayitem = $displayItem;
    }

    public function setExpertise($expertise)
    {
        $this->expertise = $expertise;
    }

    public function setIdCat($idcat)
    {
        $this->idcat = $idcat;
    }

    public function setIdCatItem($idCatItem)
    {
        $this->idcatitem = $idCatItem;
    }

    public function setIdItem($idItem)
    {
        $this->iditem = $idItem;
    }

    public function setIdUser($id)
    {
        $this->id_user = $id;
    }

    public function setNameCat($namecat)
    {
        $this->namecat = $namecat;
    }

    public function setNameCatItem($namecatitem)
    {
        $this->namecatitem = $namecatitem;
    }

    public function setNameItem($nameitem)
    {
        $this->nameitem = $nameitem;
    }

    public function setPriorityCat($priorityCat)
    {
        $this->prioritycat = $priorityCat;
    }

    // getters

    public function getDefaultLang()
    {
        return $this->defaultlang;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getAlwaysShownItem()
    {
        return $this->alwaysshownitem;
    }

    public function getAlwaysShownItemText()
    {
        if (0 == $this->alwaysshownitem) {
            return _AM_TEAM_NO;
        }
  

        return _AM_TEAM_YES;
    }

    public function getDisplayItem()
    {
        return $this->displayitem;
    }

    public function getDisplayItemText()
    {
        if (0 == $this->displayitem) {
            return _AM_TEAM_NO;
        }
  

        return _AM_TEAM_YES;
    }

    public function getExpertise()
    {
        return $this->expertise;
    }

    public function getIdCat()
    {
        return $this->idcat;
    }

    public function getIdCatItem()
    {
        return $this->idcatitem;
    }

    public function getIdItem()
    {
        return $this->iditem;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getNameCat()
    {
        return $this->namecat;
    }

    public function getNameCatItem()
    {
        return $this->namecatitem;
    }

    public function getNameItem()
    {
        return $this->nameitem;
    }

    public function getPriorityCat()
    {
        return $this->prioritycat;
    }

    // methods

    public function addCat($inBatch = 0)
    {
        //global $module_tables;

        $sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_CAT) . " (name, priority) VALUES('" . $this->getNameCat() . "', " . $this->getPriorityCat() . ')';

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                redirect_header('adminexpertise.php', 1, _AM_DBUPDATED);
            } else {
                redirect_header('adminexpertise.php?op=EXPAddCat&name=' . $this->getNameCat() . '&priority=' . $this->getPriorityCat(), 4, $this->db->error());
            }
        }
    }

    public function addItem($inBatch = 0)
    {
        //global $module_tables;

        $sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . " (name, alwaysShown, display, id_expertisecat) VALUES('" . $this->getNameItem() . "', " . $this->getAlwaysShownItem() . ', ' . $this->getDisplayItem() . ', ' . $this->getIdCatItem() . ')';

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                //redirect_header("adminexpertise.php?op=EXPShowItems",1,_AM_DBUPDATED);
            } else {
                redirect_header('adminexpertise.php?op=EXPAddItem&name=' . $this->getNameItem() . '&alwaysshown=' . $this->getAlwaysShownItem() . '&display=' . $this->getDisplayItem() . '&id_expertisecat=' . $this->getIdCatItem(), 4, $this->db->error());
            }
        }
    }

    public function deleteCat($id)
    {
        //global $module_tables;

        if (false === $this->hasCatItems($id)) {
            $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_CAT) . " WHERE ID_EXPERTISECAT=$id";

            $this->db->queryF($sql);

            if (0 == $this->db->errno()) {
                redirect_header('adminexpertise.php', 1, _AM_DBUPDATED);
            } else {
                redirect_header('adminexpertise.php', 4, $this->db->error());
            }
        } else {
            redirect_header('adminexpertise.php', 4, _AM_TEAM_DELETEEXPCATHASITEMS);
        }
    }

    public function deleteItem($id)
    {
        //global $module_tables;

        // delete dans la table des items

        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . " WHERE ID_EXPERTISEITEM=$id";

        $this->db->queryF($sql);

        // delete les les records dans la table de link qui ont cet item.

        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK) . " WHERE ID_EXPERTISEITEM=$id";

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminexpertise.php?op=EXPShowItems', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminexpertise.php?op=EXPShowItems', 4, $this->db->error());
        }
    }

    public function displayCat($idcat)
    {
        //global $module_tables;

        $bool = false;

        // on doit checker si la table link est vide ou non

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK);

        $result = $this->db->query($sql);

        $total_rows = $this->db->getRowsNum($result);

        if (!$total_rows) {
            // ici la table link est vide, on doit seulement se concentrer

            // sur les items alwaysShown

            $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . " WHERE id_expertisecat=$idcat AND alwaysShown=1";
        } else {
            // ici la table link a quelque chose dedans.

            $sql = 'SELECT DISTINCT x2.name FROM '
                   . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK)
                   . ' as x1, '
                   . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM)
                   . " as x2 where (x1.ID_EXPERTISEITEM = x2.ID_EXPERTISEITEM OR x2.alwaysShown = 1) AND x2. id_expertisecat = $idcat AND display = 1";
        }

        $result = $this->db->query($sql);

        $exp_cat = $this->db->fetchArray($result);

        if (empty($exp_cat['name'])) {
            $bool = false;

            return $bool;
            exit;
        }  

        $bool = true;

        return $bool;
        exit;
    }

    public function getAllCat()
    {
        //global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_CAT) . ' ORDER BY priority';

        $result = $this->db->query($sql);

        return $result;
    }

    public function getArrayUserExpertise($id)
    {
        //global $module_tables;

        $arr = [];

        $sql = 'SELECT x1.ID_EXPERTISEITEM, x1.name, x2.ID_USER FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . ' AS x1, ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK) . " AS x2 WHERE x1.ID_EXPERTISEITEM=x2.ID_EXPERTISEITEM AND x2.ID_USER=$id ORDER BY x1.name";

        $result = $this->db->query($sql);

        while (false !== ($expertise = $this->db->fetchArray($result))) {
            $arr[$expertise['ID_EXPERTISEITEM']] = $expertise['ID_EXPERTISEITEM'];
        }

        return $arr;
    }

    public function getAllItems()
    {
        ////global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . ' ORDER BY name';

        $result = $this->db->query($sql);

        return $result;
    }

    public function getCat($idcat)
    {
        //global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_CAT) . " WHERE ID_EXPERTISECAT=$idcat";

        $result = $this->db->query($sql);

        $exp_cat = $this->db->fetchArray($result);

        return $exp_cat;
    }

    public function getFirstIdInCatSelect()
    {
        //global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_CAT) . ' ORDER by name';

        $result = $this->db->query($sql);

        $exp_cat = $this->db->fetchArray($result);

        return $exp_cat['ID_EXPERTISECAT'];
    }

    public function getItem($iditem)
    {
        //global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . " WHERE ID_EXPERTISEITEM=$iditem";

        $result = $this->db->query($sql);

        $exp_item = $this->db->fetchArray($result);

        return $exp_item;
    }

    // for display only : le champ alwaysShown est pris en compte

    public function getItemsForCatInArrayForUser($idcat, $uid)
    {
        //global $module_tables;

        $myts = MyTextSanitizer::getInstance();

        $arr = [];

        // note to self : on doit aller chercher les items qui sont utilisé

        // par les usagers et non seulement que tous les items dans la table

        // items

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK);

        $result = $this->db->query($sql);

        $total_rows = $this->db->getRowsNum($result);

        if (!$total_rows) {
            //$sql = "SELECT * FROM ".$this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM)." WHERE id_expertisecat=$idcat AND alwaysShown=1";
        } else {
            //$sql = "SELECT DISTINCT name FROM xoops_xent_gen_expertise_item as x1, xoops_xent_gen_expertise_link_users as x2 WHERE x1.id_expertisecat=2 AND x1.display=1 AND  x2.ID_USER=2 ORDER BY name";

            $sql = 'SELECT DISTINCT name FROM 
			' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . ' as x1, 
			' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK) . " as x2 
			WHERE 
			x1.ID_EXPERTISEITEM=x2.ID_EXPERTISEITEM AND x1.id_expertisecat=$idcat AND x1.display=1 AND x2.ID_USER=$uid ORDER BY name";

            //echo $sql;
        }

        $result = $this->db->query($sql);

        $count = 0;

        while (false !== ($item = $this->db->fetchArray($result))) {
            $arr[$count] = $myts->displayTarea($item['name']);

            $count++;
        }

        return $arr;
    }

    public function getItemsForCatInArray($idcat)
    {
        //global $module_tables;

        $myts = MyTextSanitizer::getInstance();

        $arr = [];

        // note to self : on doit aller chercher les items qui sont utilisé

        // par les usagers et non seulement que tous les items dans la table

        // items

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK);

        $result = $this->db->query($sql);

        $total_rows = $this->db->getRowsNum($result);

        if (!$total_rows) {
            $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . " WHERE id_expertisecat=$idcat AND alwaysShown=1";
        } else {
            $sql = 'SELECT DISTINCT name FROM '
                   . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM)
                   . ' as x1, '
                   . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK)
                   . " as x2 WHERE x1.id_expertisecat=$idcat AND x1.display=1 AND (x1.ID_EXPERTISEITEM = x2.ID_EXPERTISEITEM OR x1.alwaysShown = 1) ORDER BY name";
        }

        $result = $this->db->query($sql);

        $count = 0;

        while (false !== ($item = $this->db->fetchArray($result))) {
            $arr[$count] = $myts->displayTarea($item['name']);

            $count++;
        }

        return $arr;
    }

    public function hasCatItems($idcat)
    {
        //global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM) . " WHERE id_expertisecat=$idcat";

        $result = $this->db->query($sql);

        $exp_item = $this->db->fetchArray($result);

        if (!empty($exp_item['ID_EXPERTISEITEM'])) {
            return true;
        }
  

        return false;
    }

    public function updateCat()
    {
        //global $module_tables;

        $sql = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_CAT) . " SET name='" . $this->getNameCat() . "', priority=" . $this->getPriorityCat() . ' WHERE ID_EXPERTISECAT=' . $this->getIdCat();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminexpertise.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminexpertise.php', 4, $this->db->error());
        }
    }

    public function updateItem()
    {
        //global $module_tables;

        $sql = 'UPDATE '
               . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_ITEM)
               . " SET name='"
               . $this->getNameItem()
               . "', alwaysShown="
               . $this->getAlwaysShownItem()
               . ', display='
               . $this->getDisplayItem()
               . ', id_expertisecat='
               . $this->getIdCatItem()
               . ' WHERE ID_EXPERTISEITEM='
               . $this->getIdItem();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminexpertise.php?op=EXPShowItems', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminexpertise.php?op=EXPShowItems', 4, $this->db->error());
        }
    }

    public function update()
    {
        //global $module_tables;

        // l'expertise doit etre traitée différement

        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK) . ' WHERE ID_USER=' . $this->getIdUser();

        $this->db->queryF($sql);

        $expertise_arr = $this->getExpertise();

        for ($x = 0, $xMax = count($expertise_arr); $x < $xMax; $x++) {
            $expertise = $expertise_arr[$x];

            $sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_GEN_EXPERTISE_USERLINK) . ' (ID_USER, ID_EXPERTISEITEM) VALUES(' . $this->getIdUser() . ', ' . $expertise . ')';

            $this->db->queryF($sql);
        }

        if (0 == $this->db->errno()) {
            //redirect_header("adminteam.php",1,_AM_DBUPDATED);
        } else {
            redirect_header('adminteam.php', 4, $this->db->error());
        }
    }
}
