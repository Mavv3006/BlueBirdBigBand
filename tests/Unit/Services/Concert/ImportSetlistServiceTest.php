<?php

namespace Tests\Unit\Services\Concert;

use App\Models\Band;
use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\Song;
use App\Models\Venue;
use App\Services\Concert\ImportSetlistService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\UniqueConstraintViolationException;
use Tests\TestCase;

class ImportSetlistServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Band::factory()->create();
        Venue::factory()->create();
    }

    public function test_extracting_concert_date()
    {
        $text = '
2025-08-01 Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“Sway - Tpt 2” von Mark Taylor
“K-Town West - Tpt 2” von Paul Ludwig Schütt
“In The Stone - Tpt 2”
“Straighten Up And Fly Right - Tpt 2”
“The_Girl From Ipanema - Tpt 1” von Roger Holmes';

        $result = (new ImportSetlistService)->extractConcertDate($text);

        $this->assertEquals('2025-08-01', $result);
    }

    public function test_extracting_concert_date_no_date()
    {
        $text = '
oiuzrqowiuerz Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“Sway - Tpt 2” von Mark Taylor
“K-Town West - Tpt 2” von Paul Ludwig Schütt
“In The Stone - Tpt 2”
“Straighten Up And Fly Right - Tpt 2”
“The_Girl From Ipanema - Tpt 1” von Roger Holmes';

        $result = (new ImportSetlistService)->extractConcertDate($text);

        $this->assertEquals('oiuzrqowiuerz', $result);
    }

    public function test_extracting_concert_date_more_blank_lines()
    {
        $text = '



2025-08-01 Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“In The Stone - Tpt 2”
“The_Girl From Ipanema - Tpt 1” von Roger Holmes';

        $result = (new ImportSetlistService)->extractConcertDate($text);

        $this->assertEquals('2025-08-01', $result);
    }

    public function test_extracting_correct_concert()
    {
        $text = '
2025-08-01 Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“Sway - Tpt 2” von Mark Taylor
“K-Town West - Tpt 2” von Paul Ludwig Schütt
“In The Stone - Tpt 2”
“Straighten Up And Fly Right - Tpt 2”
“The_Girl From Ipanema - Tpt 1” von Roger Holmes';
        $concert = Concert::factory()->create(['start_at' => '2025-08-01']);

        $result = (new ImportSetlistService)->findConcert($text);

        $this->assertEquals($concert->start_at, $result->start_at);
    }

    public function test_extracting_correct_concert_no_concert_found()
    {
        $text = '
2025-08-01 Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“Sway - Tpt 2” von Mark Taylor
“K-Town West - Tpt 2” von Paul Ludwig Schütt
“In The Stone - Tpt 2”
“Straighten Up And Fly Right - Tpt 2”
“The_Girl From Ipanema - Tpt 1” von Roger Holmes';
        Concert::factory()->create(['start_at' => '2025-09-01']);

        $this->assertThrows(
            fn () => (new ImportSetlistService)->findConcert($text),
            ModelNotFoundException::class
        );
    }

    public function test_extracting_songs_no_arranger()
    {
        $text = '
2025-08-01 Schifferstadt

“Cute - Tpt 1”
“Sway - Tpt 2”';
        Concert::factory()->create(['start_at' => '2025-08-01']);
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 2],
            ['title' => 'Sway', 'id' => 5],
        ]);

        $result = (new ImportSetlistService)->extractSongs($text);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        $this->assertEquals('Cute (ID 2)', $result[0]);
        $this->assertEquals('Sway (ID 5)', $result[1]);
    }

    public function test_extracting_songs_with_arranger()
    {
        $text = '
2025-08-01 Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“Sway - Tpt 2” von Mark Taylor';
        Concert::factory()->create(['start_at' => '2025-08-01']);
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 2, 'arranger' => 'Neal Hefti'],
            ['title' => 'Sway', 'id' => 5, 'arranger' => 'Mark Taylor'],
        ]);

        $result = (new ImportSetlistService)->extractSongs($text);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        $this->assertEquals('Cute (ID 2)', $result[0]);
        $this->assertEquals('Sway (ID 5)', $result[1]);
    }

    public function test_correct_setlist_ordering()
    {
        $text = '
2025-08-01 Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“Sway - Tpt 2” von Mark Taylor
“K-Town West - Tpt 2” von Paul Ludwig Schütt
“In The Stone - Tpt 2”
“Straighten Up And Fly Right - Tpt 2”
“The_Girl From Ipanema - Tpt 1” von Roger Holmes';
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 2, 'arranger' => 'Neal Hefti'],
            ['title' => 'Sway', 'id' => 5, 'arranger' => 'Mark Taylor'],
            ['title' => 'K-Town West', 'id' => 1, 'arranger' => 'Paul Ludwig Schütt'],
            ['title' => 'In The Stone', 'id' => 7],
            ['title' => 'Straighten Up And Fly Right', 'id' => 9],
            ['title' => 'The Girl From Ipanema', 'id' => 8, 'arranger' => 'Roger Holmes'],
        ]);

        $result = (new ImportSetlistService)->extractSongs($text);

        $this->assertCount(6, $result);
        $this->assertEquals('Cute (ID 2)', $result[0]);
        $this->assertEquals('Sway (ID 5)', $result[1]);
        $this->assertEquals('K-Town West (ID 1)', $result[2]);
        $this->assertEquals('In The Stone (ID 7)', $result[3]);
        $this->assertEquals('Straighten Up And Fly Right (ID 9)', $result[4]);
        $this->assertEquals('The Girl From Ipanema (ID 8)', $result[5]);
    }

    public function test_saving_setlist()
    {
        $concert = Concert::factory()->create(['start_at' => '2025-08-01']);
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 3],
            ['title' => 'Sway', 'id' => 4],
        ]);
        $setlist = [
            'Cute (ID 3)',
            'Sway (ID 4)',
        ];

        (new ImportSetlistService)->saveSetlist($setlist, $concert);

        $this->assertDatabaseCount(SetlistEntry::class, 2);
        $this->assertDatabaseCount(Song::class, 2);
        $this->assertDatabaseCount(Concert::class, 1);

        $songCute = SetlistEntry::query()
            ->where('song_id', 3)
            ->where('concert_id', $concert->id)
            ->first();

        $this->assertEquals(0, $songCute->sequence_number);
    }

    public function test_skipping_pluses()
    {
        $text = '

2025-08-01 Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“Sway - Tpt 2” von Mark Taylor
“+++ Pause +++”
“K-Town West - Tpt 2” von Paul Ludwig Schütt
“In The Stone - Tpt 2”
“Straighten Up And Fly Right - Tpt 2”
“+++ Zugabe +++”
“The_Girl From Ipanema - Tpt 1” von Roger Holmes';
        Concert::factory()->create(['start_at' => '2025-08-01']);
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 2, 'arranger' => 'Neal Hefti'],
            ['title' => 'Sway', 'id' => 5, 'arranger' => 'Mark Taylor'],
            ['title' => 'K-Town West', 'id' => 1, 'arranger' => 'Paul Ludwig Schütt'],
            ['title' => 'In The Stone', 'id' => 7],
            ['title' => 'Straighten Up And Fly Right', 'id' => 9],
            ['title' => 'The Girl From Ipanema', 'id' => 8, 'arranger' => 'Roger Holmes'],
        ]);

        $result = (new ImportSetlistService)->extractSongs($text);

        $this->assertCount(6, $result);
        $this->assertEquals('Cute (ID 2)', $result[0]);
        $this->assertEquals('Sway (ID 5)', $result[1]);
        $this->assertEquals('K-Town West (ID 1)', $result[2]);
        $this->assertEquals('In The Stone (ID 7)', $result[3]);
        $this->assertEquals('Straighten Up And Fly Right (ID 9)', $result[4]);
        $this->assertEquals('The Girl From Ipanema (ID 8)', $result[5]);
    }

    public function test_similar_song_no_arranger_in_input()
    {
        $text = '
2025-08-01 Schifferstadt

“Cute - Tpt 1”
“Sway - Tpt 2”
“Chega De Saudage (No More Blues) - Tpt 2”';
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 2, 'arranger' => 'Neal Hefti'],
            ['title' => 'Sway', 'id' => 5, 'arranger' => 'Mark Taylor'],
            ['title' => 'Chega De Saudage (No More Blues)', 'id' => 4, 'arranger' => 'Mark Taylor'],
        ]);

        $result = (new ImportSetlistService)->extractSongs($text);

        $this->assertCount(3, $result);
    }

    public function test_similar_song_arranger_in_input_but_not_in_db()
    {
        $text = '
2025-08-01 Schifferstadt

“Cute - Tpt 1” von Neal Hefti
“Sway - Tpt 2” von Mark Taylor
“Chega De Saudage (No More Blues) - Tpt 2” von Mark Taylor';
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 2, 'arranger' => null],
            ['title' => 'Sway', 'id' => 5, 'arranger' => null],
            ['title' => 'Chega De Saudage (No More Blues)', 'id' => 4, 'arranger' => null],
        ]);

        $result = (new ImportSetlistService)->extractSongs($text);

        $this->assertCount(3, $result);
    }

    public function test_split_setlist_entry()
    {
        $input = '“Cute - Tpt 1” von Neal Hefti';

        $result = (new ImportSetlistService)->splitSetlistEntry($input);

        $this->assertEquals('Cute - Tpt 1', $result['title']);
        $this->assertEquals('Neal Hefti', $result['arranger']);
    }

    public function test_split_setlist_entry_no_arranger()
    {
        $input = '“Cute - Tpt 1”';

        $result = (new ImportSetlistService)->splitSetlistEntry($input);

        $this->assertEquals('Cute - Tpt 1', $result['title']);
        $this->assertNull($result['arranger']);
    }

    public function test_split_setlist_entry_no_special_chars()
    {
        $input = 'Cute - Tpt 1';

        $result = (new ImportSetlistService)->splitSetlistEntry($input);

        $this->assertEquals('Cute - Tpt 1', $result['title']);
        $this->assertNull($result['arranger']);
    }

    public function test_saving_with_no_songs()
    {
        $concert = Concert::factory()->create(['start_at' => '2025-08-01']);
        $setlist = [];

        (new ImportSetlistService)->saveSetlist($setlist, $concert);

        $this->assertDatabaseCount(SetlistEntry::class, 0);
    }

    public function test_saving_with_incorrect_format()
    {
        $concert = Concert::factory()->create(['start_at' => '2025-08-01']);
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 3],
            ['title' => 'Sway', 'id' => 4],
        ]);
        $setlist = [
            'Cute (ID 3)',
            'Sway (ID 4)',
            'K-Town West',
        ];

        (new ImportSetlistService)->saveSetlist($setlist, $concert);

        $this->assertDatabaseCount(SetlistEntry::class, 2);
        $songs = SetlistEntry::with('song')->get();
        $this->assertEquals('Cute', $songs[0]->song->title);
        $this->assertEquals('Sway', $songs[1]->song->title);
    }

    public function test_save_song_multiple_times()
    {
        $concert = Concert::factory()->create(['start_at' => '2025-08-01']);
        Song::factory()->createMany([
            ['title' => 'Cute', 'id' => 3],
            ['title' => 'Sway', 'id' => 4],
        ]);
        $setlist = [
            'Cute (ID 3)',
            'Sway (ID 4)',
            'Cute (ID 3)',
        ];

        $this->assertThrows(
            fn () => (new ImportSetlistService)->saveSetlist($setlist, $concert),
            UniqueConstraintViolationException::class);

        $this->assertDatabaseCount(SetlistEntry::class, 0);
    }
}
