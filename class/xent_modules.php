<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentModules = new XentModules();

class XentModules
{
    public $modulename;

    public $db;

    // constructor

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
    }

    // setters

    public function setModuleName($name)
    {
        $this->modulename = $name;
    }

    // getters

    public function getModuleName()
    {
        return $this->modulename;
    }

    // methods

    public function modulesExists($name)
    {
        $sql = 'SELECT dirname FROM ' . $this->db->prefix('modules') . " WHERE dirname='$name'";

        $result = $this->db->query($sql);

        $modules = $this->db->fetchArray($result);

        if (empty($modules['dirname'])) {
            return 0;
        }
  

        return 1;
    }
}
