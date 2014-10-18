<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 29/08/14
 * Time: 13:40
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Criterion;
use AppBundle\Form\Extension\ChoiceList\CriterionChoiceList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CriterionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choice_list' => new CriterionChoiceList(),
            'expanded' => true,
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Choice(array(
                    'choices' => Criterion::getTypes(),
                    'message' => 'lanzadera.criterion.type.choice.invalid'
                )),
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'criterion_type';
    }
} 