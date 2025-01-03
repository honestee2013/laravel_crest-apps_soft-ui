
<table id="dataTable" class="table align-items-center mb-0">
    <thead>
        <tr>
            <!--- Bulk Action - Select ALL Checkbox ---->
            @if(isset($controls['bulkActions']))
                <th
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 no-print">
                    <div class="form-check">
                        <input class="form-check-input" style="width: 1.6em; height:1.6em"
                            type="checkbox" wire:model.live.500ms="selectAll">
                    </div>
                </th>
            @endif

            <!--- Table Header ACS-DESC Sorting ---->
            @foreach ($columns as $column)
                @if (in_array($column, $visibleColumns))
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2 round-top "
                        wire:click="sortColumn('{{ $column }}')" style="height: 0.5em; "
                        aria-sort="{{ $sortField === $column ? ($sortDirection === 'asc' ? 'ascending' : 'descending') : 'none' }}">
                        <div
                            class="d-flex justify-content-between p-2 px-3
                        {{ $sortField === $column ? 'rounded-pill bg-gray-100' : '' }}">

                            @if(isset($fieldDefinitions[$column]['label']))
                                <span>{{ ucwords($fieldDefinitions[$column]['label']) }}</span>
                            @else
                                <span>{{ ucwords(str_replace('_', ' ', $column)) }}</span>
                            @endif
                            @if ($sortField === $column)
                                @if ($sortDirection === 'asc')
                                    <span class="btn-inner--icon"><i
                                            class="fa-solid fa-sort-up"></i></span>
                                @else
                                    <span class="btn-inner--icon"><i
                                            class="fa-solid fa-sort-down"></i></span>
                                @endif
                            @endif
                        </div>
                    </th>
                @endif
            @endforeach

            @if ($simpleActions)
                <th
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 no-print">
                    Actions
                </th>
            @endif

        </tr>
    </thead>
    <tbody>


        @forelse($data as $row)
            <tr>
                <!--- Bulk Action - Single Row Selection Checkbox ---->
                @if(isset($controls['bulkActions']))
                    <td
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 no-print">
                        <div class="form-check">
                            <input class="form-check-input" style="width: 1.6em; height:1.6em"
                                x-on:click="$wire.toggleRowSelected()"
                                type="checkbox" wire:model="selectedRows" value="{{ $row->id }}"
                                @if (in_array($row->id, $selectedRows)) selected @endif />
                        </div>
                    </td>
                @endif

                <!---- Displaying Record That Has A RELATIONSHIP  ---->
                @foreach ($columns as $column)
                    @if (in_array($column, $visibleColumns))
                        <td style="min-width: 10em; white-space: normal; word-wrap: break-word; ">
                            <p class="text-xs font-weight-bold mb-0">
                                @if (isset($fieldDefinitions[$column]) && isset($fieldDefinitions[$column]['relationship']))
                                    <!---- Has Many Relationship ---->
                                    @if (isset($fieldDefinitions[$column]['relationship']['type']) && $fieldDefinitions[$column]['relationship']['type'] == 'hasMany')
                                        {{
                                            implode(', ',
                                                $row->{$fieldDefinitions[$column]['relationship']['dynamic_property']}
                                                ->pluck($fieldDefinitions[$column]['relationship']['display_field'])->toArray()
                                            )
                                        }}
                                    <!---- Belongs To Many Relationship ---->
                                    @elseif (isset($fieldDefinitions[$column]['relationship']['type']) && $fieldDefinitions[$column]['relationship']['type'] == 'belongsToMany')
                                        {{
                                            implode(', ',
                                                $row->{$fieldDefinitions[$column]['relationship']['dynamic_property']}
                                                ->pluck($fieldDefinitions[$column]['relationship']['display_field'])->toArray()
                                            )
                                        }}
                                    @else <!---- Belongs Relationship ---->
                                        @php
                                            $dynamic_property = $fieldDefinitions[$column]['relationship']['dynamic_property'];
                                            $displayField = $fieldDefinitions[$column]['relationship']['display_field'];
                                        @endphp
                                        {{
                                            optional($row->{$dynamic_property})->$displayField
                                        }}




                                    @endif
                                @elseif ($column && $multiSelectFormFields && in_array($column, array_keys($multiSelectFormFields)))
                                    {{ str_replace(',', ', ', str_replace(['[', ']', '"'], '', $row->$column)) }}

                                @elseif (in_array($column, $this->getSupportedImageColumnNames()))
                                    @if ($row->$column)
                                        <img class="rounded-circle m-0"
                                            style="width: 4em; height: 4em;"
                                            src="{{ asset('storage/' . $row->$column) }}"
                                            alt="">
                                    @else
                                        <i class="fas fa-file-image  m-0 ms-2"
                                            style="font-size: 4em; color:lightgray;"></i>
                                    @endif
                                @else
                                    {{ $row->$column }}
                                @endif
                            </p>
                        </td>
                    @endif
                @endforeach

                <td class="no-print">
                    @if ($simpleActions)
                        @foreach ($simpleActions as $action)
                            @if (strtolower($action) == 'edit')

                                <span wire:click="editRecord( {{ $row->id }}, '{{ addslashes($model) }}' )"
                                    class="mx-2"
                                    style="cursor: pointer"
                                    data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                    <i class="fas fa-edit text-primary"></i>
                                </span>
                            @elseif(strtolower($action) == 'show')
                                <span wire:click="$dispatch('openDetailModalEvent', [{{ $row->id }}, '{{ addslashes($model) }}'] )"
                                    style="cursor: pointer" class="mx-2"
                                    data-bs-toggle="tooltip"  data-bs-original-title="Detail"
                                    >
                                    <i class="fas fa-eye text-info"></i>
                                </span>
                            @elseif(strtolower($action) == 'delete')
                                <span wire:click="deleteRecord({{ $row->id }} )"
                                    class="mx-2"
                                    style="cursor: pointer"
                                    data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                    <i class="fas fa-trash text-danger"></i>
                                </span>
                            @else
                                <!------- Default eg. route('users.user.edit', ['user' => 1]) --------->
                                <a href="{{ route(strtolower(Str::plural($modelName)) . '.' . strtolower(Str::singular($modelName)) . '.' . strtolower(Str::singular($action)), [strtolower($modelName) => $row->id]) }}"
                                    class="mx-2" data-bs-toggle="tooltip"
                                    style="cursor: pointer"
                                    data-bs-original-title="{{ucfirst($action)}}">
                                    <span
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ ucfirst($action) }}
                                    </span>
                                </a>
                            @endif
                        @endforeach
                    @endif

                    @if ($moreActions)

                        <span class="btn-group dropdown" data-bs-toggle="tooltip" data-bs-original-title="More" style="cursor: pointer">
                            <span class="px-2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical text-secondary"></i>
                            </span>
                            <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton">
                                @foreach ( $moreActions as $actionName => $actionData )
                                    @if(isset($actionData['title']))
                                        <pan class="m-2 text-uppercase text-xs fw-bolder">{{ ucfirst($actionData['title']) }}</pan>
                                        <hr class="m-2 p-0 bg-gray-500" />
                                    @endif

                                    <li>
                                        @if(isset($actionData['route']))
                                            <a class="dropdown-item" href="javascript:void(0)" wire:click="openLink('{{ $actionData['route'] }}', {{ $row->id }})">
                                        @elseif(isset($actionData['updateModelField']) && isset($actionData['fieldName']) && isset($actionData['fieldValue']))
                                            <a class="dropdown-item" onclick="Livewire.dispatch('updateModelFieldEvent',['{{$row->id}}', '{{$actionData['fieldName']}}', '{{$actionData['fieldValue']}}'])">
                                        @else
                                            <a class="dropdown-item" href="javascript:void(0)">
                                        @endif
                                        @if(isset($actionData['icon']))
                                                <i class="{{$actionData['icon']}}"></i>
                                        @endif
                                        <span class="btn-inner--text">{{ ucfirst($actionName) }}</span>
                                        </a>
                                    </li>
                                    @if(isset($actionData['hr']))
                                        <hr class="m-2 p-0 bg-gray-500" />
                                    @endif
                                @endforeach

                            </ul>
                        </span>


                    @endif

                </td>

            </tr>
        @empty
            <tr>
                <td colspan="{{ count($columns) }}" class="text-center py-4">No records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
