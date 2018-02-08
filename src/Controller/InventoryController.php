<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Inventory;
use App\Model\Form\FilterType as Filter;
use App\Form\FilterType;

/**
 * InventoryController
 * @author aliaksei
 */
class InventoryController extends Controller
{
    /**
     * @Route("/", name="inventory_page")
     */
    public function index(Request $request, Inventory $inventoryService): Response
    {
        $filter = new Filter(new \DateTime());
        $form = $this->createForm(FilterType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData();
        }

        $inventory = $inventoryService->makeInventory($filter->requiredDate ?? new \DateTime());

        return $this->render('inventory/index.html.twig', [
            'inventory' => $inventory,
            'form' => $form->createView(),
        ]);
    }
}
