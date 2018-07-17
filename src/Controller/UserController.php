<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Description of UserController
 *
 * @author Administrateur
 */
class UserController extends Controller{
    
    /**
     * 
     * @Route("/inscription",name="inscription")
     */
    public function inscriptionAction(Request $request){
        $user = new User();
        $form = $this->createFormBuilder($user)
                ->add('username',TextType::class,array('constraints'=>array(new NotNull,
                        new Length(array('min' => '5', 'max'=> '50')))))
                ->add('email',TextType::class,array('constraints'=>array(new NotNull,
                        new Length(array('max'=> '255')))))
                ->add('password',TextType::class,array('constraints'=>array(new NotNull,
                        new Length(array('max'=> '255')))))
                ->add('valider',SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        
        
        if($form->isValid()){
            
            $em = $this->getDoctrine()->getManager();
            $insertUser = new User();
            $insertUser->setUsername($form->get('username')->getData());
            $insertUser->setEmail($form->get('email')->getData());
            $insertUser->setPassword($form->get('password')->getData());
            $insertUser->setRoles(Array("User"));
            $insertUser->setDateRegistered(New \DateTime());
            $em->persist($insertUser);
            $em->flush();
            
            return new Response('Utilisateur inséré');
        }
        
        return $this->render('inscription.html.twig', array('form'=>$form->createView()));

    }
}
