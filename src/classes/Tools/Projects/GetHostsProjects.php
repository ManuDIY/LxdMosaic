<?php

namespace dhope0000\LXDClient\Tools\Projects;

use dhope0000\LXDClient\Model\Client\LxdClient;
use dhope0000\LXDClient\Model\Hosts\HostList;
use dhope0000\LXDClient\Tools\Hosts\HasExtension;

class GetHostsProjects
{
    public function __construct(
        HostList $hostList,
        LxdClient $lxdClient,
        HasExtension $hasExtension
    ) {
        $this->hostList = $hostList;
        $this->lxdClient = $lxdClient;
        $this->hasExtension = $hasExtension;
    }

    public function getAll()
    {
        $details = array();
        foreach ($this->hostList->getHostListWithDetails() as $host) {
            $indent = is_null($host["Host_Alias"]) ? $host["Host_Url_And_Port"] : $host["Host_Alias"];
            $details[$indent] = [
                "online"=>(bool) $host["Host_Online"],
                "projects"=>[]
            ];
            if ($host["Host_Online"] != true) {
                continue;
            }
            $client = $this->lxdClient->getANewClient($host["Host_ID"]);

            if(!$this->hasExtension->checkWithClient($client, "projects")){
                continue;
            }

            $projects = $client->projects->all();


            $details[$indent]["hostId"] = $host["Host_ID"];
            $details[$indent]["projects"] = $projects;
        }
        return $details;
    }
}
