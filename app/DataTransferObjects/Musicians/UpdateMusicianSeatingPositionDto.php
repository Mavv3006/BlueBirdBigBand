<?php

namespace App\DataTransferObjects\Musicians;

use App\Http\Requests\MusicianSeatingPositionRequest;

class UpdateMusicianSeatingPositionDto
{
    /**
     * @param MusicianSeatingPositionDto[] $data
     */
    public function __construct(
        public readonly array $data,
    ) {}

    public static function fromRequest(MusicianSeatingPositionRequest $request): self
    {
        return new self($request->validated()['data']);
    }
}
