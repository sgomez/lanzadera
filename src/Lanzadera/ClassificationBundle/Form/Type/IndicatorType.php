<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/08/14
 * Time: 19:27
 */

namespace Lanzadera\ClassificationBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectManager;
use Lanzadera\ClassificationBundle\Entity\Criterion;
use Lanzadera\ClassificationBundle\Form\DataTransformer\ArrayToIndicatorsTransform;
use Lanzadera\CoreBundle\Doctrine\ORM\CriterionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IndicatorType extends AbstractType
{
    protected $om;

    protected $ladybug;

    public function __construct(ObjectManager $om, $ladybug)
    {
        $this->om = $om;
        $this->ladybug = $ladybug;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $criteria = $this->om->getRepository('LanzaderaClassificationBundle:Criterion')->findByType(Criterion::PRODUCT);

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

        $transformer = new ArrayToIndicatorsTransform($this->om, $this->ladybug);
        $builder->addModelTransformer($transformer);
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
        $resolver->setRequired(array('indicator_type'));
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