<?php

/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 16/07/2018
 * Time: 17:16
 */

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Category;
use App\Entity\User;
use App\Form\PictureType;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
use Symfony\Component\Validator\Constraints\Type;
use function dump;

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
            ->add(
                'pictures',
                CollectionType::class,
                array(
                    'entry_type' => PictureType::class,
                    'entry_options' => array('label' => false),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'label' => false,
                )
            )
            ->add(
                'poster',
                SubmitType::class
            )
            ->getForm();
        $form->handleRequest($request);
        dump($form);
        if ($form->isValid()) {
            foreach ($ad->getPictures()->getValues() as $key => $picture) {

                $path = $this->generateUniqueFileName().'.'.$picture->getPath()->guessExtension();
                $picture->getPath()->move($this->getParameter('pictures_directory'), $path);

                $picture->setPath($path);
                $ad->getPictures()->set($key, $picture);
            }
            $ad->setDateCreated(new DateTime());
            $ad->setUser($this->getUser());
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

    /**
     *
     * @Route("/favourites/{id}",name="favourites")
     */
    public function favAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ad = $em->find(Ad::class, $id);

        if ($this->getUser()->hasFavourite($ad)) {
            $this->getUser()->removeFavourite($ad);
        } else {
            $this->getUser()->addFavourite($ad);
        }


        $em->persist($ad);
        $em->flush();

        return $this->redirectToRoute("ad list");
    }

    /**
     * 
     * @Route("/unfavourites/{id}",name="unfavourites")
     */
    public function unfavAction($id) {
        $em = $this->getDoctrine()->getManager();
        $ad = $em->find(Ad::class, $id);


        $this->getUser()->removeFavourite($ad);



        $em->persist($ad);
        $em->flush();

        return $this->redirectToRoute("ad favlist");
    }

    /**
     * @Route("ad/favlist", name="ad favlist")
     */
    public function listFavAction() {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository(User::class);

        $user = $repo->find($this->getUser()->getId());

        return $this->render('listFav.html.twig', array('ads' => $user->getFavourite()->getValues()));
    }

    /**
     * @Route("ad/MyAd", name="ad mylist")
     */
    public function listMyAdAction(){
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository(Ad::class);

        $ads = $repo->findBy(array('user' => $this->getUser()), array());

        return $this->render('listMyAd.html.twig', array('ads' => $ads));
    }
}
