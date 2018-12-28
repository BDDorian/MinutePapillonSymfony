<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\User;
use App\Form\UserType;
use App\Form\LoginType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        //Currrent version for creating a form.
        $form = $this->createForm(UserType::class, $user);
        //Old Version of creating a form
        /*$form = $this->createFormBuilder($user)
                     ->add('name')
                     ->add('surname')
                     ->add('pseudo')
                     ->add('password')
                     ->add('comfirmPassword')
                     
                     ->getForm();
        */
         // get the results from the form registration.
         $form->handleRequest($request);
         //Check if the form is submitted and also valid
         if($form->isSubmitted() && $form->isValid())
         {
             $hash = $encoder->encodePassword($user, $user->getPassword());
             $user->setPassword($hash);
             $manager->persist($user);
             $manager->flush();

             return $this->redirectToRoute('security_connexion');
         }
         dump($user);

        return $this->render('security/register.html.twig', [
            'formRegistration' =>$form->createView()
        ]);
    } 
    
    
    /**
     * @Route("/connexion", name="security_connexion")
     */     
    public function login()
     {
         return $this->render('security/connexion.html.twig', [
         ]);
     }

     /**
      * @Route("/deconnexion", name="security_logout")
      */
      public function logout() {}
}
