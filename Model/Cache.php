<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Core\Model;

use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class Cache
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Cache extends Psr16Cache
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        parent::__construct($adapter);
    }
}
