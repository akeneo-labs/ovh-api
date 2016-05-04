<?php

namespace Jmleroux\VpsTools;

use Ovh\Api;

class Vps
{
    /** @var Api */
    private $connection;
    /** @var string */
    private $service;
    /** @var int */
    private $disk;
    /** @var string */
    private $status;

    public function __construct(Api $connection, $name)
    {
        $this->connection = $connection;
        $this->service = $name;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return int
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * @param int $disk
     */
    public function setDisk($disk)
    {
        $this->disk = $disk;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getInfos()
    {
        $query = sprintf('/vps/%s', $this->service);
        $infos = $this->connection->get($query);
        $query = sprintf('/vps/%s/serviceInfos', $this->service);
        $infos = array_merge($infos, $this->connection->get($query));

        return $infos;
    }

    public function fetchDisk()
    {
        $query = sprintf('/vps/%s/disks', $this->service);
        try {
            $disks = $this->connection->get($query);
            $this->disk = $disks[0];
        } catch (GuzzleHttp\Exception\ClientException $e) {
        }
    }
}
