<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 29/08/14
 * Time: 8:26
 */

namespace Lanzadera\ProductBundle\Form\Type;

use Lanzadera\ProductBundle\Entity\Product;
use Lanzadera\ProductBundle\Form\Extension\ChoiceList\StatusChoiceList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class StatusType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choice_list' => new StatusChoiceList(),
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Choice(array(
                    'choices' => Product::getStatuses(),
                    'message' => 'lanzadera.product.status.choice.invalid'
                )),
            ),
            'attr' => array('class' => 'form-control')
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
        return 'status';
    }
}