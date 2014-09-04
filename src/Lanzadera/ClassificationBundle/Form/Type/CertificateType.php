<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 02/09/14
 * Time: 19:51
 */

namespace Lanzadera\ClassificationBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectManager;
use Lanzadera\ClassificationBundle\Form\DataTransformer\ArrayToCertificateTransform;
use Lanzadera\ClassificationBundle\Form\EventListener\ClearProductCertificatesSubscriber;
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
        $builder->addModelTransformer(new ArrayToCertificateTransform($this->om));
        $builder->addEventSubscriber(new ClearProductCertificatesSubscriber($this->om));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'choices' => $this->om->getRepository('LanzaderaClassificationBundle:Classification')->getChoices(),
        ));

    }

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