<?php


namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    /**
     * @Route("/voyages/recherche/{champs}", name="voyagesFilter")
     * @param type $champs
     * @param Request $request
     * @return Response
     */
    public function findAllEqual($champs, Request $request): Response {
        $valeur = $request->get("Recherche");
        $visites = $this->repository->findByEqualValue($champs, $valeur);
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visites
        ]);
    }
}
