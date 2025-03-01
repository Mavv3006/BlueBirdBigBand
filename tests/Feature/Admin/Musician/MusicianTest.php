<?php

namespace Tests\Feature\Admin\Musician;

use App\Models\Instrument;
use App\Models\Musician;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class MusicianTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function test_index_route()
    {
        Musician::factory()
            ->count(3)
            ->for(
                Instrument::factory()->create(['name' => 'test'])
            )
            ->create();

        $this->get('admin/musicians')
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/MusicianManagement/MusiciansIndex')
                    ->has(
                        'data',
                        3,
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('firstname')
                            ->has('lastname')
                            ->has('isActive')
                            ->has('seating_position')
                            ->has('instrument_id')
                            ->has('picture_filepath')
                            ->has(
                                'instrument',
                                fn (AssertableInertia $page) => $page
                                    ->has('id')
                                    ->has('name')
                                    ->has('tux_filepath')
                                    ->has('order')
                                    ->has('default_picture_filepath')
                            )
                    )
            );
    }

    public function test_create_route()
    {
        Instrument::factory()->create(['name' => 'test']);

        $this->get('admin/musicians/create')
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/MusicianManagement/MusiciansCreate')
                    ->has(
                        'instruments',
                        1,
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->has('tux_filepath')
                            ->has('order')
                            ->has('default_picture_filepath')
                    )
            );
    }

    public function test_store_route()
    {
        $instrument_id = Instrument::factory()->create(['name' => 'test'])->id;
        $response = $this->post('admin/musicians', [
            'firstname' => 'test',
            'lastname' => 'test',
            'isActive' => true,
            'instrument_id' => $instrument_id,
        ]);
        $musician = Musician::first();

        $response->assertRedirect(route('musicians.show', $musician->id));
        $this->assertDatabaseCount('musicians', 1);
        $this->assertEquals('test', $musician->firstname);
        $this->assertEquals('test', $musician->lastname);
        $this->assertEquals($instrument_id, $musician->instrument_id);
        $this->assertTrue($musician->isActive);
        $this->assertNull($musician->picture_filepath);
    }

    public function test_show_route()
    {
        $musician = Musician::factory()
            ->for(
                Instrument::factory()->create(['name' => 'test'])
            )
            ->create();

        $this->get('admin/musicians/'.$musician->id)
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/MusicianManagement/MusiciansShow')
                    ->has(
                        'instrument',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->has('tux_filepath')
                            ->has('order')
                            ->has('default_picture_filepath')
                    )
                    ->has(
                        'musician',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('firstname')
                            ->has('lastname')
                            ->has('seating_position')
                            ->has('isActive')
                            ->has('instrument_id')
                            ->has('picture_filepath')
                    )
            );
    }

    public function test_edit_route()
    {
        $musician = Musician::factory()
            ->for(
                Instrument::factory()->create(['name' => 'test'])
            )
            ->create();

        $this->get('admin/musicians/'.$musician->id.'/edit')
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/MusicianManagement/MusiciansEdit')
                    ->has(
                        'instruments',
                        1,
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('name')
                            ->has('tux_filepath')
                            ->has('order')
                            ->has('default_picture_filepath')
                    )
                    ->has(
                        'musician',
                        fn (AssertableInertia $page) => $page
                            ->has('id')
                            ->has('firstname')
                            ->has('lastname')
                            ->has('isActive')
                            ->has('seating_position')
                            ->has('instrument_id')
                            ->has('picture_filepath')
                    )
            );
    }

    public function test_update_route()
    {
        $instrument = Instrument::factory()->create(['name' => 'test']);
        $databaseMusician = Musician::factory()
            ->for($instrument)
            ->create([
                'firstname' => 'test',
                'lastname' => 'test',
            ]);

        $response = $this->put(
            'admin/musicians/'.$databaseMusician->id,
            [
                'firstname' => '1',
                'lastname' => '2',
                'isActive' => $databaseMusician->isActive,
                'instrument_id' => $instrument->id,
            ]
        );
        $musician = Musician::first();

        $response->assertRedirect(route('musicians.show', $databaseMusician->id));
        $this->assertDatabaseCount('musicians', 1);
        $this->assertEquals('1', $musician->firstname);
        $this->assertEquals('2', $musician->lastname);
        $this->assertEquals($instrument->id, $musician->instrument_id);
        $this->assertTrue($musician->isActive);
        $this->assertNull($musician->picture_filepath);
    }

    public function test_destroy_route()
    {
        $musician = Musician::factory()
            ->for(
                Instrument::factory()->create(['name' => 'test'])
            )
            ->create();

        $this->delete('admin/musicians/'.$musician->id)
            ->assertRedirect(route('musicians.index'));

        $this->assertDatabaseCount('musicians', 0);
    }
}
