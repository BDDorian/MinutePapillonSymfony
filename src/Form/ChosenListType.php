<?php

namespace App\Form;

use App\Entity\ListOfTasks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ChosenListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //How to add all the lists name into a choiceList type.
        $builder
            ->add('name', EntityType::class, array(
                'class' => ListOfTasks::class,
                'choice_label' =>'name',
           
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListOfTasks::class,
        ]);
    }
}
