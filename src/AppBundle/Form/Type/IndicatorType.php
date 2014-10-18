<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/08/14
 * Time: 19:27
 */

namespace AppBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Criterion;
use AppBundle\Form\DataTransformer\ArrayToIndicatorsTransform;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class IndicatorType extends AbstractType implements IndicatorTypeInterface
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
        $criteria = $this->om->getRepository('AppBundle:Criterion')->findByType($this->getType());

        /** @var Criterion $criterion */
        foreach ($criteria as $criterion) {
            $builder->add('criterion-' . $criterion->getId(), 'choice', array(
                    'label' => $criterion->getName(),
                    'description' => $criterion->getDescription(),
                    'choices' => $criterion->getIndicators(true),
                    'required' => false,
                    'empty_value' => 'criterion.indicator.placeholder',
                    'attr' => array('class' => 'form-control'),
            ));
        }

        $builder->addModelTransformer(new ArrayToIndicatorsTransform($this->om));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
           'block_name' => 'lanzadera_indicator',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }
} 