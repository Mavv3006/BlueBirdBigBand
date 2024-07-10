<?php

namespace Filament\MusicianResource;

use App\Filament\Resources\MusicianResource\Pages\CreateMusician;
use App\Models\Instrument;
use App\Models\Musician;
use Livewire\Livewire;
use Tests\TestCase;

class MusicianResourceFormTest extends TestCase
{
    public function testFillForm()
    {
        $instrument_id = Instrument::factory()->create()->id;
        $firstname = 'John';
        $lastname = 'Doe';
        $isActive = true;

        $this->assertDatabaseCount(Musician::class, 0);

        Livewire::test(CreateMusician::class)
            // test form field existence
            ->assertFormExists()
            ->assertFormFieldExists('firstname')
            ->assertFormFieldExists('lastname')
            ->assertFormFieldExists('instrument_id')
            ->assertFormFieldExists('isActive')

            // set form values
            ->fillForm([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'isActive' => $isActive,
                'instrument_id' => $instrument_id,
            ])

            // test form field value
            ->assertFormSet([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'isActive' => $isActive,
                'instrument_id' => $instrument_id,
            ])

            // submit the form
            ->call('create')

            // check for validation errors
            ->assertHasNoFormErrors();

        $this->assertDatabaseCount(Musician::class, 1);

        $musician = Musician::first();
        $this->assertequals($instrument_id, $musician->instrument_id);
        $this->assertequals($firstname, $musician->firstname);
        $this->assertequals($lastname, $musician->lastname);
        $this->assertequals($isActive, $musician->isActive);
    }

    public function testRequiredFormFields()
    {
        Livewire::test(CreateMusician::class)
            ->fillForm()
            ->call('create')
            ->assertHasFormErrors([
                'firstname' => 'required',
                'lastname' => 'required',
                'instrument_id' => 'required',
            ]);
    }
}
