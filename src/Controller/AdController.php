<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 16/07/2018
 * Time: 17:16
 */

namespace App\Controller;

use App\Entity\Ad;
use App\Form\PictureType;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
        $ad = new Ad();
        $form = $this->createFormBuilder($ad)
            ->add(
                'title',
                TextType::class,
                array(
                    'constraints' =>
                        array(
                            new NotBlank(),
                            new NotNull(),
                        ),
                    'label' => 'Titre',
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
                    'label' => 'Ville',
                )
            )
            ->add(
                'zip',
                IntegerType::class,
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
                        new Type('Integer'),
                    ),
                    'label' => 'Code postal',
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
                    'label' => 'Prix',
                )
            )
            ->add(
                'category',
                EntityType::class,
                array(
                    'class' => Category::class,
                    'label' => 'Catégorie',
                )
            )
            ->add('picture', PictureType::class)
            ->add(
                'poster',
                SubmitType::class
            )
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $file = $ad->getPicture();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $product->setBrochure($fileName);

            
            $ad->setDateCreated(new DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($ad);
            $em->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->render('add_ad.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("ad/list", name="ad list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository(Ad::class);

        $ads = $repo->findBy(array(), array('category' => 'ASC'));

        return $this->render('listAd.html.twig', array('ads' => $ads));
    }

    /**
     * @Route("add/get/{id}", name="get ad")
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ad = $em->find(Ad::class, $id);

        return $this->render('getAd.html.twig', array('ad' => $ad));

    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
    
}