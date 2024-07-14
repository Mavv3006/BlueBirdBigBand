<?php

namespace Tests\Feature\Filament\UserResource;

use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Livewire\Livewire;
use Tests\TestCase;

class UserResourceFormTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'John Doe',
        ]);
    }

    public function testFillEditForm()
    {
        $newName = 'test';

        Livewire::test(EditUser::class, ['record' => $this->user->id])
            ->assertFormExists()
            ->assertFormFieldExists('name', function (TextInput $field): bool {
                return $field->isRequired() && $field->isAutofocused();
            })
            ->fillForm(['name' => $newName])
            ->assertFormSet(['name' => $newName])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->user->refresh();
        $this->assertEquals($newName, $this->user->name);
    }

    public function testEditFormUnique()
    {
        $newName = 'test';
        User::factory()->create(['name' => $newName]);

        Livewire::test(EditUser::class, ['record' => $this->user->id])
            ->fillForm(['name' => $newName])
            ->call('save')
            ->assertHasFormErrors(['name' => 'unique:users,name']);

        $oldName = $this->user->name;
        $this->user->refresh();
        $this->assertEquals($oldName, $this->user->name);
    }

    public function testEditFormMaxLength()
    {
        $newName = fake()->regexify('[A-Za-z0-9]{150}');

        Livewire::test(EditUser::class, ['record' => $this->user->id])
            ->fillForm(['name' => $newName])
            ->call('save')
            ->assertHasFormErrors(['name' => 'max:125']);

        $oldName = $this->user->name;
        $this->user->refresh();
        $this->assertEquals($oldName, $this->user->name);
    }
}
