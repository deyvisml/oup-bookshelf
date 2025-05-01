<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
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
            
            // Set the memberships_expiry_date for each book in the collection
            foreach ($this->books as $book) {
                $book->setAttribute('memberships_expiry_date', $this->memberships_expiry_date);
            }
        }

        $data = [
            'id' => strval($this->id),
            'title' => "👑 " . $this->title,
            'description' => $this->description,
            'eCommerceUrl' => null,
            'thumbnailUrl' => null,
            'productId' => null,
            'books' => BookResource::collection($this->books),
            'license' => [
                'expired' => $expired,
                'expiryDate' => $this->memberships_expiry_date
            ]
        ];

        // if the request is from a browser extension, include the HTML
        if ($this->is_browser_extension) {
            $data['html'] = $expired ? null : $this->html;
        }

        return $data;
    }
}
