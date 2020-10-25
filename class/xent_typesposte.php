<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentTypesPoste = new XentTypesPoste();

class XentTypesPoste
{
    public $db;

    public $idtypeposte;

    public $typepostename;

    //constructor

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
    }

    // setters

    public function setIdTypePoste($id)
    {
        $this->idtypeposte = $id;
    }

    public function setTypePosteName($name)
    {
        $this->typepostename = $name;
    }

    // getters

    public function getIdTypePoste()
    {
        return $this->idtypeposte;
    }

    public function getTypePosteName()
    {
        return $this->typepostename;
    }

    // methods

    public function add($inBatch = 0)
    {
        $sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_GEN_TYPEPOSTE) . " (typeposte) VALUES('" . $this->getTypePosteName() . "')";

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                redirect_header('admintypesposte.php', 1, _AM_DBUPDATED);
            } else {
                redirect_header('admintypesposte.php', 4, $this->db->error());
            }
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_TYPEPOSTE) . " WHERE ID_TYPEPOSTE=$id";

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('admintypesposte.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('admintypesposte.php', 4, $this->db->error());
        }
    }

    public function getAllTypesPoste()
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_TYPEPOSTE) . ' ORDER BY typeposte';

        $result = $this->db->query($sql);

        return $result;
    }

    public function getTypePoste($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_TYPEPOSTE) . " WHERE ID_TYPEPOSTE=$id";

        $result = $this->db->query($sql);

        $typeposte = $this->db->fetchArray($result);

        return $typeposte;
    }

    public function update()
    {
        $sql = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_GEN_TYPEPOSTE) . " SET typeposte='" . $this->getTypePosteName() . "' WHERE ID_TYPEPOSTE=" . $this->getIdTypePoste();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('admintypesposte.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('admintypesposte.php', 4, $this->db->error());
        }
    }
}
