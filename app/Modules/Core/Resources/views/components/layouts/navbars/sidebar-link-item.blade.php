





<li class="nav-item">
    <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ url($url) }}">
        <span width="12px" height="12px">
            <i  class="{{ $iconClasses }}"></i>
        </span>
      <span class="nav-link-text ms-1">{{ $title }}</span>
    </a>
</li>