<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CarCategory;
use App\Form\CarCategoryType;
use App\Service\CarCategoryService;

#[Route('/carCategory', name: "car_category")]
class CarCategoryController extends AbstractController
{
    /**
     * @var CarCategoryService
     */
    private $CarCategoryService;

    public function __construct(CarCategoryService $CarCategoryService)
    {
        $this->CarCategoryService = $CarCategoryService;
    }

    #[Route('/', name: '_index', methods: ['GET'])]
    public function list()
    {
        $list = $this->CarCategoryService->getCarCategory();

        return $this->render('carCategory/index.html.twig', [
            'list' => $list,
        ]);
    }

    #[Route('/new', name: '_new')]
    public function createCarCategory(Request $request)
    {
        $CarCategory = new CarCategory();
        $form = $this->createForm(CarCategoryType::class, $CarCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $CarCategory = $this->CarCategoryService->persist($CarCategory);

            $request->getSession()->getFlashBag()->add('success', 'ajout avec succée !');
            return $this->redirectToRoute('car_category_index');
        }

        return $this->render('carCategory/form.html.twig', array('form' => $form->createView(), 'carCategory' => $CarCategory));
    }

    #[Route('/update/{id}', name: '_update')]
    public function updateCarCategory(CarCategory $CarCategory, Request $request)
    {
        $form = $this->createForm(CarCategoryType::class, $CarCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Level = $this->CarCategoryService->persist($CarCategory);
            $request->getSession()->getFlashBag()->add('success', 'modification avec succée !');
            return $this->redirectToRoute('car_category_index');
        }

        return $this->render('carCategory/form.html.twig', array('form' => $form->createView(), 'carCategory' => $CarCategory));
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function deleteCarCategory(CarCategory $CarCategory, Request $request)
    {
        try {
            $this->CarCategoryService->remove($CarCategory);
            $request->getSession()->getFlashBag()->add('success', 'Level supprimée avec succès !');
        } catch (\Exception $exception) {
            $request->getSession()->getFlashBag()->add('danger', 'un ou plusieurs produit liés  à cette entité   !');
        }

        return $this->redirectToRoute('car_category_index');
    }
}
