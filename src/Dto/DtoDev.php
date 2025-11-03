<?php

namespace App\Dto;

use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class DtoDev {
    
    public function __construct(
        
        #[Groups(['default', 'create', 'update'])]
        #[Assert\NotBlank(groups: ['default', 'create', 'update'])]
        #[OA\Property(type: 'string', minLength: 2, maxLength: 255/*, minMessage: 'Your title must be at least {{ limit }} characters long', maxMessage: 'Your title cannot be longer than {{ limit }} characters'*/)]
        public ?string $title = null,
    
        #[Groups(['default', 'create', 'update'])]
        #[OA\Property(type: 'string')]
        public ?string $description = null,

        #[Groups(['default', 'create', 'update'])]
        #[OA\Property(type: 'array')]
        public ?array $companies = null,

        #[Groups(['default', 'create', 'update'])]
        #[Assert\PositiveOrZero(groups: ['default', 'create', 'update'])]
        #[OA\Property(type: 'integer')]
        public ?int $experience = null,

        #[Groups(['default', 'create', 'update'])]
        #[OA\Property(type: 'boolean')]
        public ?bool $isParticipant = null,

        #[Groups(['default', 'create'])]
        #[OA\Property(type: 'string')]
        public ?\DateTimeImmutable $createdAt = null,

        #[Groups(['default', 'create', 'update'])]
        #[OA\Property(type: 'string')]
        public ?\DateTimeImmutable $updatedAt = null,
        
        #[Groups(['default'])]
        #[OA\Property(type: 'integer')]
        public int $page = 1,
        
        #[Groups(['default'])]
        #[OA\Property(type: 'integer')]
        public int $itemsPerPage = 4,
    ) {        
    }    
}