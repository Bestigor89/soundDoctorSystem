<?php

namespace App\Http\Livewire\FileLibrary;

use App\Http\Livewire\WithConfirmation;
use App\Http\Livewire\WithSorting;
use App\Models\FileLibrary;
use App\Models\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;
    use WithConfirmation;

    public int $perPage;

    public array $orderable;

    public string $search = '';

    public array $selected = [];

    public array $paginationOptions;

    /**
     * @var int|null
     */
    public $section = null;

    protected $queryString = [
        'search' => [
            'except' => '',
        ],
        'sortBy' => [
            'except' => 'id',
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
        'section',
    ];

    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetSelected()
    {
        $this->selected = [];
    }

    public function mount()
    {
        $this->sortBy            = 'id';
        $this->sortDirection     = 'desc';
        $this->perPage           = 100;
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable         = (new FileLibrary())->orderable;
    }

    public function render()
    {
        $query = FileLibrary::with(['section'])
            ->when(! blank($this->section), function (Builder $builder) {
                $builder->whereHas('section', function (Builder $builder) {
                   return $builder->where('id', $this->section);
                });
            })
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        $sections = Section::query()->pluck('name', 'id');

        $fileLibraries = $query->paginate($this->perPage);

        return view('livewire.file-library.index', compact('fileLibraries', 'query', 'sections'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('file_library_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        FileLibrary::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(FileLibrary $fileLibrary)
    {
        abort_if(Gate::denies('file_library_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fileLibrary->delete();
    }
}
