<?php

namespace App\DataTransferObjects;

use App\Http\Requests\MusicianSeatingPositionRequest;
use JetBrains\PhpStorm\ArrayShape;

class UpdateMusicianSeatingPositionDto
{
    public function __construct(
        #[ArrayShape([
            'instrument_id' => 'integer',
            'musicians' => ['id' => 'integer']
        ])]
        public readonly array $data,
    )
    {
    }

    public static function fromRequest(MusicianSeatingPositionRequest $request): self
    {
        return new self($request->validated()['data']);
    }
}
