<?php

namespace App\Service;

use App\Domain\User\Data\UserReaderData;
use App\Domain\User\Repository\UserReaderRepository;
use App\Exception\ValidationException;
use App\Repository\FeedReaderRepository;

/**
 * Service.
 */
final class FeedReader
{
    /**
     * @var UserReaderRepository
     */
    private $feedReaderRepository;

    /**
     * The constructor.
     *
     * @param UserReaderRepository $repository The repository
     */
    public function __construct(FeedReaderRepository $feedReaderRepository)
    {
        $this->feedReaderRepository = $feedReaderRepository;
    }

    /**
     * Read a user by the given user id.
     *
     * @param int $userId The user id
     *
     * @throws ValidationException
     *
     * @return UserReaderData The user data
     */
    public function getAllFeedsPostDate(string $createdAt)
    {
        // Validation
        // if (empty($userId)) {
        //     throw new ValidationException('User ID required');
        // }

        return $this->feedReaderRepository->getAllFeedsPostDate($createdAt);
    }
}