<?php

namespace App\Controller;

use App\Dto\DtoDev;
use App\Entity\Developer;
use OpenApi\Attributes as OAT;
use App\Repository\DeveloperRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/v1', name: 'api', methods: ['GET'])]
#[OAT\Tag(name: 'Developer')]
final class APIController extends AbstractController
{
    #[Route('/developers', name: '_developers_list', methods: ['GET'])]    
    #[OAT\Get(
        description: 'Get developers list',
        parameters: [
            new OAT\Parameter(
                name: 'title', 
                in: 'query', 
                description: 'Filter by developer title.',
                schema: new OAT\Schema(type: 'string')
            ),            
            new OAT\Parameter(
                name: 'description', 
                in: 'query', 
                description: 'Filter by description keyword.',
                schema: new OAT\Schema(type: 'string')
            ),            
            new OAT\Parameter(
                name: 'companies', 
                in: 'query', 
                explode: true,
                style: 'form', 
                description: 'Filter by one or more companies.',
                schema: new OAT\Schema(
                    type: 'array',
                    items: new OAT\Items(type: "string", example: "Tech Inc.") 
                )
            ),            
            new OAT\Parameter(
                name: 'experience', 
                in: 'query', 
                description: 'Filter by minimum years of experience.',
                schema: new OAT\Schema(type: 'integer')
            ),            
            new OAT\Parameter(
                name: 'isParticipant', 
                in: 'query', 
                description: 'Filter by participation status.',
                schema: new OAT\Schema(type: 'boolean')
            ),            
            new OAT\Parameter(
                name: 'query', 
                in: 'query',
                description: 'Developer schema',
                schema: new OAT\Schema(ref: new Model(type: Developer::class)),                
                style: 'form', 
                explode: true
            ),
        ]
    )]  
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $arrayDevObjs = $em->getRepository(Developer::class)->findAll(); 
               
        return $this->json($arrayDevObjs);
    }

    #[Route('/developer/{id}', name: '_developer_show', methods: ['GET'])]     
    #[OAT\Get(description: 'Get a developer')]    
    public function show(?int $id, EntityManagerInterface $em): JsonResponse
    {
        $devObj = $em->getRepository(Developer::class)->find($id);
            
        return $this->json($devObj);
    }

    #[Route('/developer/{id}', name: '_developer_delete', methods: ['DELETE'])]       
    public function delete(?int $id, EntityManagerInterface $em): JsonResponse
    {
        $devObj = $em->getRepository(Developer::class)->find($id);  
        
        if (!$devObj) {
            return $this->json(['message' => 'Developer not found'], 404);
        }
        
        $em->remove($devObj);
        $em->flush();
        
        return $this->json('resource deleted', 200);
    }
}