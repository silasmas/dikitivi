<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class LegalInfoSubject extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $titles = LegalInfoTitle::where('legal_info_subject_id', $this->id)->get();
        $legal_info_titles = LegalInfoTitle::collection($titles)->toArray($request);

        return [
            'id' => $this->id,
            'subject_name_en' => $this->getTranslation('subject_name', 'fr'),
            'subject_name_fr' => $this->getTranslation('subject_name', 'en'),
            'subject_name_ln' => $this->getTranslation('subject_name', 'ln'),
            'subject_name' => $this->subject_name,
            'subject_description_en' => $this->getTranslation('subject_description', 'fr'),
            'subject_description_fr' => $this->getTranslation('subject_description', 'en'),
            'subject_description_ln' => $this->getTranslation('subject_description', 'ln'),
            'subject_description' => $this->subject_description,
            'legal_info_titles' => $legal_info_titles,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
