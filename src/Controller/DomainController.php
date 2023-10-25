<?php

namespace App\Controller;

use App\Entity\Domain;
use App\Repository\DomainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DomainController extends AbstractController
{
    public $serializer;

    #[Route('/domains/{limit}/{offset}', name: 'domains')]
    public function index(DomainRepository $domainRepository, $limit = null, $offset = null): Response
    {
        $domains = $domainRepository->findBy(
            [],
            ['name' => 'ASC'],
            $limit,
            $offset
        );

        return $this->jsonResponse($domains);
        // return $this->render(
        //     'domain/index.html.twig',
        //     [
        //         'domains' => \json_encode( $domains ),
        //     ]
        // );
    }

    #[Route('domain/{id}', name: 'domain')]
    public function show(DomainRepository $domainRepository, $id = null): Response
    {
        $domain = $domainRepository->findOneBy(
            ['id' => $id]
        );
        $domain = !empty($domain) && $domain instanceof Domain ? $domain->getValues() : [];

        return $this->jsonResponse($domain);
    }

    /**
     * Summary of jsonResponse.
     *
     * @return JsonResponse
     */
    public function jsonResponse($data)
    {
        if (!empty($data)) {
            $this->serializer = $this->container->get('serializer');
            $data = $this->getCleanDataArrayFromRaw($data);
        } else {
            $data = [];
        }
        $response = new JsonResponse();
        $response->setData($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Summary of getCleanDataArrayFromRaw.
     */
    public function getCleanDataArrayFromRaw($raw_data): array
    {
        $clean_data = [];
        foreach ($raw_data as $key => $value) {
            if (is_object($value) && method_exists($value, 'getValues')) {
                $value = $this->getCleanDataArrayFromRaw($value->getValues());
            }
            $clean_data[$key] = $value;
        }

        return $clean_data;
    }
}
