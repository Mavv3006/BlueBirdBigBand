<?php

namespace Tests\Feature\Filament\NewsletterRequestResource;

use App\Enums\NewsletterType;
use App\Enums\StateMachines\NewsletterState;
use App\Filament\Resources\NewsletterRequestResource\Pages\ListNewsletterRequests;
use App\Models\NewsletterRequest;
use Filament\Tables\Columns\TextColumn;
use Livewire\Livewire;
use Tests\TestCase;

class NewsletterRequestResourceTableTest extends TestCase
{
    public function testCanRenderWithCorrectConfig()
    {
        Livewire::test(ListNewsletterRequests::class)
            ->assertSuccessful()
            ->assertTableColumnExists('email', fn (TextColumn $column) => $column->isSortable()
                && $column->getLabel() === 'E-Mail'
                && $column->getIcon(NewsletterType::Adding) === 'heroicon-m-envelope'
            )
            ->assertTableColumnExists('type', fn (TextColumn $column) => $column->isSortable()
                && $column->isBadge()
                && $column->getColor(NewsletterType::Adding) === 'success'
                && $column->getColor(NewsletterType::Removing) === 'warning'
            )
            ->assertTableColumnExists('status', fn (TextColumn $column) => $column->isSortable()
                && $column->isBadge()
                && $column->getColor(NewsletterState::Requested) === 'gray'
                && $column->getColor(NewsletterState::Completed) === 'success'
                && $column->getColor(NewsletterState::Confirmed) === 'warning'
            )
            ->assertTableColumnExists('created_at', fn (TextColumn $column) => $column->isSortable()
                && $column->getLabel() === 'Angelegt'
                && $column->isDateTime()
                && $column->isToggleable() === true
                && $column->toggledHiddenByDefault()
            )
            ->assertTableColumnExists('confirmed_at', fn (TextColumn $column) => $column->isSortable()
                && $column->getLabel() === 'Bestätigt'
                && $column->getPlaceholder() === 'null'
                && $column->isDateTime()
                && $column->isToggleable() === true
                && $column->toggledHiddenByDefault()
            )
            ->assertTableColumnExists('completed_at', fn (TextColumn $column) => $column->isSortable()
                && $column->getLabel() === 'Abgeschlossen'
                && $column->getPlaceholder() === 'null'
                && $column->isDateTime()
                && $column->isToggleable() === true
                && $column->toggledHiddenByDefault()
            )
            ->assertCanRenderTableColumn('email')
            ->assertCanRenderTableColumn('type')
            ->assertCanRenderTableColumn('status')
            ->assertCanNotRenderTableColumn('created_at')
            ->assertCanNotRenderTableColumn('confirmed_at')
            ->assertCanNotRenderTableColumn('completed_at');
    }

    public function testShowCorrectData()
    {
        $confirmed = NewsletterRequest::factory()->count(2)->create([
            'status' => NewsletterState::Confirmed,
        ]);
        $requested = NewsletterRequest::factory()->count(2)->create([
            'status' => NewsletterState::Requested,
        ]);
        $completed = NewsletterRequest::factory()->count(2)->create([
            'status' => NewsletterState::Completed,
        ]);

        Livewire::test(ListNewsletterRequests::class)
            ->assertCountTableRecords(2)
            ->assertCanSeeTableRecords($confirmed)
            ->assertCanNotSeeTableRecords($requested)
            ->assertCanNotSeeTableRecords($completed);
    }

    public function testCompleteTableRowAction()
    {
        $confirmed = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Confirmed,
        ]);
        $requested = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Requested,
        ]);
        $completed = NewsletterRequest::factory()->create([
            'status' => NewsletterState::Completed,
        ]);

        $this->assertEquals(NewsletterState::Confirmed, $confirmed->status);

        Livewire::test(ListNewsletterRequests::class)
            ->assertTableActionExists('complete')
            ->assertTableActionHasLabel('complete', 'Abschließen')
            ->assertTableActionEnabled('complete', $confirmed)
            ->assertTableActionDisabled('complete', $requested)
            ->assertTableActionDisabled('complete', $completed)
            ->assertTableActionVisible('complete', $confirmed)
            ->callTableAction('complete', $confirmed)
            ->assertHasNoTableActionErrors();

        $confirmed->refresh();
        $this->assertEquals(NewsletterState::Completed, $confirmed->status);
    }
}
