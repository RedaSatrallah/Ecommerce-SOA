<?php

namespace App\Controller;

use App\Service\ProduitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController {
    private ProduitService $produitService;

    public function __construct(ProduitService $produitService) {
        $this->produitService = $produitService;
    }

    #[Route('/', name: 'home')]
    public function home(): Response {

        return $this->render('view/home.html.twig');
    }

    #[Route('/products', name: 'product_list')]
    public function index(): Response {
        $products = $this->produitService->getProduit();

        return $this->render('view/Products/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/products/add', name: 'product_add_form', methods: ['GET'])]
    public function addProductForm(): Response {
        // This method renders the product addition form
        return $this->render('view/Products/add.html.twig');
    }

    #[Route('/products/add', name: 'product_add', methods: ["POST"])]
    public function addProduct(Request $request): Response {
        $description = $request->request->get('description');
        $price = $request->request->get('price');
        $reference = $request->request->get('reference');
        $type = $request->request->get('type');

        // Prepare the data for the API call
        $data = [
            'description' => $description,
            'price' => $price,
            'reference' => $reference,
            'type' => $type,
        ];
        $products = $this->produitService->addProduit($data);

        return $this->redirectToRoute('product_list');
    }

    #[Route('/products/edit/{id}', name: 'product_edit_form', methods: ['GET'])]
    public function editProductForm(int $id): Response {
        $product = $this->produitService->getProduitById($id);

        return $this->render('view/Products/edit.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/products/edit/{id}', name: 'product_edit', methods: ["POST"])]
    public function updateProduct(Request $request, int $id): Response {

        $description = $request->request->get('description');
        $price = $request->request->get('price');
        $reference = $request->request->get('reference');
        $type = $request->request->get('type');

        // Préparer les données pour l'appel à l'API
        $data = [
            'description' => $description,
            'price' => $price,
            'reference' => $reference,
            'type' => $type,
        ];

        $this->produitService->editProduit($id, $data);

        return $this->redirectToRoute('product_list');
    }

    #[Route('/products/delete/{id}', name: 'product_delete_form', methods: ["GET"])]
    public function removeProductForm(Request $request, int $id): Response {
        $this->produitService->deleteProduit($id);

        return $this->redirectToRoute('product_list');
    }

}
