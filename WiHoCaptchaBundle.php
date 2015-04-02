<?php

namespace WiHo\CaptchaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use WiHo\CaptchaBundle\DependencyInjection\WiHoCaptchaExtension;

class WiHoCaptchaBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new WiHoCaptchaExtension('wiho_captcha');
    }
}
