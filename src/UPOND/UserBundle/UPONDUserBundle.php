<?php

namespace UPOND\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UPONDUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

