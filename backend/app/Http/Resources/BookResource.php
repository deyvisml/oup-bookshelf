<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $expired = true;
        if ($this->memberships_expiry_date) {
            $expired = $this->memberships_expiry_date < now() ? true : false;
        }

        $book_relative_url = Storage::url($this->zip_download_url);
        $book_absolute_url = url($book_relative_url);

        return [
            'id' => $this->public_id,
            'title' => $this->title,
            'series' => null,
            'category' => null,
            'author' => null,
            'description' => $this->description,
            'thumbnailUrl' => $this->thumbnail_url,
            'isbn' => null,
            'wordCount' => null,
            'startPage' => null,
            'endPage' => null,
            'type' => [
                'readers' => boolval($this->type_readers),
                'gradebook' => boolval($this->type_gradebook),
                'gradebookAnswerRevealable' => boolval($this->type_gradebook_answer_revealable),
                'classroomPresentation' => boolval($this->type_classroom_presentation),
            ],
            'version' => null,
            'publishDate' => null,
            'size' => $this->size,
            'status' => $expired ? 'EXPIRED' : 'LICENSED',
            'eCommerceUrl' => null,
            'downloadUrl' => null,
            'zipDownloadUrl' => $book_absolute_url,
            'cefrLevel' => null,
            'productId' => null,
            'updatedDate' => null,
            'teacherResourceId' => null,
            'accessible' => true,
            'readingDiary' => null,
            'license' => [
                'expired' => $expired,
                'expiryDate' => $this->memberships_expiry_date,
            ],
            'assignment' => [],
            'isDownloaded' => boolval($this->is_downloaded),
            'updateRequired' => false,
            'thumbnailFilepath' => $this->thumbnail_url,
        ];
    }
}
