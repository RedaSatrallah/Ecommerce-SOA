<?php

namespace App\Controller;

use App\Service\FactureService;
use App\Service\ClientService;
use App\Service\ProduitService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FactureController extends AbstractController
{
    private FactureService $factureService;
    private ClientService $clientService;
    private ProduitService $produitService;

    public function __construct(FactureService $factureService, ClientService $clientService, ProduitService $produitService) {
        $this->factureService = $factureService;
        $this->clientService = $clientService;
        $this->produitService = $produitService;
    }

    #[Route('/factures', name: 'facture_list')]
    public function index(): Response {
        $factures = $this->factureService->getFactures();

        foreach ($factures as &$facture) {
            $facture['client'] = $this->clientService->getClientById($facture['clientId']);
            foreach ($facture['products'] as &$product) {
                $product = $this->produitService->getProduitById($product['id']);
            }
        }

        return $this->render('view/Factures/index.html.twig', ['factures' => $factures]);
    }
    #[Route('/facture/{id}', name: 'facture_detail')]
    public function factureDetail($id): Response {
        $facture = $this->factureService->getFacturesById($id);
        $facture['client'] = $this->clientService->getClientById($facture['clientId']);
        
        foreach ($facture['products'] as &$product) {
            $product = $this->produitService->getProduitById($product['id']);
        }
    
        return $this->render('view/Factures/detail.html.twig', ['facture' => $facture]);
    }
    

    #[Route('/factures/add', name: 'facture_add_form', methods:['GET'])]
    public function addForm(): Response {
        return $this->render('view/Factures/add.html.twig');
    }

    #[Route('/factures/add', name: 'facture_add', methods: ['POST'])]
    public function addFacture(Request $request): Response {
        $data = [
            'clientId' => $request->request->get('clientId'),
            'total' => $request->request->get('total'),
            'products' => $request->request->all('products'),
        ];

        $this->factureService->addFacture($data);
        return $this->redirectToRoute('facture_list');
    }

    #[Route('/factures/edit/{id}', name: 'facture_edit_form', methods:['GET'])]
    public function editForm($id): Response {
        $facture = $this->factureService->getFacturesById($id);
        $facture['client'] = $this->clientService->getClientById($facture['clientId']);
        foreach ($facture['products'] as &$product) {
            $product = $this->produitService->getProduitById($product['id']);
        }

        return $this->render('view/Factures/edit.html.twig', ['facture' => $facture]);
    }

    #[Route('/factures/edit/{id}', name: 'facture_edit', methods: ['POST'])]
    public function updateFacture(Request $request, $id): Response {
        $data = [
            'clientId' => $request->request->get('clientId'),
            'total' => $request->request->get('total'),
            'products' => $request->request->all('products'),
        ];

        $this->factureService->editFacture($id, $data);
        return $this->redirectToRoute('facture_list');
    }

    #[Route('/factures/delete/{id}', name: 'facture_delete', methods: ['GET'])]
    public function deleteFacture($id): Response {
        $this->factureService->deleteFacture($id);
        return $this->redirectToRoute('facture_list');
    }
}
