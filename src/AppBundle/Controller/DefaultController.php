<?php

namespace AppBundle\Controller;

use AppBundle\Entity\addCalories;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('meals_list');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        $addCalories = new addCalories();

        $form = $this->createFormBuilder($addCalories)
            ->add('calories', IntegerType::class , array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('date',DateType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
           ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $addCalories = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($addCalories);
            $em->flush();
            $this->addFlash(
                'notice',
                'Calories Added'
            );

        }

        return $this->render('@App/admin/add.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
