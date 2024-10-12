<?php

namespace App\Http\Resources;

use App\Models\LegalInfoContent as ModelsLegalInfoContent;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class LegalInfoTitle extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $contents = ModelsLegalInfoContent::where('legal_info_title_id', $this->id)->get();
        $legal_info_contents = LegalInfoContent::collection($contents)->toArray($request);

        return [
            'id' => $this->id,
            'title_en' => $this->getTranslation('title', 'fr'),
            'title_fr' => $this->getTranslation('title', 'en'),
            'title_ln' => $this->getTranslation('title', 'ln'),
            'title' => $this->title,
            'legal_info_contents' => $legal_info_contents,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'legal_info_subject_id' => $this->legal_info_subject_id
        ];
    }
}
