<?php

namespace WiHo\CaptchaBundle\Form\Validator;

use Guzzle\Http\Client;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;

class CaptchaValidator
{
    /**
     * Secret for Google requests
     */
    private $secret;

    /**
     * Application key
     */
    private $key;

    /**
     * Error message text for non-matching submissions
     */
    private $invalidMessage;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @param $secret
     * @param $key
     * @param $invalidMessage
     */
    public function __construct($secret, $key, $invalidMessage, Request $request = null)
    {
        $this->key              = $key;
        $this->invalidMessage   = $invalidMessage;
        $this->request          = $request;
    }

    /**
     * @param FormEvent $event
     */
    public function validate(FormEvent $event)
    {
        $form = $event->getForm();

        $data = $form->getData();
        $result = $this->isResponseValid($data);
        var_dump($result);
        die();


        /*
         * Get the response, submit data to google and validate or not the form
         */
        /*$expectedCode = $this->getExpectedCode();

        if (!($code !== null && is_string($code) && ($this->compare($code, $expectedCode) || $this->compare($code, $this->bypassCode)))) {
            $form->addError(new FormError($this->translator->trans($this->invalidMessage, array(), 'validators')));
        }*/
    }

    protected function isResponseValid($data)
    {
        $query_params = array(
            'secret' => $this->secret,
            'response' => $data,
        );
        if ($this->request instanceof Request) {
            $query_params['remoteip'] = $this->request->getClientIp();
        }
        $client = new Client();
        $response = $client->get('https://www.google.com/recaptcha/api/siteverify', array('query' => $query_params))->getResponse();
        $code = $response->getStatusCode();
        $json = $response->json();
    }
}
