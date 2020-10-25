<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

$xentJobs = new XentJobs();

class XentJobs
{
    public $db;

    public $description;

    public $idjob;

    public $job;

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
    }

    // setters

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setIdJob($idjob)
    {
        $this->idjob = $idjob;
    }

    public function setJobName($job)
    {
        $this->job = $job;
    }

    // getters

    public function getDescription()
    {
        return $this->description;
    }

    public function getIdJob()
    {
        return $this->idjob;
    }

    public function getJobName()
    {
        return $this->job;
    }

    // methods

    public function add($inBatch = 0)
    {
        $sql = 'INSERT INTO ' . $this->db->prefix(XENT_DB_XENT_GEN_JOBS) . " (job, description) VALUES('" . $this->getJobName() . "', '" . $this->getDescription() . "')";

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                redirect_header('adminjobs.php', 1, _AM_DBUPDATED);
            } else {
                redirect_header('adminjobs.php', 4, $this->db->error());
            }
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_JOBS) . " WHERE ID_JOB=$id";

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminjobs.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminjobs.php', 4, $this->db->error());
        }
    }

    public function getAllJobs()
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_JOBS) . ' ORDER BY job';

        $result = $this->db->query($sql);

        return $result;
    }

    public function getJob($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix(XENT_DB_XENT_GEN_JOBS) . " WHERE ID_JOB=$id";

        $result = $this->db->query($sql);

        $job = $this->db->fetchArray($result);

        return $job;
    }

    public function update()
    {
        $sql = 'UPDATE ' . $this->db->prefix(XENT_DB_XENT_GEN_JOBS) . " SET job='" . $this->getJobName() . "', description='" . $this->getDescription() . "' WHERE ID_JOB=" . $this->getIdJob();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('adminjobs.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('adminjobs.php', 4, $this->db->error());
        }
    }
}
