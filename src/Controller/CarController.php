<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Car;
use App\Form\CarType;
use App\Service\CarService;
use App\Service\CarCategoryService;

#[Route('/car', name: 'car')]
class CarController extends AbstractController
{
    /**
     * @var CarService
     */
    private $CarService;

    public function __construct(CarService $CarService)
    {
        $this->CarService = $CarService;
    }

    #[Route('/index', name: '_index')]
    public function list(Request $request, PaginatorInterface $PaginatorInterface)
    {
        $list = $this->CarService->getCar();
        $paginatedList = $PaginatorInterface->paginate($list, $request->query->getInt('page', 1), 20);
        return $this->render('car/index.html.twig', [
            'list' => $paginatedList,
        ]);
    }

    #[Route('/new', name: '_new')]
    public function createCar(Request $request)
    {
        $Car = new Car();
        $form = $this->createForm(CarType::class, $Car);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Car = $this->CarService->persist($Car);

            $request->getSession()->getFlashBag()->add('success', 'ajout avec succée !');
            return $this->redirectToRoute('car_index');
        }

        return $this->render('car/form.html.twig', array('form' => $form->createView(), 'car' => $Car));
    }

    #[Route('/update/{id}', name: '_update')]
    public function updateCar(Car $Car, Request $request)
    {
        $form = $this->createForm(CarType::class, $Car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Car = $this->CarService->persist($Car);
            $request->getSession()->getFlashBag()->add('success', 'modification avec succée !');
            return $this->redirectToRoute('car_index');
        }

        return $this->render('car/form.html.twig', array('form' => $form->createView(), 'car' => $Car));
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function deleteCar(Car $Car, Request $request)
    {
        try {
            $this->CarService->remove($Car);
            $request->getSession()->getFlashBag()->add('success', 'Car supprimée avec succès !');
        } catch (\Exception $exception) {
            $request->getSession()->getFlashBag()->add('danger', 'un ou plusieurs produit liés  à cette entité   !');
        }

        return $this->redirectToRoute('car_index');
    }

    #[Route('/search', name: '_by_name')]
    public function searchByName(Request $request, PaginatorInterface $PaginatorInterface)
    {
        $list = $this->CarService->getCar();
        if($request->get('car_name') != ''){
            $list = $this->CarService->getCar(['name'=> $request->get('car_name')]);
        }
        $paginatedList = $PaginatorInterface->paginate($list, $request->query->getInt('page', 1), 20);
        $template = $this->render('car/loop.html.twig', ['list'=>$paginatedList])->getContent();
        
        return new JsonResponse(['template'=>$template]);
    }
    #[Route('/filter', name: '_by_category')]
    public function filterByCategory(Request $request, PaginatorInterface $PaginatorInterface)
    {
        $list = $this->CarService->getCar();
        if($request->get('category_name') != ''){
            $list = $this->CarService->getCar(['category'=>$request->get('category_name')]);
        }
        $paginatedList = $PaginatorInterface->paginate($list, $request->query->getInt('page', 1), 20);
        $template = $this->render('car/loop.html.twig', ['list'=>$paginatedList])->getContent();
        
        return new JsonResponse(['template'=>$template]);
    }

    public function searchField()
    {
        return $this->render('car/searchField.html.twig');
    }
    public function categoryFilter(CarCategoryService $CarCategoryService)
    {
        $categories = $CarCategoryService->getCarCategory();
        return $this->render('car/categoryFilter.html.twig', ['categories'=>$categories]);
    }
}
