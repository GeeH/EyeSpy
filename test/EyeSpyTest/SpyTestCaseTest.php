<?php

use EyeSpyTestAsset\Spoof;

class SpyTestCaseTest extends \EyeSpy\SpyTestCase
{
    public function testCreateSpy()
    {
        $spoof = new \EyeSpyTestAsset\Spoof();
        /** @var Spoof $proxy */
        $spoof = $this->createProxy($spoof, 'doSomething', ['aParameter' => 'MindBlown']);
        $this->assertInstanceOf(\ProxyManager\Proxy\ValueHolderInterface::class, $spoof);

        $this->assertEquals('MindBlown', $spoof->doSomething('MindBlown'));

        $this->assertEquals('Epic', $spoof->dontCallMe('Epic'));

    }

}

