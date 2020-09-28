<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //  Put In Exactly What You Want To Return To Your API
        return [
            'data' =>  [
                'article_id' => $this->id,
                'title' => $this->title,
                'body' => htmlspecialchars_decode(htmlspecialchars($this->body, ENT_QUOTES, 'UTF-8')),
                'excerpt' => htmlspecialchars_decode(htmlspecialchars($this->excerpt, ENT_QUOTES, 'UTF-8')),
                'created_at' => $this->created_at->format('m/d/Y'),
                'last_updated' => $this->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }

    // public function with($request)
    // {
    //     return [
    //         'version' => '1.0.0',
    //         'author_url' => url('https://chido-designs.co.uk'),
    //     ];
    // }
}
