<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 16/07/2018
 * Time: 17:16
 */

namespace App\Controller;

use App\Entity\Ad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AdController extends Controller
{
    /**
     * @Route("/ad/add", name="Add ad")
     */
    public function addAction(Request $request)
    {
        $form = $this->createFormBuilder(new Ad())
            ->add(
                'title',
                TextType::class,
                array(
                    'constraints' =>
                        array(
                            new NotBlank(),
                            new NotNull(),
                        ),
                )
            )
            ->add(
                'description',
                TextareaType::class,
                array(
                    'constraints' =>
                        array(
                            new NotNull(),
                            new NotBlank(),
                        ),
                )
            )
            ->add(
                'city',
                TextType::class,
                array(
                    'constraints' =>
                        array(
                            new NotBlank(),
                            new NotNull(),
                        ),
                )
            )
            ->add(
                'zip',
                NumberType::class,
                array(
                    'constraints' => array(
                        new NotNull(),
                        new NotBlank(),
                        new Length(
                            array(
                                'min' => 5,
                                'max' => 5,
                            )
                        ),
                    ),
                )
            )
            ->add(
                'price',
                NumberType::class,
                array(
                    'constraints' => array(
                        new NotBlank(),
                        new NotNull(),
                    ),
                )
            )
            ->add(
                'poster',
                SubmitType::class
            )
            ->getForm();
        $form->handleRequest($request);

        return $this->render('add_ad.html.twig', array('form' => $form->createView()));
    }
}