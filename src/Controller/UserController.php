<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Description of UserController
 *
 * @author Administrateur
 */
class UserController extends Controller{
    
    public function inscriptionAction(Request $request){
        $user = new User();
        $form = $this->createFormBuilder($user)
                ->add('Nom d\'utilisateur',TextType::class,array('constraints'=>array(new NotNull,
                        new Length(array('min' => '5', 'max'=> '50')))))
                ->add('email',TextType::class,array('constraints'=>array(new NotNull,
                        new Length(array('max'=> '255')))))
                ->add('valider','submit')
                ->getForm();
        $form->handleRequest($request);
    }
}
