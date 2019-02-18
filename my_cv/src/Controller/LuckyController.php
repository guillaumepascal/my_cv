<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formations;
use App\Entity\Experience;
use App\Entity\Loisirs;

class LuckyController extends Controller
{
    public function number()
    {
        $number = random_int(0, 100);

        $forma = $this->getDoctrine()
        ->getRepository(Formations::class)
        ->findAll();
        
         $exp = $this->getDoctrine()
        ->getRepository(Experience::class)
        ->findAll();
        
         $loi = $this->getDoctrine()
        ->getRepository(Loisirs::class)
        ->findAll();
        
        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
            'formations'=>$forma,
            'experience'=>$exp,
            'loisirs'=>$loi,
        ));
    }
    
    /**
     * @Route("/admin")
     */
    public function admin()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
}