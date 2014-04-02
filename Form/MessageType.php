<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.04.14
 * Time: 16:05
 * Author: Kluev Andrew
 * Contact: Kluev.Andrew@gmail.com
 */
namespace SeoSA\FeedbackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SeoSA\FeedbackBundle\Form\MessageType
 */
class MessageType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = (string) $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'seo_sa_feedback_message';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('body');
        $builder->add('permalink', 'hidden');
        $builder->add('submit', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => $this->class
            ]
        );
    }
}
 