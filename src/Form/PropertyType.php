<?php
namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


// cette classe gerer l'interface  formulaire edition des Biens
class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null, [
                'label' =>'Titre :'])
            ->add('description')
            ->add('surface')
            ->add('rooms',null, [
                'label' =>'Chambres :'])
            ->add('bedrooms',null, [
                'label' =>'lit :'])
            ->add('floor',null, [
                'label' =>'Etages :'])
            ->add('price',null, [
                'label' =>'prix :'])
            ->add('heat',null, [
                'label' =>'chauffage :'],ChoiceType::class, [
                    'Choices' =>$this->getChoices()
                ])
            
            ->add('imageFile', FileType::class,[
                'required' => false
            ])
            ->add('options', EntityType::class, [
                'class' =>Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('city',null, [
                'label' =>'Ville :'
            ])
            ->add('address',null, [
                'label' =>'addresse :'])
            ->add('postal_code',null, [
                'label' =>'code postale :'])
            ->add('sold',null, [
                'label' =>'Solde'])
        ;
    }


    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }


    private function getChoices()
    {
        $choices = Property::HEAT;
        $output=[];

        foreach($choices as $k => $v) {
            $output[$v]= $k;
        } 
        return $output;
    }

}
