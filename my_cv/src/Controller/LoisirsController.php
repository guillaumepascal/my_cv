<?php

namespace App\Controller;

use App\Entity\Loisirs;
use App\Form\LoisirsType;
use App\Repository\LoisirsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/loisirs")
 */
class LoisirsController extends Controller
{
    /**
     * @Route("/", name="loisirs_index", methods={"GET"})
     */
    public function index(LoisirsRepository $loisirsRepository): Response
    {
        return $this->render('loisirs/index.html.twig', [
            'loisirs' => $loisirsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="loisirs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $loisir = new Loisirs();
        $form = $this->createForm(LoisirsType::class, $loisir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loisir);
            $entityManager->flush();

            return $this->redirectToRoute('loisirs_index');
        }

        return $this->render('loisirs/new.html.twig', [
            'loisir' => $loisir,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loisirs_show", methods={"GET"})
     */
    public function show(Loisirs $loisir): Response
    {
        return $this->render('loisirs/show.html.twig', [
            'loisir' => $loisir,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="loisirs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Loisirs $loisir): Response
    {
        $form = $this->createForm(LoisirsType::class, $loisir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('loisirs_index', [
                'id' => $loisir->getId(),
            ]);
        }

        return $this->render('loisirs/edit.html.twig', [
            'loisir' => $loisir,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="loisirs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Loisirs $loisir): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loisir->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($loisir);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loisirs_index');
    }
}
