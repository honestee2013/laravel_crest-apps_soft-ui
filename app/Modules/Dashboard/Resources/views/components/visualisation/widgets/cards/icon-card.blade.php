<div class="card" style="max-width: 17em">
    <div class="card-body p-3">
      <div class="row">
        <div class="col-8">
          <div class="numbers">
            <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ ucfirst($this->valueChangeTimeDuration) }}'s {{$recordName}}</p>

            <h5 class="font-weight-bolder mb-0">
              {{$prefix}}{{$total}}{{$suffix}}
                @if($this->valueChange > 0 && $timeDuration != 'custom')
                    {{--<i class="fa fa-arrow-up text-success"></i>--}}
                    <span class="text-success text-sm font-weight-bolder">+{{ abs($valueChangePercent) }}%</span>
                @elseif($this->valueChange < 0 && $timeDuration != 'custom')
                    {{--<i class="fa fa-arrow-down text-danger"></i>--}}
                    <span class="text-danger text-sm font-weight-bolder">-{{ abs($valueChangePercent) }}%</span>
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


