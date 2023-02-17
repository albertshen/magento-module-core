<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Core\Model\Cache;

use Symfony\Component\Cache\Adapter\RedisAdapter as SymfonyRedisAdapter;
use Magento\Framework\App\DeploymentConfig;

/**
 * Class Cache
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class RedisAdapter extends SymfonyRedisAdapter
{

    /**
     * @param DeploymentConfig $deploymentConfig
     */
    public function __construct(DeploymentConfig $deploymentConfig)
    {
        $server = $deploymentConfig->get('cache/frontend/data/backend_options/server');
        $port = $deploymentConfig->get('cache/frontend/data/backend_options/port');
        $redis = new \Predis\Client(sprintf('tcp://%s:%s', $server, $port));
        parent::__construct($redis);
    }
}
