<?php

namespace AppBundle\Controller;

use AppBundle\Entity\meal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;

class mealsController extends Controller
{
    /**
     * @Route("/list", name="meals_list")
     */
    public function ListAction()
    {
        $meal = $this->getDoctrine()
            ->getRepository("AppBundle:meal")
            ->findAll();

        $addCalories = $this->getDoctrine()
            ->getRepository("AppBundle:addCalories")
            ->findAll();

        return $this->render('AppBundle:meals:list.html.twig', array(
            'meals' => $meal,
            'addCalories' => $addCalories
        ));
    }

    /**
     * @Route("/create", name="meals_add")
     */
    public function createAction(Request $request)
    {
        $meal = new meal();

        $form = $this->createFormBuilder($meal)
            ->add('text',TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('calories', IntegerType::class , array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('date',DateType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
            ->add('time',TimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $meal = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($meal);
            $em->flush();
            $this->addFlash(
                'notice',
                'Meal Added'
            );
            return $this->redirectToRoute('meals_list');
        }

        return $this->render('AppBundle:meals:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{id}", name="meals_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $meal = $em->getRepository("AppBundle:meal")->find($id);
        $em->remove($meal);
        $em->flush();
        $this->addFlash(
            'notice',
            'Meal Removed'
        );
        return $this->redirectToRoute('meals_list');
    }

    /**
     * @Route("/edit/{id}", name="meals_edit")
     */
    public function editAction($id, Request $request)
    {
        $meal = $this->getDoctrine()
            ->getRepository("AppBundle:meal")
            ->find($id);

        $form = $this->createFormBuilder($meal)
            ->add('text',TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('calories', IntegerType::class , array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('date',DateType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
            ->add('time',TimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash(
                'notice',
                'Meal Updated'
            );
            return $this->redirectToRoute('meals_list');
        }

        return $this->render('AppBundle:meals:edit.html.twig', array(
            'form' => $form->createView()
        ));

    }


}
