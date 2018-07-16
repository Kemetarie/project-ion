<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of DefaultController
 *
 * @author Administrateur
 */
class DefaultController extends Controller {
    
    /**
     * 
     * @Route("/accueil",name="Accueil")
     */
    public function indexAction() {
        return $this->render('accueil.html.twig');
    }
    
    /**
     * 
     * @Route("/faq",name="FAQ")
     */
    public function faqAction() {
        return $this->render('FAQ.html.twig');
    }
    
    /**
     * 
     * @Route("/cgu",name="CGU")
     */
    public function cguAction() {
        return $this->render('CGU.html.twig');
    }
}
