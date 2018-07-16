<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 16/07/2018
 * Time: 17:16
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends Controller
{
    /**
     * @Route("/ad/add", name="Add ad")
     */
    public function addAction(Request $request)
    {
        
    }
}