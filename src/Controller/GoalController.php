<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Form\GoalType;
use App\Repository\GoalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/goals")
 */
class GoalController extends AbstractController
{
    /**
     * @Route("/", name="goal_index", methods={"GET"})
     * @param GoalRepository $goalRepository
     * @return Response
     */
    public function index(GoalRepository $goalRepository): Response
    {
        return $this->render('goal/index.html.twig', [
            'goals' => $goalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="goal_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $goal = new Goal();
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid() && $user !== null) {
            $entityManager = $this->getDoctrine()->getManager();
            $goal->setDateCreated(time());
            $goal->setCreated($user);
            $entityManager->persist($goal);
            $entityManager->flush();

            return $this->redirectToRoute('goal_index');
        }

        return $this->render('goal/new.html.twig', [
            'goal' => $goal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="goal_show", methods={"GET"})
     * @param Goal $goal
     * @return Response
     */
    public function show(Goal $goal): Response
    {
        return $this->render('goal/show.html.twig', [
            'goal' => $goal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="goal_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Goal $goal
     * @return Response
     */
    public function edit(Request $request, Goal $goal): Response
    {
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('goal_index');
        }

        return $this->render('goal/edit.html.twig', [
            'goal' => $goal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="goal_delete", methods={"DELETE"})
     * @param Request $request
     * @param Goal $goal
     * @return Response
     */
    public function delete(Request $request, Goal $goal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$goal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($goal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('goal_index');
    }
}
