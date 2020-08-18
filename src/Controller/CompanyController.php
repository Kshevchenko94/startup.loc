<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyContact;
use App\Entity\User;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use App\Service\FileUploader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/company")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/", name="company_index", methods={"GET"})
     * @param CompanyRepository $companyRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(CompanyRepository $companyRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $query = $companyRepository->findAllCompany();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('company/index.html.twig', [
            'companies' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="company_new", methods={"GET","POST"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        /** @var User $user */
        $user = $this->getUser();

        $company->setCreated($user);
        $company->setDateCreated(time());
        $company->setIsActive(true);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $logoFile */
            $logoFile = $form->get('logo')->getData();

            if ($logoFile) {
                $logoFileName = $fileUploader->upload($logoFile);
                $company->setLogo($logoFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('company_index');
        }

        return $this->render('company/new.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="company_show", methods={"GET"})
     * @param Company $company
     * @return Response
     */
    public function show(Company $company): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="company_edit", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param Company $company
     * @param EntityManagerInterface $entityManager
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function edit($id,Request $request, Company $company, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $originalContacts = new ArrayCollection();

        foreach ($company->getCompanyContacts() as $contact) {
            $originalContacts->add($contact);
        }

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($company->getIsDeleteLogo() === true){
                $fileUploader->remove($company->getLogo());
                $company->setLogo(NULL);
            }

            /** @var UploadedFile $logoFile */
            $logoFile = $form->get('logo')->getData();

            if ($logoFile) {
                $logoFileName = $fileUploader->upload($logoFile);
                $company->setLogo($logoFileName);
            }

            foreach ($originalContacts as $contact) {
                if (false === $company->getCompanyContacts()->contains($contact)) {
                   $company->removeCompanyContact($contact);
                    $entityManager->persist($contact);
                }
            }

            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('company_show',['id'=>$id]);
        }

        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="company_delete", methods={"DELETE"})
     * @param Request $request
     * @param Company $company
     * @return Response
     */
    public function delete(Request $request, Company $company): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('company_index');
    }
}
