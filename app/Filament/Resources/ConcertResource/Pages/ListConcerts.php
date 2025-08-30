<?php

namespace App\Filament\Resources\ConcertResource\Pages;

use App\Filament\Resources\ConcertResource;
use App\Services\Concert\ImportSetlistService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Database\Eloquent\Builder;

class ListConcerts extends ListRecords
{
    protected static string $resource = ConcertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('Import Setlist')
                ->action(function (array $data, ImportSetlistService $service) {
                    $setlist = $data['setlist'];
                    $concert = $service->findConcert($data['forScoreData']);
                    $service->saveSetlist($setlist, $concert);
                })
                ->steps([
                    Step::make('forScore Setlist eingeben')
                        ->afterValidation(function ($state, Set $set, ImportSetlistService $service) {
                            $forScoreData = $state['forScoreData'];

                            $concert = $service->findConcert($forScoreData);
                            $set('concert_date', $concert->date->format('d.m.Y'));
                            $set('start_time', $concert->start_time->format('H:i'));
                            $set('end_time', $concert->end_time->format('H:i'));
                            $set('concert_city', $concert->venue->name);
                            $set('event_description', $concert->event_description);
                            $set('venue_description', $concert->venue_description);
                            $set('venue_street', $concert->venue_street.' '.$concert->venue_street_number);

                            $songs = $service->extractSongs($forScoreData);
                            $set('setlist', $songs);
                        })
                        ->schema([
                            Textarea::make('forScoreData')
                                ->label('Setlist Export aus forScore')
                                ->required()
                                ->autofocus()
                                ->disableGrammarly()
                                ->autosize(),
                        ]),
                    Step::make('Konzert bestätigen')
                        ->schema([
                            Section::make('Datum und Uhrzeit')
                                ->columns([
                                    'default' => 1,
                                    'sm' => 3,
                                ])
                                ->schema([
                                    TextInput::make('concert_date')
                                        ->label('Datum')
                                        ->disabled(),
                                    TextInput::make('start_time')
                                        ->label('Startzeit')
                                        ->disabled(),
                                    TextInput::make('end_time')
                                        ->label('Endezeit')
                                        ->disabled(),
                                ]),
                            Section::make('Beschreibungen')
                                ->columns([
                                    'default' => 1,
                                    'lg' => 2,
                                ])
                                ->schema([
                                    TextInput::make('event_description')
                                        ->label('Beschreibung')
                                        ->disabled(),
                                    TextInput::make('venue_description')
                                        ->label('Name der Location')
                                        ->disabled(),
                                ]),
                            Section::make('Adresse')
                                ->description('An welcher Adresse wird die Band spielen?')
                                ->columns([
                                    'default' => 1,
                                    'lg' => 2,
                                ])
                                ->schema([
                                    TextInput::make('venue_street')
                                        ->label('Straße + Hausnummer')
                                        ->disabled(),
                                    TextInput::make('concert_city')
                                        ->label('Ort')
                                        ->disabled(),
                                ]),
                        ]),
                    Step::make('Songs bestätigen')->schema([
                        KeyValue::make('setlist')
                            ->valueLabel('Song Titel (ID)')
                            ->keyLabel('Reihenfolgen-Nummer')
                            ->addable(false)->deletable(false)->editableKeys(false)->editableValues(false)->reorderable(false),
                    ]),
                ]),
        ];
    }

    public function getTabs(): array
    {
        return [
            'upcoming' => Tab::make('zukünftige')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereDate('date', '>=', Carbon::today()->toDateString())),
            'past' => Tab::make('gespielte')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereDate('date', '<', Carbon::today()->toDateString())),
        ];
    }
}
