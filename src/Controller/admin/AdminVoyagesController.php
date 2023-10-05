<?php

namespace App\Controller\admin;

/**
 * Description of AdminVoyagesController
 *
 * @author add
 */

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of VoyagesController
 *
 * @author add
 */
class AdminVoyagesController extends AbstractController {
    
    /**
     * 
     * @var VisiteRepository
     */
    private VisiteRepository $repository;
    
    /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository) {
        $this->repository = $repository;
    }

    /**
    * 
    * @Route("/admin", name="admin.voyages")
    * @return Response
    */
    public function index(): Response {
        $visites = $this->repository->findAllBy('datecreation', 'DESC');
        return $this->render("pages/admin/admin.voyages.html.twig", [
            'visites' => $visites
        ]);
    }
    
    /**
     * @Route("/admin/suppr/{id}", name="admin.voyage.suppr")
     * @return Response
     */
    public function suppr(Visite $visite): Response{
        $this->repository->remove($visite, true);
        return $this->redirectToRoute('admin.voyages');
    }
}