<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Formations;
use App\Form\FormationsType;

class FormationsController extends Controller
{
    public function create()
    {
        $formations = new Formations();
        $form = $this->createForm(FormationsType::class, $formations);
        
        return $this->render('formations/create.html.twig', [
            'entity' => $formations,
            'form' => $form->createView(),
            ]
        );
    }
    
    public function valid(Request $request)
    {
        $formations = new Formations();
        $form= $this->createForm(FormationsType::class, $formations);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $formations = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formations);
            $entityManager->flush();
        
            return $this->redirectToRoute('index');
        }
        
        return $this->render('formations/create.html.twig', [
            'entity' => $formations,
            'form' => $form->createView(),
            ]
        );
    }
}