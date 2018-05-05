<?php
/**
 * Created by PhpStorm.
 * User: Beatelhouse
 * Date: 16/02/2018
 * Time: 0:34
 */

namespace App\Form;


use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class PruebaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $category = new Category();
        $builder->add('id', EntityType::class, array(
            'class' => Category::class,

            // uses the User.username property as the visible option string
            'choice_label' => function ($category) {
                return $category->getDisplayId();
            }
        ));
    }


}