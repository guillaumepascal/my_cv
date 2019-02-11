<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Experiences;
use App\Form\ExperiencesType;

class ExperiencesController extends Controller
{
    public function create()
    {
        $experiences = new Experiences();
        $form = $this->createForm(ExperiencesType::class, $experiences);
        
        return $this->render('experiences/create.html.twig', [
            'entity' => $experiences,
            'form' => $form->createView(),
            ]
        );
    }
    
    public function valid(Request $request)
    {
        $experiences = new Experiences();
        $form= $this->createForm(ExperiencesType::class, $experiences);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $experiences = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($experiences);
            $entityManager->flush();
        
            return $this->redirectToRoute('index');
        }
        
        return $this->render('experiences/create.html.twig', [
            'entity' => $experiences,
            'form' => $form->createView(),
            ]
        );
    }
}