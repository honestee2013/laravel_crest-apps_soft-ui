<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true" wire:ignore.self>
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content p-4">
        <div class="modal-header">
            <h3 class="modal-title font-weight-bolder text-info text-gradient" id="exampleModalLabel">
                Record Detail
                <!--{{ $selectedItem ? $selectedItem->name : '' }}-->
                <!-- Display the record's name or any relevant data -->
            </h3>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Display more details of the selected item -->
            @if ($selectedItem)
                @foreach ($columns as $column)
                    @if (!in_array($column, $hiddenFields['onDetail']))
                        <strong class="pe-3">{{ ucwords(str_replace('_', ' ', $column)) }}</strong>


                        @if ($column == 'image' || $column == 'photo' || $column == 'picture')
                            <div class="d-flex justify-content-center">
                                <img class="rounded rounded-3 mb-5" style="width: 10em"
                                    src="{{ asset('storage/' . $selectedItem->$column) }}"
                                    alt="">
                            </div>
                        @elseif ($column == 'password')
                            <p class="mb-4">***********************</p>
                        @elseif (in_array($column, array_keys($multiSelectFormFields)))
                            <p class="mb-4">
                                {{ str_replace(',', ', ', str_replace(['[', ']', '"'], '', $selectedItem->$column)) }}
                            </p>
                        @else
                            <p class="mb-4">
                                {{ $selectedItem->$column }}
                            </p>
                        @endif
                    @endif
                @endforeach
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary rounded-pill"
                data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
