<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Twig\Template;

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
    public function inscriptionAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $form = $this->createFormBuilder($user)
                ->add('username',TextType::class,array('label'=>"Pseudonyme",'constraints'=>array(new NotNull,
                        new Length(array('min' => '5', 'max'=> '50')))))
                ->add('email',TextType::class,array('label'=>"Email",'constraints'=>array(new NotNull,
                        new Length(array('max'=> '255')))))
                ->add('password',PasswordType::class,array('constraints'=>array(new NotNull,
                        new Length(array('max'=> '255')))))
                ->add('password', RepeatedType::class, array(
                        'label'=>"Répétez votre mot de passe",
                        'type' => PasswordType::class,
                        'invalid_message' => 'Le mot de passe doit être le même.',
                        'options' => array('attr' => array('class' => 'password-field')),
                        'required' => true,
                        'first_options'  => array('label' => 'Mot de passe'),
                        'second_options' => array('label' => 'Répétez votre mot de passe'),
                    ))
                ->add('valider',SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        
        
        if($form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            
            $em = $this->getDoctrine()->getManager();
            $user->setRoles(Array("User"));
            $user->setDateRegistered(New DateTime());
            $em->persist($user);
            $em->flush();
            
            return new Response('Utilisateur inséré');
        }
        
        return $this->render('inscription.html.twig', array('form'=>$form->createView()));

    }
       
    /**
     * 
     * @Route("/login",name="login")
     */
    /*
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('accueil.html.twig', array(
                    'last_username' => $lastUsername,
                    'error' => $error,
        ));
    }
    */
}
