<?php

namespace App\DataTransferObjects\Musicians;

use App\Http\Requests\MusicianSeatingPositionRequest;

readonly class UpdateMusicianSeatingPositionDto
{
    /**
     * @param MusicianSeatingPositionDto[] $data
     */
    public function __construct(
        public array $data,
    ) {}

    public static function fromRequest(MusicianSeatingPositionRequest $request): self
    {
        return new self($request->validated()['data']);
    }
}
