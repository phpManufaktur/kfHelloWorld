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

class Sample07 extends kitCommandBasic
{

    public function Sample07a()
    {
        return $this->app['twig']->render($this->app['utils']->templateFile('@thirdParty/HelloWorld/Template', 'sample07a.twig'),
            array(
                'cms' => self::$cms
        ));
    }

    public function Sample07b()
    {
        $form = $this->app['form.factory']->createBuilder('form')
        ->add('name', 'text')
        ->getForm();

        if (isset(self::$POST['form']['name'])) {
            // the form was already submitted
            $this->setMessage($this->app['translator']->trans('<p>Hello %name%, nice to meet you!</p>',
                array('%name%' => self::$POST['form']['name'])));
        }

        return $this->app['twig']->render($this->app['utils']->templateFile('@thirdParty/HelloWorld/Template', 'sample07b.twig'),
            array(
                'form' => $form->createView(),
                'action' => self::$cms['page_url'],
                'name' => (isset(self::$POST['form']['name'])) ? self::$POST['form']['name'] : '',
                'message' => $this->getMessage()
        ));
    }
}