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

    protected $sss = 225556663;

    public function __construct(AdapterInterface $adapter)
    {//var_dump(get_class_methods($adapter));
 
  $computedValue = 'foobar2';
  $that = $this;
$value = $adapter->get('my_cache_key4', function ( $item) {
    $item->expiresAfter(3600);

    // ... do some HTTP request or heavy computations

    $this->sss;
    return $this->sss;
});

echo $value; // 'foobar'
exit;
        parent::__construct($adapter);
    }
}
