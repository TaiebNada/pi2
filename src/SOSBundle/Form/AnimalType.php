<?php

namespace SOSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnimalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('espece' , ChoiceType::class , array('choices' => array(
            ""=>"",
            "Indifférent" => "Indifférent",
            "Chat"=> "Chat",
            "Chien"=> "Chien",
            "Equidé" =>"Equidé",
            "NAC" =>"NAC",
            "Porcin"=> "Porcin",
            "Bovin"=> "Bovin",
            "Ovin" =>"Ovin",
            "Caprin" =>"Caprin",
            "Autres" =>"Autres"
        )))->add('race' ,ChoiceType::class , array('choices' => array(
            ""=>"",
            "Affenpinscher" =>"Affenpinscher",
            "Akita"=> "Akita",
            "American Staffordshire Terrier"=> "American Staffordshire Terrier",
            "Amstaff"=> "Amstaff",
            "Barzoï"=> "Barzoï",
            "Basset des Alpes" =>"Basset des Alpes",
            "Beagle"=> "Beagle" ,
            "Beauceron" =>"Beauceron",
            "Berger allemand" =>"Berger allemand",
            "Berger Australien" =>"Berger Australien",
            "Berger belge malinois"=> "Berger belge malinois",
            "Berger de Beauce"=> "Berger de Beauce",
            "Bernhardiner" =>"Bernhardiner",
            "Bichon havanais"=> "Bichon havanais",
            "Bichon maltais" =>"Bichon maltais",
            "Bouledogue Anglais" =>"Bouledogue Anglais",
            "Un Cocker Anglais"=> "Un Cocker Anglais",
            "Billy"=> "Billy" ,
            "Bouledogue français" =>"Bouledogue français",
            "Bouvier bernois"=> "Bouvier bernois",
            "Border collie" =>"Border collie",
            "Boxer"=> "Boxer",
            "Bulldog anglais"=> "Bulldog anglais",
            "Bullmastiff" =>"Bullmastiff",
            )))->add('sexe'  , ChoiceType::class , array('choices' => array(
            ""=>"",
            "Male" => "Male",
            "Femelle"=> "Femelle"
        )))->add('Search' , SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SOSBundle\Entity\Animal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sosbundle_animal';
    }


}
