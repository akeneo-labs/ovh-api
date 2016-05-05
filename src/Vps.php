<?php

namespace Jmleroux\VpsTools;

use GuzzleHttp\Exception\ClientException;
use Ovh\Api;

class Vps
{
    /** @var Api */
    private $connection;
    /** @var string */
    private $service;
    /** @var int */
    private $disk;

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
    public function fetchInfos()
    {
        $query = sprintf('/vps/%s', $this->service);
        $infos = $this->connection->get($query);
        $query = sprintf('/vps/%s/serviceInfos', $this->service);
        $infos = array_merge($infos, $this->connection->get($query));

        $this->fetchDisk();
        $infos->disk = $this->getDisk();
        
        return $infos;
    }

    public function fetchDisk()
    {
        $query = sprintf('/vps/%s/disks', $this->service);
        try {
            $disks = $this->connection->get($query);
            $this->disk = $disks[0];
        } catch (ClientException $e) {
        }
    }
}
