<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Core\Model;

use Magento\Sales\Api\Data\OrderInterface;
use AlbertMage\Customer\Api\Data\SocialAccountInterface;

/**
 * Class Cache
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Token
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * @var SocialAccountInterface
     */
    protected $socialAccount;

    public function __construct()
    {
    }

    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
    }

    public function setSocialAccount(SocialAccountInterface $socialAccount)
    {
        $this->socialAccount = $socialAccount;
    }

    public function parse(string $template)
    {
        $dateFunc = function($value, $format) {
            return date($format, strtotime($value));
        };

        preg_match_all('/\[(.*?)\]/', $template, $matches);
        $values = [];
        foreach($matches[1] as $k => $item) {
            $fields = explode('|', $item);
            $params = explode('.', $fields[0]);
            if (count($params) > 1) {
                foreach($params as $key => $value) {
                    if ($key == 0) {
                        if (is_object($this->{$value})) {
                            $object = $this->{$value};
                        }
                    } else {
                        if (is_object($object->{$this->getMethod($value)}())) {
                            $object = $object->{$this->getMethod($value)}();
                        } else {
                            if (!empty($object->{$this->getMethod($value)}())) {
                                if (isset($fields[1])) {
                                    $filter = explode(',', $fields[1]);
                                    $filterFunc = $filter[0].'Func';
                                    $filterParam = $filter[1] ?? '';
                                    $values[$k] = ${$filterFunc}($object->{$this->getMethod($value)}(), $filterParam);
                                } else {
                                    $values[$k] = $object->{$this->getMethod($value)}();
                                }
                            } else {
                                $values[$k] = "[{$item}]";
                            }
                        }
                    }
                }
            }
        }
        return json_decode(str_replace($matches[0], $values, $template), true);
    }

    /**
     * convert kebab-case to PascalCase
     */
    protected function getMethod(string $str): string
    {
       return 'get' . $this->kebabToPascal($str);
    }

    /**
     * convert kebab-case to PascalCase
     */
    protected function kebabToPascal(string $str): string
    {
       return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $str)));
    }

}
