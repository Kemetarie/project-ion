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
 * Description of FavouriteController
 *
 * @author Administrateur
 */
class FavouriteController extends Controller {

    /**
     * @Route("/addfav",name="addfavourite")
     */
    public function addFavAction() {
        
    }

    /**
     * @Route("/favourites",name="favourites")
     */
    public function listFavAction() {
        
    }

}
