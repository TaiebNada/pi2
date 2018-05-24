<?php

namespace Animaux1Bundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AnimauxType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       /* $builder->add('nom')
              ->add('race',ChoiceType::class,array(
        'choices'=>array('Chat'=>'chat',"Chien"=>"chien","Chevaux"=>"chevaux", "Lapin"=>"lapin"),
        'multiple'=>false ,
        'label'=>'Race',
        'expanded'=>false))
            ->add('espece',ChoiceType::class,array(
                'choices'=>array(
                     'Carnivores domestiques'=>array('Chat'=>'chat',"Chien"=>"chien"),
                     'Rongeurs'=>array('rat'=>'Rat', 'cochon'=>'Cochon', "hamster"=>"Hamster", "écureuil"=>'Ecureuil'),
                     'Cuniculture'=>array('lapin domestique'=>'Lapin Domestique', 'lapin nain'=>'lapin nain'),
                    'Chevaux'=>array('Cheval'=>'Cheval', 'âne'=>'ane'),
                    'Oiseaux'=>array('canari'=>'Canari','diamant'=>'Diamant','perroquet'=>'Perroquet','Pigeon'=>'Pigeon','Poule'=>'poule', 'Canard'=>'canard'),
                                )
            ))
            ->add('sexe',ChoiceType::class,array(
                'choices'=>array('Male'=>'male',"Female"=>"female"),
                'multiple'=>false ,
                'label'=>'Sexe',
                'expanded'=>true))
            ->add('taille')
            ->add('poids')
            ->add('dateNaissance', DateType::class)
            ->add('description')
            ->add('dateVisiteD', DateType::class)
            ->add('dateVaccin', DateType::class)
            ->add('vet', EntityType::class,array(
        'class'=>'Animaux1Bundle:Vet',
        'multiple'=>false ,    // choix multiple
        'choice_label'=>'nom'
    ))
            ->add('file',FileType::class )
            ->add('imageFile',VichImageType::class)
            ->setMethod('Post')
        ->add('ajout',SubmitType::class);*/
        $builder->add('nom')->add('dateNaissance')->add('race',ChoiceType::class,array(
            'choices'=>array('Chat'=>'chat',"Chien"=>"chien","Chevaux"=>"chevaux", "Lapin"=>"lapin"),
            'multiple'=>false ,
            'label'=>'Race',
            'expanded'=>false))
            ->add('espece',ChoiceType::class,array(
                'choices'=>array(
                    'Carnivores domestiques'=>array('Chat'=>'chat',"Chien"=>"chien"),
                    'Rongeurs'=>array('rat'=>'Rat', 'cochon'=>'Cochon', "hamster"=>"Hamster", "écureuil"=>'Ecureuil'),
                    'Cuniculture'=>array('lapin domestique'=>'Lapin Domestique', 'lapin nain'=>'lapin nain'),
                    'Chevaux'=>array('Cheval'=>'Cheval', 'âne'=>'ane'),
                    'Oiseaux'=>array('canari'=>'Canari','diamant'=>'Diamant','perroquet'=>'Perroquet','Pigeon'=>'Pigeon','Poule'=>'poule', 'Canard'=>'canard'),
                )
            ))
            ->add('sexe',ChoiceType::class,array(
                'choices'=>array('Male'=>'male',"Female"=>"female"),
                'multiple'=>false ,
                'label'=>'Sexe',
                'expanded'=>true))
            ->add('description')
            ->add('image', FileType::class)
            ->add('vet', EntityType::class,array(
                'class'=>'Animaux1Bundle:Vet',
                'multiple'=>false ,    // choix multiple
                'choice_label'=>'nom'
            ))->add('Ajouter', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Animaux1Bundle\Entity\Animaux'
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'animaux1bundle_animaux';
    }


}
