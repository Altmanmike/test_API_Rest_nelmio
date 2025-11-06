<?php

namespace App\Controller;

use App\Dto\DtoDev;
use DateTimeImmutable;
use App\Entity\Developer;
use OpenApi\Attributes as OAT;
use App\Repository\DeveloperRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/v1', name: 'api', methods: ['GET'])]
#[OAT\Tag(name: 'Developer')]
final class APIController extends AbstractController
{
    /**
     * list
     *
     * @param  mixed $em
     * @return JsonResponse
     */
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
        ]
    )]
    #[OAT\Response(
        response: 200,
        description: "Developer schema",
        content: new OAT\JsonContent(
            type: "object",
            properties: [
                new OAT\Property(property: "id", type: "integer", example: 1),
                new OAT\Property(property: "title", type: "string", example: "Developer job"),
                new OAT\Property(property: "description", type: "string", example: "Description of the developer job"),
                new OAT\Property(property: "companies", type: "array", items:
                    new OAT\Items(type: "string",                        
                            description: "An array of companies names",
                            example: "Comp Inc., DevLab"
                        )),                         
                new OAT\Property(property: "isParticipant", type: "boolean", example: false),                
                new OAT\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-01-16T14:30:00Z"),
                new OAT\Property(property: "updatedAt", type: "string", format: "date-time", example: "2025-01-16T14:30:00Z")
            ]
        )
    )]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $arrayDevObjs = $em->getRepository(Developer::class)->findAll();
                       
        return $this->json($arrayDevObjs);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @param  mixed $em
     * @return JsonResponse
     */
    #[Route('/developer/{id}', name: '_developer_show', methods: ['GET'])]     
    #[OAT\Get(description: 'Get a developer')]    
    #[OAT\Response(
        response: 200,
        description: "Developer schema",
        content: new OAT\JsonContent(
            type: "object",
            properties: [
                new OAT\Property(property: "id", type: "integer", example: 1),
                new OAT\Property(property: "title", type: "string", example: "Developer job"),
                new OAT\Property(property: "description", type: "string", example: "Description of the developer job"),
                new OAT\Property(property: "companies", type: "array", items:
                    new OAT\Items(type: "string",                        
                            description: "An array of companies names",
                            example: "Comp Inc., DevLab"
                        )),                         
                new OAT\Property(property: "isParticipant", type: "boolean", example: false),                
                new OAT\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-01-16T14:30:00Z"),
                new OAT\Property(property: "updatedAt", type: "string", format: "date-time", example: "2025-01-16T14:30:00Z")
            ]
        )
    )]
    #[OAT\Response(
        response: 404,
        description: "Resource not found",       
    )]
    public function show(?int $id, EntityManagerInterface $em): JsonResponse
    {
        $devObj = $em->getRepository(Developer::class)->find($id);
        
        if (!$devObj) {
            return $this->json(['message' => 'Resource not found'], 404);
        }  
          
        return $this->json($devObj);
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @param  mixed $em
     * @return JsonResponse
     */
    #[Route('/developer/{id}', name: '_developer_delete', methods: ['DELETE'])]
    #[OAT\Delete(description: 'Delete a developer')]
    #[OAT\Response(
        response: 204,
        description: "Resource deleted",        
    )] 
    #[OAT\Response(
        response: 404,
        description: "Resource not found",       
    )] 
    public function delete(?int $id, EntityManagerInterface $em): JsonResponse
    {
        $devObj = $em->getRepository(Developer::class)->find($id);  
        
        if (!$devObj) {
            return $this->json(['message' => 'Resource not found'], 404);
        }
        
        $em->remove($devObj);
        $em->flush();
        
        return $this->json('resource deleted', 200);
    }

    /**
     * create
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    #[Route('/developer', name: '_developer_create', methods: ['POST'])]
    #[OAT\Post(description: 'Create a new developer')]  
    #[OAT\RequestBody(
        required: true,
        content: new OAT\JsonContent(
            type: "object",
            required: ["title", "description", "companies", "experience", "isParticipant"],
            properties: [
                new OAT\Property(property: "title", type: "string", example: "Developer Full Stack"),
                new OAT\Property(property: "description", type: "string", example: "The description of the work..."),
                new OAT\Property(property: "companies", type: "array", items:
                    new OAT\Items(type: "string",                        
                            description: "An array of name's companies",
                            example: "Comp Inc., DevLab"
                        )),               
                new OAT\Property(property: "experience", type: "integer", example: 5),
                new OAT\Property(property: "isParticipant", type: "boolean", example: false),                
            ]
        )
    )]
    #[OAT\Response(
        response: 201,
        description: "Developer created successfully",
        content: new OAT\JsonContent(
            type: "object",
            properties: [
                new OAT\Property(property: "id", type: "integer", example: 1),
                new OAT\Property(property: "title", type: "string", example: "Developer job"),
                new OAT\Property(property: "description", type: "string", example: "Description of the developer job"),
                new OAT\Property(property: "companies", type: "array", items:
                    new OAT\Items(type: "string",                        
                            description: "An array of companies names",
                            example: "Comp Inc., DevLab"
                        )),                         
                new OAT\Property(property: "isParticipant", type: "boolean", example: false),                
                new OAT\Property(property: "createdAt", type: "string", format: "date-time", example: "2025-01-16T14:30:00Z"),
                new OAT\Property(property: "updatedAt", type: "string", format: "date-time", example: "2025-01-16T14:30:00Z")
            ]
        )
    )]    
    public function create(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $jsonDev = $request->getContent();
        $arrayDevObj = json_decode($jsonDev, true);        
        
        if (!isset($arrayDevObj['title'], $arrayDevObj['description'], $arrayDevObj['companies'], $arrayDevObj['experience'], $arrayDevObj['isParticipant']) && (gettype($arrayDevObj['isParticipant']) != 'boolean') && (!is_array($arrayDevObj['companies']))) {            
            return $this->json(['error' => 'Invalid input data'], 400);
        }

        try {
            /** @var DtoDev $newDtoDev */
            $newDtoDev = $serializer->deserialize($jsonDev, DtoDev::class, 'json');
        } catch (\Exception $e) {            
            return $this->json(['error' => 'Invalid JSON payload: ' . $e->getMessage()], 400);
        }
        
        $newDev =  new Developer();
        
        $newDev->setTitle($newDtoDev['title'])
            ->setDescription($newDtoDev['description'])
            ->setCompanies($newDtoDev['companies'])
            ->setExperience($newDtoDev['experience'])
            ->setIsParticipant($newDtoDev['isParticipant'])
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTimeImmutable());
               
        $em->persist($newDev);
        $em->flush();
               
        return $this->json($newDev);    
    }
}