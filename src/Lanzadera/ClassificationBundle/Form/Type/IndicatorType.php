<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/08/14
 * Time: 19:27
 */

namespace Lanzadera\ClassificationBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectRepository;
use Lanzadera\ClassificationBundle\Entity\Criterion;
use Lanzadera\ClassificationBundle\Form\DataTransformer\ArrayToIndicatorsTransform;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IndicatorType extends AbstractType
{
    protected $criterionRepository;

    protected $arrayToIndicatorsTransform;

    public function __construct(ObjectRepository $criterionRepository, ArrayToIndicatorsTransform $arrayToIndicatorsTransform)
    {
        $this->criterionRepository = $criterionRepository;
        $this->arrayToIndicatorsTransform = $arrayToIndicatorsTransform;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $criteria = $this->criterionRepository->findByType(
            $options['indicator_type'] === "product" ? Criterion::PRODUCT : Criterion::ORGANIZATION
        );

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

        $builder->addModelTransformer($this->arrayToIndicatorsTransform);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'indicator_type',
        ));

        $resolver->setAllowedValues(array(
            'indicator_type' => array(
                'product',
                'organization',
            ),
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lanzadera_indicator';
    }
} 