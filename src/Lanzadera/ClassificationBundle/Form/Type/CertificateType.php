<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 02/09/14
 * Time: 19:51
 */

namespace Lanzadera\ClassificationBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Lanzadera\ClassificationBundle\Form\DataTransformer\ArrayToCertificateTransform;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CertificateType extends AbstractType
{
    /**
     * @var ObjectManager $om
     */
    protected $om;

    protected $arrayToCertificateTransform;

    public function __construct(ObjectManager $om, ArrayToCertificateTransform $arrayToCertificateTransform)
    {
        $this->om = $om;
        $this->arrayToCertificateTransform = $arrayToCertificateTransform;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->arrayToCertificateTransform);

    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'label' => 'product.certificates.label',
                'help' => 'product.certificates.help',
                'choices' => $this->om->getRepository('LanzaderaClassificationBundle:Classification')->getChoices(),
                'class' => 'Lanzadera\ClassificationBundle\Entity\Certificate',
                'model_manager' => null,
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