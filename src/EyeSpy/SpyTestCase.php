<?php
/**
 * Created by Gary Hockin.
 * Date: 09/01/15
 * @GeeH
 */

namespace EyeSpy;

use ProxyManager\Factory\AccessInterceptorValueHolderFactory;

class SpyTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AccessInterceptorValueHolderFactory
     */
    private $factory;
    /**
     * @var array
     */
    private $proxies = array();

    public function __construct()
    {
        $this->factory = new AccessInterceptorValueHolderFactory();
    }

    /**
     * @param $object
     * @param $expectedMethod
     * @param array $expectedParameters
     * @return mixed
     */
    public function spy($object, $expectedMethod, array $expectedParameters)
    {
        $className = get_class($object);

        $handler = function ($proxy, $instance, $method, $params) {
            $expectedParameters = $this->proxies[get_class($instance)]['spies'][$method]['expectedParameters'];
            $this->assertEquals($expectedParameters, $params);
            $this->proxies[get_class($instance)]['spies'][$method]['tested'] = true;
        };

        $spies = array_key_exists($className, $this->proxies) ? $this->proxies[$className]['spies'] : [];

        $spies[$expectedMethod] = [
            'expectedParameters' => $expectedParameters,
            'tested'             => false,
        ];

        $factoryMethods = [];
        foreach ($spies as $method => $spy) {
            $factoryMethods[$method] = $handler;
        }

        $proxy = $this->factory->createProxy($object, $factoryMethods);

        $proxy = ['proxy' => $proxy, 'spies' => $spies];

        $this->proxies[$className] = $proxy;
        return $this->proxies[$className]['proxy'];
    }


    /**
     * Checks all spies have fired
     */
    protected function assertPostConditions()
    {
        foreach ($this->proxies as $objectName => $spies) {
            foreach ($spies as $spy) {
                foreach ($spies['spies'] as $name => $method) {
                    $this->assertTrue($method['tested'], 'Spied method `' . $name . '` was not called');
                }
            }
        }
    }

}