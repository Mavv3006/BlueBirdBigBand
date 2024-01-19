<?php

namespace Tests\Inertia\Intern;

use App\Models\Song;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DownloadSongTest extends TestCase
{
    protected string $fileName = 'test.mp3';

    protected string $filePath = '/songs/test.mp3';

    protected Song $song;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake();

        $this->song = Song::factory()->create([
            'file_path' => $this->fileName,
        ]);
    }

    public function test_storing_fake_files()
    {
        Storage::assertMissing($this->filePath);

        Storage::put($this->filePath, '');

        Storage::assertExists($this->filePath);
    }

    public function test_need_to_log_in()
    {
        Storage::put($this->filePath, '');

        $this->get(route('download-song', $this->song->id))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    public function test_download_file()
    {
        $this->setupMusician();
        $fileContent = 'bla bla bla';
        Storage::put($this->filePath, $fileContent);

        $content = $this->get(route('download-song', $this->song->id))
            ->streamedContent();

        $this->assertEquals($fileContent, $content);
    }

    public function test_non_json_header()
    {
        $this->setupMusician();

        $fileContent = 'bla bla bla';
        Storage::put($this->filePath, $fileContent);

        $content = $this->get(route('download-song', $this->song->id), ['accept' => 'text/html'])
            ->streamedContent();

        $this->assertEquals($fileContent, $content);
    }

    public function test_file_not_found()
    {
        $this->setupMusician();

        $this->get(route('download-song', $this->song->id))
            ->assertNotFound();
    }
}
