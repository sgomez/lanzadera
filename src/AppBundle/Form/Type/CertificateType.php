<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 02/09/14
 * Time: 19:51
 */

namespace AppBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\ArrayToCertificateTransform;
use AppBundle\Form\EventListener\ClearProductCertificatesSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CertificateType extends AbstractType
{
    /**
     * @var ObjectManager $om
     */
    protected $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ArrayToCertificateTransform($this->om, $options['auto']));
        $builder->addEventSubscriber(new ClearProductCertificatesSubscriber($this->om));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'choices' => $this->om->getRepository('AppBundle:Classification')->getChoices(),
                'auto' => false,
                'multiple' => true,
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return "choice";
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "certificate";
    }

}