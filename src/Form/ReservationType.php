<?php

namespace App\Form;

use App\Model\ReservationModel;
use App\Model\UserModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Places', NumberType::class, [
                'label' => 'Places à réserver',
                'empty_data'=>1
            ])
            ->add('prixTotal', NumberType::class, [
                'label' => 'Montant',
                'disabled' => true,

            ])
            ->add('idSeance', hiddenType::class, [
                'mapped'=>false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => ReservationModel::class
        ]);
    }
}
