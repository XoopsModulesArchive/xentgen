<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentUsers = new XentUsers();

class XentUsers
{
    public $career_summary;

    public $db;

    public $id_user;

    public $id_job;

    public $id_location;

    public $id_title;

    public $id_typeposte;

    public $name;

    public $pictpro;

    public $priority;

    public $smartConfig;

    // constructor

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();

        $hModule = xoops_getHandler('module');

        $hModConfig = xoops_getHandler('config');

        $smartModule = $hModule->getByDirname('xentgen');

        $this->smartConfig = &$hModConfig->getConfigsByCat(0, $smartModule->getVar('mid'));
    }

    // setters

    public function setCareerSummary($career_summary)
    {
        $this->career_summary = $career_summary;
    }

    public function setIdJob($id)
    {
        $this->id_job = $id;
    }

    public function setIdTitle($id)
    {
        $this->id_title = $id;
    }

    public function setIdUser($id)
    {
        $this->id_user = $id;
    }

    public function setIdLocation($id)
    {
        $this->id_location = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPictPro($pictpro)
    {
        $this->pictpro = $pictpro;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function setIdTypePoste($id)
    {
        $this->id_typeposte = $id;
    }

    // getters

    public function getCareerSummary()
    {
        return $this->career_summary;
    }

    public function getIdJob()
    {
        return $this->id_job;
    }

    public function getIdTitle()
    {
        return $this->id_title;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getIdLocation()
    {
        return $this->id_location;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPictPro()
    {
        return $this->pictpro;
    }

    public function getPictProPath()
    {
        $upldir = $this->smartConfig['image_upload_dir'];

        return XOOPS_URL . "$upldir/" . $this->pictpro;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getIdTypePoste()
    {
        return $this->id_typeposte;
    }

    // methods

    // cette méthode doit être utilisé que dans le module xEntGen

    public function add($inBatch = 0)
    {
        $sql = 'INSERT INTO '
               . $this->db->prefix(XENT_DB_XENT_GEN_USERS)
               . ' (ID_USER, id_job, id_typeposte, id_location, id_title, pictpro, career_summary, priority) VALUES('
               . $this->getIdUser()
               . ', '
               . $this->getIdJob()
               . ', '
               . $this->getIdTypePoste()
               . ', '
               . $this->getIdLocation()
               . ', '
               . $this->getIdTitle()
               . ", '"
               . $this->getPictPro()
               . "', '"
               . $this->getCareerSummary()
               . "', "
               . $this->getPriority()
               . ')';

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                redirect_header('adminusers.php', 1, _AM_DBUPDATED);
            } else {
                redirect_header('adminusers.php', 4, $this->db->error());
            }
        }
    }

    public function countUsers()
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS);

        $result = $this->db->query($sql);

        return $this->db->getRowsNum($result);
    }

    // this function deletes all the users in table xoops_xent_init_users that

    // does not appears in table xoops_users

    public function dbCleanUp()
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS);

        $result = $this->db->query($sql);

        while (false !== ($xent_users = $this->db->fetchArray($result))) {
            $xentid = $xent_users['ID_USER'];

            $sql1 = 'SELECT * FROM ' . $this->db->prefix('users') . " WHERE uid=$xentid";

            $result1 = $this->db->query($sql1);

            $xoops_users = $this->db->fetchArray($result1);

            if (empty($xoops_users['uid'])) {
                $sql2 = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS) . " WHERE ID_USER=$xentid";

                $this->db->queryF($sql2);
            }
        }

        redirect_header('adminusers.php', 2, _AM_GEN_DBCLEANUPPROGRESS);
    }

    public function delete($iduser)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS) . " WHERE ID_USER=$iduser";

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminusers.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminusers.php', 4, $this->db->error());
        }
    }

    public function exists($iduser)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS) . " WHERE id_user=$iduser";

        $result = $this->db->query($sql);

        if (0 == $this->db->getRowsNum($result)) {
            return false;
        }
  

        return true;
    }

    public function existsInXoopsUsers($iduser)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('users') . " WHERE uid=$iduser";

        $result = $this->db->query($sql);

        if (0 == $this->db->getRowsNum($result)) {
            return false;
        }
  

        return true;
    }

    public function getAllUsers($sort = '')
    {
        $this->synchronize();

        if (!empty($sort)) {
            $sql = 'SELECT x1.ID_USER, x1.id_job, x1.id_typeposte, x1.id_location, x1.id_title, x1.pictpro, x1.career_summary, x1.priority, x2.name FROM '
                   . $this->db->prefix(XENT_DB_XENT_GEN_USERS)
                   . ' AS x1, '
                   . $this->db->prefix('users')
                   . " AS x2 WHERE x1.ID_USER = x2.uid AND SUBSTRING(x2.name,1,1) = '$sort' ORDER BY x2.name";
        } else {
            $sql = 'SELECT x1.ID_USER, x1.id_job, x1.id_typeposte, x1.id_location, x1.id_title, x1.pictpro, x1.career_summary, x1.priority, x2.name FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS) . ' AS x1, ' . $this->db->prefix('users') . ' AS x2 WHERE x1.ID_USER = x2.uid ORDER BY x2.name';
        }

        $result = $this->db->query($sql);

        return $result;
    }

    public function getAllUsersInArray()
    {
        $sql = 'SELECT x1.ID_USER, x1.id_job, x1.id_typeposte, x1.id_location, x1.id_title, x1.pictpro, x1.career_summary, x1.priority, x2.name FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS) . ' AS x1, ' . $this->db->prefix('users') . ' AS x2 WHERE x1.ID_USER = x2.uid ORDER BY x2.name';

        $result = $this->db->query($sql);

        $thearray = [];

        while (false !== ($user = $this->db->fetchArray($result))) {
            $thearray[$user['ID_USER']] = $user['name'];
        }

        return $thearray;
    }

    public function getTitleName($id_title)
    {
        $title = reference(XENT_DB_XENT_GEN_TITLES, 'title', 'ID_TITLE', $id_title);

        if (!empty($title)) {
            $title = ', ' . $title;
        }

        return $title;
    }

    public function getUser($id)
    {
        //global $xoopsModuleConfig, $xoopsConfig, $xoopsModule;

        $sql = 'SELECT x1.ID_USER, x1.id_job, x1.id_typeposte, x1.id_location, x1.id_title, x1.pictpro, x1.career_summary, x1.priority, x2.name FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS) . ' AS x1, ' . $this->db->prefix('users') . " AS x2 WHERE x1.ID_USER=$id AND x1.ID_USER=x2.uid";

        $result = $this->db->query($sql);

        //Retourne la nom de la job

        $theUser = $this->db->fetchArray($result);

        $theUser['job'] = reference(XENT_DB_XENT_GEN_JOBS, 'job', 'ID_JOB', $theUser['id_job']);

        //Retourne la nom du type de poste

        $theUser['typeposte'] = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'typeposte', 'ID_TYPEPOSTE', $theUser['id_typeposte']);

        //Retourne la nom du type de poste

        $city = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'city', 'ID_LOCATION', $theUser['id_location']);

        $state = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'state', 'ID_LOCATION', $theUser['id_location']);

        $country = reference(XENT_DB_XENT_GEN_TYPEPOSTE, 'country', 'ID_LOCATION', $theUser['id_location']);

        if (1 == $this->smartConfig['display_location']) {
            $theUser['location'] = $city . ', ' . $state;
        }

        if (2 == $this->smartConfig['display_location']) {
            $theUser['location'] = $city . ', ' . $country;
        }

        if (3 == $this->smartConfig['display_location']) {
            $theUser['location'] = $state . ', ' . $country;
        }

        //Retourne l'url complet de la photo

        $pictpro = $theUser['pictpro'];

        if ('' == $pictpro) {
            //Si $pictpro est vide, Set l'image par defaut.

            $pictpro = 'blank.png';
        }

        $upldir = $this->smartConfig['image_upload_dir'];

        $theUser['pictpropath'] = XOOPS_URL . "$upldir/$pictpro";

        return $theUser;
    }

    public function getUsersToImport($id_group)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('groups_users_link') . " WHERE groupid=$id_group";

        $result = $this->db->query($sql);

        return $result;
    }

    public function synchronize()
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_USERS) . ' ORDER BY ID_USER';

        $result = $this->db->query($sql);

        while (false !== ($users = $this->db->fetchArray($result))) {
            if (false === $this->existsInXoopsUsers($users['ID_USER'])) {
                $this->delete($users['ID_USER']);
            }
        }
    }

    // permet de transformer un nom de [nom, prénom] à [prénom nom]

    public function transformName($name)
    {
        if (instr($name, ',')) {
            $arr = explode(',', $name);

            $familyname = trim($arr[0]);

            $firstname = trim($arr[1]);

            return $firstname . ' ' . $familyname;
        }
  

        return $name;
    }

    public function update()
    {
        $sql = 'UPDATE '
               . $this->db->prefix(XENT_DB_XENT_GEN_USERS)
               . ' SET id_job='
               . $this->getIdJob()
               . ', id_title='
               . $this->getIdTitle()
               . ', id_typeposte='
               . $this->getIdTypePoste()
               . ', id_location='
               . $this->getIdLocation()
               . ", pictpro='"
               . $this->getPictPro()
               . "', career_summary='"
               . $this->getCareerSummary()
               . "', priority="
               . $this->getPriority()
               . ' WHERE ID_USER='
               . $this->getIdUser();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminusers.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminusers.php', 4, $this->db->error());
        }
    }
}
