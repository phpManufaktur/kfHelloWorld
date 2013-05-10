<?php

/**
 * kfHelloWorld
 *
 * @author Team phpManufaktur <team@phpmanufaktur.de>
 * @link https://kit2.phpmanufaktur.de
 * @copyright 2013 Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

namespace thirdParty\HelloWorld\Control;

use phpManufaktur\Basic\Control\kitCommand\Basic as kitCommandBasic;

class Sample06 extends kitCommandBasic
{

    public function exec()
    {
        return $this->app['twig']->render($this->app['utils']->templateFile('@thirdParty/HelloWorld/Template', 'sample06.twig'),
            array(
                'cms' => $this->getCMSinfoArray()
        ));
    }

}