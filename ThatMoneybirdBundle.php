<?php

/*
 * This file is part of the KamiMoneyBirdApiBundle package.
 *
 * (c) Stepanenko Stanislav <dsazztazz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Thatside\MoneybirdBundle;

use Thatside\MoneybirdBundle\DependencyInjection\ThatMoneybirdExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ThatMoneybirdBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ThatMoneybirdExtension();
        }

        return $this->extension;
    }
}
