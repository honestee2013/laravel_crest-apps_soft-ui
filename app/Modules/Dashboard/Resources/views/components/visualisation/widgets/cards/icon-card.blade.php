<div class="card" style="max-width: 17em">
    <div class="card-body p-3">
      <div class="row">
        <div class="col-8">
          <div class="numbers">
            <p class="text-sm mb-0 text-capitalize font-weight-bold">
                {{ str_replace("_", " ", ucfirst($this->timeDuration)) }}'s
                {{str_replace("_", " ", ucfirst($aggregationType))}} {{$recordName}}
            </p>

            <h5 class="font-weight-bolder mb-0">
                {{--- Aggregation value ---}}
                @if ($aggregationType == "average")
                    {{$prefix}}{{$ave}}{{$suffix}}
                @elseif ($aggregationType == "maximum")
                    {{$prefix}}{{$max}}{{$suffix}}
                @elseif ($aggregationType == "minimum")
                    {{$prefix}}{{$min}}{{$suffix}}
                @elseif ($aggregationType == "number_of")
                    {{$prefix}}{{$count}}{{$suffix}}
                @else
                    {{$prefix}}{{$total}}{{$suffix}}
                @endif

                {{--- Increase/Decrease Indcator for current duration ---}}
                @if (str_contains($timeDuration, "this"))
                    @if($valueChange > 0 && $timeDuration != 'custom')
                        {{--<i class="fa fa-arrow-up text-success"></i>--}}
                        <span class="text-success text-sm font-weight-bolder">+{{ abs($valueChangePercent) }}%</span>
                    @elseif($valueChange < 0 && $timeDuration != 'custom')
                        {{--<i class="fa fa-arrow-down text-danger"></i>--}}
                        <span class="text-danger text-sm font-weight-bolder">-{{ abs($valueChangePercent) }}%</span>
                    @endif
                    {{-- @elseif($this->valueChange < 0 && $timeDuration == 'custom') --}}
                @endif
                
            </h5>

          </div>
        </div>

        <div class="col-4 text-end">
          <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
            <i class="{{$iconCSSClass}}" aria-hidden="true"></i>
          </div>
        </div>

      </div>
    </div>
  </div>


