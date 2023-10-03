<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VisiteRepository;

/**
 * Description of VoyagesController
 *
 * @author add
 */
class VoyagesController extends AbstractController {
    
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
    * @Route("/voyages", name="voyages")
    * @return Response
    */
    public function index(): Response {
        $visites = $this->repository->findAllBy('datecreation', 'DESC');
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
    }
    
    /**
     * @Route("/voyages/tri/{champs}/{order}", name="voyagesTri")
     * @param type $champs
     * @param type $order
     * @return Response
     */
    public function sort($champs, $order): Response{
        $visites = $this->repository->findAllBy($champs, $order);
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
    }
}
