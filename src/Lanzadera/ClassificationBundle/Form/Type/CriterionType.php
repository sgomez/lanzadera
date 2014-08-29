<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 29/08/14
 * Time: 13:40
 */

namespace Lanzadera\ClassificationBundle\Form\Type;


use Lanzadera\ClassificationBundle\Entity\Criterion;
use Lanzadera\ClassificationBundle\Form\Extension\ChoiceList\CriterionChoiceList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CriterionType extends AbstractType
{
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

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'criterion_type';
    }
} 