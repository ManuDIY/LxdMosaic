<?php

namespace dhope0000\LXDClient\Tools\CloudConfig\Contents;

use dhope0000\LXDClient\Model\CloudConfig\GetConfig;

class GetLatest
{
    public function __construct(GetConfig $getConfig)
    {
        $this->getConfig = $getConfig;
    }

    public function getLatest(int $cloudConfigId)
    {
        $latest = $this->getConfig->getLatestConfig($cloudConfigId);
        if (empty($latest)) {
            return [
                "revisionId"=>null,
                "cloudConfigId"=>$cloudConfigId,
                "data"=>""
            ];
        }
        return $latest;
    }
}
