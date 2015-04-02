<?php

namespace WiHo\CaptchaBundle\Form\Type;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use WiHo\CaptchaBundle\Form\Validator\CaptchaValidator;


class CaptchaType extends AbstractType
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $request_stack;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $options;

    /**
     * @param RequestStack $request_stack
     * @param $secret
     * @param $key
     */
    public function __construct(RequestStack $request_stack, $secret, $key)
    {
        $this->request_stack = $request_stack;
        $this->secret        = $secret;
        $this->key           = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $validator = new CaptchaValidator(
            $this->secret,
            $this->key,
            $options['invalid_message'],
            $this->request_stack->getCurrentRequest()
        );

        $builder->addEventListener(FormEvents::POST_SUBMIT, array($validator, 'validate'));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->options['mapped'] = false;
        $resolver->setDefaults($this->options);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wiho_captcha';
    }
}
