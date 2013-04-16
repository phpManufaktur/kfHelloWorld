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
use thirdParty\HelloWorld\Data\HelloWorld;

class Sample08 extends kitCommandBasic {

    /**
     * Show a simple dialog within a iframe
     *
     * @return string rendered dialog
     */
    public function start()
    {
        return $this->app['twig']->render($this->app['utils']->templateFile('@thirdParty/HelloWorld/Template', 'sample08.start.twig', self::$preferred_template),
            array(
                'link' => FRAMEWORK_URL.'/helloworld/sample08/step02/'.self::$parameter_string
        ));
    }

    /**
     * Define the form for Sample 08 and return the form object
     *
     * @return object
     */
    protected function createForm()
    {
        return $this->app['form.factory']->createBuilder('form')
        ->add('title', 'choice', array(
            'choices' => array('mister' => 'Mister', 'lady' => 'Lady'),
            'expanded' => false,
            'label' => 'Title'
        ))
        ->add('first_name', 'text', array(
            'label' => 'First name',
            'required' => false
        ))
        ->add('last_name', 'text', array(
            'label' => 'Last name',
            'required' => true
        ))
        ->add('birthday', 'birthday', array(
            'label' => 'Birthday',
            'format' => 'dd.MM.yyyy',
            'widget' => 'single_text'
        ))
        ->add('email', 'email', array(
            'label' => 'Email',
            'required' => true
        ))
        ->getForm();
    }

    /**
     * Show the contact dialog
     *
     * @return rendered dialog
     */
    public function step02()
    {
        $form = $this->createForm();
        return $this->app['twig']->render($this->app['utils']->templateFile('@thirdParty/HelloWorld/Template', 'sample08.step02.twig', self::$preferred_template),
            array(
                'action' => FRAMEWORK_URL.'/helloworld/sample08/step03/'.self::$parameter_string,
                'form' => $form->createView(),
                'message' => $this->getMessage()
        ));
    }

    public function step03()
    {
        // create the form
        $form = $this->createForm();
        // bind the request to the form
        $form->bind($this->app['request']);
        // check the form
        if (!$form->isValid()) {
            // something went wrong, possible CSFR attack - return to the default form and prompt a message
            $this->setMessage($this->app['translator']->trans('<p>The submitted form is not valid, please try again.</p>'));
            return $this->step02();
        }
        // get the data from the form
        $form_data = $form->getData();
        // now we want to save the data to the database
        $HelloWorld = new HelloWorld($this->app);
        // ensure that the table is created
        $HelloWorld->createTable();
        // collect the data
        $record = array(
            'title' => $form_data['title'],
            'first_name' => isset($form_data['first_name']) ? $form_data['first_name'] : '',
            'last_name' => $form_data['last_name'],
            'birthday' => $form_data['birthday']->format('Y-m-d'),
            'email' => $form_data['email']
        );
        // insert the record and get the new ID
        $id = $HelloWorld->insert($record);

        return $this->app['twig']->render($this->app['utils']->templateFile('@thirdParty/HelloWorld/Template', 'sample08.step03.twig', self::$preferred_template),
            array(
                'message' => $this->getMessage(),
                'data' => $record,
                'link_email' => FRAMEWORK_URL.'/helloworld/sample08/step04/'.$id.'/'.self::$parameter_string,
                'link_form' => FRAMEWORK_URL.'/helloworld/sample08/step02/'.self::$parameter_string,
            ));
    }

    public function step04($id)
    {
        // select the contact data from the database
        $HelloWorld = new HelloWorld($this->app);
        $data = $HelloWorld->select($id);

        // create the email body
        $body = $this->app['twig']->render($this->app['utils']->templateFile('@thirdParty/HelloWorld/Template', 'sample08.email.twig'),
            array('data' => $data));

        // create the message
        $message = \Swift_Message::newInstance()
        ->setSubject($this->app['translator']->trans('Hello World confirmation'))
        ->setFrom(array(SERVER_EMAIL_ADDRESS))
        ->setTo(array($data['email']))
        ->setBody($body)
        ->setContentType('text/html');
        // send the message
        $this->app['mailer']->send($message);

        return $this->app['twig']->render($this->app['utils']->templateFile('@thirdParty/HelloWorld/Template', 'sample08.step04.twig', self::$preferred_template),
            array(
                'data' => $data,
                'link_form' => FRAMEWORK_URL.'/helloworld/sample08/step02/'.self::$parameter_string,
            ));
    }
}