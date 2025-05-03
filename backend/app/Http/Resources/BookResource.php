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

        if (!empty($this->zip_download_google_drive_file_id)) {
            $drive_download_book_url_template = 'https://drive.usercontent.google.com/download?id=[FILE_ID]&export=download&confirm=xxx&uuid=xxx&bookId=[BOOK_ID]';
            $book_absolute_url = str_replace('[FILE_ID]', $this->zip_download_google_drive_file_id, $drive_download_book_url_template);
            $book_absolute_url = str_replace('[BOOK_ID]', $this->public_id, $book_absolute_url);
        }

        $thumbnail_relative_url = Storage::url($this->thumbnail_url);
        $thumbnail_absolute_url = url($thumbnail_relative_url);

        return [
            'is_cracked' => true,
            'id' => $this->public_id,
            'title' => $this->title,
            'series' => null,
            'category' => null,
            'author' => null,
            'description' => $this->description,
            'thumbnailUrl' => $thumbnail_absolute_url,
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
            'version' => $this->version,
            'publishDate' => null,
            'size' => $this->size,
            'status' => $expired ? 'EXPIRED' : 'LICENSED',
            'eCommerceUrl' => null,
            'downloadUrl' => null,
            'zipDownloadUrl' => $book_absolute_url,
            'cefrLevel' => $this->cefr_level,
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
        ];
    }
}
