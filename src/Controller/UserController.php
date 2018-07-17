<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of UserController
 *
 * @author Administrateur
 */
class UserController extends Controller{
    
    public function inscriptionAction(Request $request){
        $user = new Comment();
        $form = $this->createFormBuilder($comment)
                ->add('title',TextType::class,array('constraints'=>array(new NotNull,
                        new Length(array('min' => '5', 'max'=> '150')))))
                ->add('description',TextType::class,array('constraints'=>array(new NotNull,
                        new Length(array('min' => '20', 'max'=> '255')))))
                ->add('valider','submit')
                ->getForm();
        $form->handleRequest($request);
    }
}
