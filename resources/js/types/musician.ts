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
        default_picture_filepath: string
    },
    musicians: MusicianBackendDto[]
}

export type MusicianWithInstrument = {
    instrument: string,
    musicians: Musician[]
}

export type Musician = { picture: String, name: String };
