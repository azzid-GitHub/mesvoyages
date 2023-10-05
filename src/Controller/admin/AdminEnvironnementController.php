<?php


namespace App\Controller\admin;

use App\Entity\Environnement;
use App\Entity\Visite;
use App\Repository\EnvironnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of AdminEnvironnementController
 *
 * @author add
 */
class AdminEnvironnementController extends AbstractController{
    /**
     * 
     * @var EnvironnementRepository
     */
    private EnvironnementRepository $repository;
    
    /**
     * 
     * @param EnvironnementRepository $repository
     */
    public function __construct(EnvironnementRepository $repository) {
        $this->repository = $repository;
    }

    /**
    * 
    * @Route("/admin/environnements", name="admin.environnements")
    * @return Response
    */
    public function index(): Response {
        $environnements = $this->repository->findAll();
        return $this->render('pages/admin/admin.environnements.html.twig', [
            'environnements' => $environnements
        ]);
    }
    
     /**
     * @Route("/admin/environnements/suppr/{id}", name="admin.environnement.suppr")
     * @param Visite $visite
     * @return Response
     */
    public function suppr(Environnement $environnements): Response{
        $this->repository->remove($environnements, true);
        return $this->redirectToRoute('admin.environnements');
    }
    
    /**
     * @Route("/admin/environnements/ajout", name="admin.environnement.ajout")
     * @param Request $request
     * @return Response
     */
    function ajout(Request $request) : Response {
        $nomEnvironnement = $request->get("nom");
        $environnement = new Environnement();
        $environnement->setNom($nomEnvironnement);
        $this->repository->add($environnement, true);
        return $this->redirectToRoute('admin.environnements');
    }
}
