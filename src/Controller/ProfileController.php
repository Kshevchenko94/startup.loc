<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile")
     */
    public function index()
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws DBALException
     */
    public function search(Request $request, UserRepository $userRepository):JsonResponse
    {
        if($request->isXmlHttpRequest() && $this->getUser()){
            $data = $request->query->get('q')?? $this->getUser()->getUsername();
            $users = $userRepository->findOneBySomeField($data);
            return $this->json(['items'=>$users]);
        }
    }
}
