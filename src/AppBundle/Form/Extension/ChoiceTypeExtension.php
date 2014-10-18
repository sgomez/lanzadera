<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 27/08/14
 * Time: 19:10
 */

namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoiceTypeExtension extends AbstractTypeExtension
{
    /**
     * Add the description option
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('description'));
    }

    /**
     * Pass the description to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('description', $options)) {
            $parentData = $form->getParent()->getData();

            if (null !== $parentData) {
                $description = $options['description'];
            } else {
                $description = null;
            }

            $view->vars['description'] = $description;
        }
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'choice';
    }
} 