<?php

namespace Animaux1Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('prenom')
            ->add('cin')
            ->add('dateNaissance',BirthdayType::class)
            ->add('numTel')
            ->add('mail')
            ->add('image',FileType::class)
            ->add('justificatif',FileType::class)
            ->add('adresse')
            ->add('delegation',ChoiceType::class,array(
                'choices'=>array('Tunis'=>'tunis',"Ariana"=>"ariana","Nabeul"=>"Nabeul","Bizerte"=>"Bizerte"),
                'multiple'=>false ,
                'label'=>'Delegation',
                'expanded'=>false))
        ->add('ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Animaux1Bundle\Entity\Demande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'animaux1bundle_demande';
    }


}
