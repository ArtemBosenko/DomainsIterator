<?php

namespace App\Controller;

use App\Entity\Domain;
use Twig\Environment;
use App\Repository\URLRepository;
use App\Repository\DataRepository;
use App\Repository\DomainRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DomainController extends AbstractController
{

    public $serializer;

    #[Route('/{limit}/{offset}', name: 'domains')]
    public function index( DomainRepository $domainRepository, $limit = null, $offset = null ): Response
    {
        $domains = $domainRepository->findBy(
            [],
            ['name' => 'ASC'],
            $limit,
            $offset
        );
        if(!empty( $domains ) ) {
            $this->serializer = $this->container->get('serializer');
            $domains = $this->getCleanDataArrayFromRaw($domains);
        } else {
            $domains = [];
        }
        $response = new JsonResponse();
        $response->setData($domains);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        // return $this->render(
        //     'domain/index.html.twig',
        //     [
        //         'domains' => \json_encode( $domains ),
        //     ]
        // );
    }

    // #[Route('/domain', name: 'domain/{id}')]
    // public function show(): Response 
    // {

    // }

    public function getCleanDataArrayFromRaw($raw_data): array 
    {
        $clean_data = [];
        foreach($raw_data as $key => $value) {
            if(is_object($value) && method_exists($value,'getValues')){
                $value = $this->getCleanDataArrayFromRaw($value->getValues());
            }
            $clean_data[$key] = $value;
        }
        return $clean_data;
    }

}
