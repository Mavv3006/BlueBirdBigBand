export type MusicianBackendDto = {
    id: number,
    instrument_id: number,
    firstname: string,
    lastname: string,
    seating_position?: number,
    picture_filepath?: string
}

export type MusicianProp = {
    instrument: {
        id: number,
        name: string,
        default_picture_filepath: string,
        tux_filepath: string,
    },
    musicians: MusicianBackendDto[]
}

export type ReducedInstrument = {
    name: string
    tux_filepath: string,
};

export type MusicianWithInstrument = {
    instrument: ReducedInstrument,
    musicians: Musician[]
}

export type Musician = { name: String };
