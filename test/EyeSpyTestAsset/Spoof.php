<?php
/**
 * Created by Gary Hockin.
 * Date: 09/01/15
 * @GeeH
 */

namespace EyeSpyTestAsset;

class Spoof
{
    public function doSomething($aParameter)
    {
        return $aParameter;
    }

    public function dontCallMe($baby)
    {
        return $baby;
    }
}