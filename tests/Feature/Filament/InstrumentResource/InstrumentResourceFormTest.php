<?php

namespace Filament\InstrumentResource;

use App\Filament\Resources\InstrumentResource;
use App\Models\Instrument;
use Filament\Forms\Components\TextInput;
use Livewire\Livewire;
use Tests\TestCase;

class InstrumentResourceFormTest extends TestCase
{
    public function testFillForm()
    {
        $tuxFilepath = fake()->filePath();
        $name = fake()->name;
        $order = fake()->numberBetween(1, 100);
        $defaultPictureFilepath = fake()->filePath();

        $this->assertDatabaseCount(Instrument::class, 0);

        Livewire::test(InstrumentResource\Pages\CreateInstrument::class)
            // test form field existence
            ->assertFormExists()
            ->assertFormFieldExists('name', function (TextInput $field): bool {
                return $field->isRequired() && $field->isAutofocused();
            })
            ->assertFormFieldExists('order', function (TextInput $field): bool {
                return $field->isRequired()
                    && ($field->getPlaceholder() == 'leer')
                    && ($field->getMinValue() == 0)
                    && $field->getMaxValue() == 2 ** 24 - 1;
            })
            ->assertFormFieldExists('default_picture_filepath', function (TextInput $field): bool {
                return $field->isRequired();
            })
            ->assertFormFieldExists('tux_filepath', function (TextInput $field): bool {
                return $field->isRequired();
            })

            // set form values
            ->fillForm([
                'name' => $name,
                'order' => $order,
                'default_picture_filepath' => $defaultPictureFilepath,
                'tux_filepath' => $tuxFilepath,
            ])

            // test form field value
            ->assertFormSet([
                'name' => $name,
                'order' => $order,
                'default_picture_filepath' => $defaultPictureFilepath,
                'tux_filepath' => $tuxFilepath,
            ])

            // submit the form
            ->call('create')

            // check for validation errors
            ->assertHasNoFormErrors();

        $this->assertDatabaseCount(Instrument::class, 1);

        $instrument = Instrument::first();
        $this->assertequals($tuxFilepath, $instrument->tux_filepath);
        $this->assertequals($name, $instrument->name);
        $this->assertequals($order, $instrument->order);
        $this->assertequals($defaultPictureFilepath, $instrument->default_picture_filepath);
    }

    public function test_order_ranges_lower_limit()
    {
        Livewire::test(InstrumentResource\Pages\CreateInstrument::class)
            ->fillForm([
                'name' => fake()->name,
                'order' => -2,
                'default_picture_filepath' => fake()->filePath(),
                'tux_filepath' => fake()->filePath(),
            ])
            ->call('create')
            ->assertHasFormErrors(['order']);
    }

    public function test_order_ranges_upper_limit()
    {
        Livewire::test(InstrumentResource\Pages\CreateInstrument::class)
            ->fillForm([
                'name' => fake()->name,
                'order' => 2 ** 24 + 5,
                'default_picture_filepath' => fake()->filePath(),
                'tux_filepath' => fake()->filePath(),
            ])
            ->call('create')
            ->assertHasFormErrors(['order']);
    }

    public function test_required_fields()
    {
        Livewire::test(InstrumentResource\Pages\CreateInstrument::class)
            ->fillForm()
            ->call('create')
            ->assertHasFormErrors([
                'order' => 'required',
                'name' => 'required',
                'default_picture_filepath' => 'required',
                'tux_filepath' => 'required',
            ]);
    }

    public function test_unique_order()
    {
        Instrument::factory()->create(['order' => 1]);

        Livewire::test(InstrumentResource\Pages\CreateInstrument::class)
            ->fillForm([
                'name' => fake()->name,
                'order' => 1,
                'default_picture_filepath' => fake()->filePath(),
                'tux_filepath' => fake()->filePath(),
            ])
            ->call('create')
            ->assertHasFormErrors(['order' => 'unique:instruments']);
    }
}
