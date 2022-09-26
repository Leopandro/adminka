<?php

namespace App\Infrastructure\Http\Resource;

use App\Domain\ClientReview\Model\ClientReview;
use App\Domain\Comment\Resource\CommentResource;
use App\Domain\SpecialistReview\Model\SpecialistReview;
use App\Domain\SpecialistReview\Resource\Client\SpecialistForReviewResource;
use App\Infrastructure\Media\Model\Media;

class ReviewResource extends JsonResource
{
    public function toArray($request): ?array
    {
        /** @var SpecialistReview|ClientReview $review */
        $review = $this->resource;

        if (!$review) {
            return null;
        }

        $specialist = $review->specialist;

        return [
            'id' => $review->id,
            'status' => new EnumResource($review->status),
            'review' => $review->review,
            'rating' => $review->rating,
            'published_at' => $review->published_at,
            'comment' => new CommentResource($review->lastComment),
            'anonymous' => $review->anonymous,
            'extra' => new SpecialistForReviewResource($review),
            'employee' => [
                'id' => $review->user_id,
                'name' => $review->user->short_name,
                'company' => $specialist->agency->name,
                'avatar' => new MediaResource($review->user->getFirstMedia(Media::COLLECTION_USER_AVATAR)),
            ],
        ];
    }
}
