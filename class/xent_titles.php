<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentTitles = new XentTitles();

class XentTitles
{
    public $db;

    public $idtitle;

    public $title;

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
    }

    // setters

    public function setIdTitle($idtitle)
    {
        $this->idtitle = $idtitle;
    }

    public function setTitleName($title)
    {
        $this->title = $title;
    }

    // getters

    public function getIdTitle()
    {
        return $this->idtitle;
    }

    public function getTitleName()
    {
        return $this->title;
    }

    // methods

    public function add($inBatch = 0)
    {
        $sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_GEN_TITLES) . " (title) VALUES('" . $this->getTitleName() . "')";

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                redirect_header('admintitles.php', 1, _AM_DBUPDATED);
            } else {
                redirect_header('admintitles.php', 4, $this->db->error());
            }
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_TITLES) . " WHERE ID_TITLE=$id";

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('admintitles.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('admintitles.php', 4, $this->db->error());
        }
    }

    public function getAllTitles()
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_TITLES) . ' ORDER BY title';

        $result = $this->db->query($sql);

        return $result;
    }

    public function getTitle($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_TITLES) . " WHERE ID_TITLE=$id";

        $result = $this->db->query($sql);

        $title = $this->db->fetchArray($result);

        return $title;
    }

    public function update()
    {
        $sql = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_GEN_TITLES) . " SET title='" . $this->getTitleName() . "' WHERE ID_TITLE=" . $this->getIdTitle();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('admintitles.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('admintitles.php', 4, $this->db->error());
        }
    }
}
