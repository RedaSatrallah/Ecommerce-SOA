<?php

namespace App\Controller;

use App\Service\ClientService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    private ClientService $clientService;

    public function __construct(ClientService $clientService) {
        $this->clientService = $clientService;
    }

    #[Route('/clients', name: 'client_list')]
    public function index(): Response {
        $clients = $this->clientService->getClients();
        return $this->render('view/Clients/index.html.twig', ['clients' => $clients]);
    }

    #[Route('/clients/add', name: 'client_add_form', methods: ['GET'])]
    public function addForm(): Response {
        return $this->render('view/Clients/add.html.twig');
    }

    #[Route('/clients/add', name: 'client_add', methods: ['POST'])]
    public function addClient(Request $request): Response {
        $data = [
            'firstName' => $request->request->get('firstName'),
            'lastName' => $request->request->get('lastName'),
            'address' => $request->request->get('address'),
            'phone' => $request->request->get('phone'),
            'city' => $request->request->get('city'),
        ];

        $this->clientService->addClient($data);
        return $this->redirectToRoute('client_list');
    }

    #[Route('/clients/edit/{id}', name: 'client_edit_form', methods: ['GET'])]
    public function editForm($id): Response {
        $client = $this->clientService->getClientById($id);
        return $this->render('view/Clients/edit.html.twig', ['client' => $client]);
    }

    #[Route('/clients/edit/{id}', name: 'client_edit', methods: ['POST'])]
    public function updateClient(Request $request, $id): Response {

        $data = [
            'firstName' => $request->request->get('firstName'),
            'lastName' => $request->request->get('lastName'),
            'address' => $request->request->get('address'),
            'phone' => $request->request->get('phone'),
            'city' => $request->request->get('city'),
        ];

        $this->clientService->editClient($id, $data);
        return $this->redirectToRoute('client_list');
    }

    #[Route('/clients/delete/{id}', name: 'client_delete', methods: ['GET'])]
    public function deleteClient($id): Response {
        $this->clientService->deleteClient($id);
        return $this->redirectToRoute('client_list');
    }
}
