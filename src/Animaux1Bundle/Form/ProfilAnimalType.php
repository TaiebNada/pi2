<?php

namespace Animaux1Bundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfilAnimalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class,array(
            'attr' => array(
                'readonly' => 'readonly',
            ),))
            ->add('dateNaissance', BirthdayType::class,array(
                'attr' => array(
                    'readonly' => 'readonly',
                ),))
            ->add('race',ChoiceType::class,array(
            'choices'=>array('Chat'=>'chat',"Chien"=>"chien","Chevaux"=>"chevaux", "Lapin"=>"lapin"),
            'multiple'=>false ,
            'label'=>'Race',
            'expanded'=>false),array(
                'attr' => array(
                    'readonly' => 'readonly',
                ),))
            ->add('espece',ChoiceType::class,array(
                'choices'=>array(
                    'Carnivores domestiques'=>array('Chat'=>'chat',"Chien"=>"chien"),
                    'Rongeurs'=>array('rat'=>'Rat', 'cochon'=>'Cochon', "hamster"=>"Hamster", "écureuil"=>'Ecureuil'),
                    'Cuniculture'=>array('lapin domestique'=>'Lapin Domestique', 'lapin nain'=>'lapin nain'),
                    'Chevaux'=>array('Cheval'=>'Cheval', 'âne'=>'ane'),
                    'Oiseaux'=>array('canari'=>'Canari','diamant'=>'Diamant','perroquet'=>'Perroquet','Pigeon'=>'Pigeon','Poule'=>'poule', 'Canard'=>'canard'),
                )
            ),array('attr' => array('readonly' => 'readonly')))
            ->add('sexe',ChoiceType::class,array(
                'choices'=>array('Male'=>'male',"Female"=>"female"),
                'multiple'=>false ,
                'label'=>'Sexe',
                'expanded'=>true),array(
                'attr' => array(
                    'readonly' => true,
                ),
            ))
            ->add('description', TextareaType::class,array(
                'attr' => array(
                    'readonly' => true,
                ),
            ))

            ->add('imageprofil', FileType::class, array('label' => 'Brochure (PDF file)'))
            ->add('vet', EntityType::class,array(
                'class'=>'Animaux1Bundle:Vet',
                'multiple'=>false ,    // choix multiple
                'choice_label'=>'nom'
            ),array(
                'attr' => array(
                    'readonly' => 'readonly',
                ),
            ))
            ->add('taille')
            ->add('poids')
            ->add('dateVisiteD', DateType::class)
            ->add('dateVaccin', DateType::class)
            ->add('Update', SubmitType::class);
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
        return 'animaux1bundle_profilanimal';
    }


}
