
<aside class="sidebar">

    <div class="brand">
        <img src="{{ asset('images/logo-whimsy.jpeg') }}"
             alt="Logo WhimsyBooth">
        <span>WhimsyBooth</span>
    </div>

    <a href="{{ url('/admin/dashboard') }}"
       class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        Dashboard
    </a>

  <a href="{{ route('admin.frames.index') }}"
   class="{{ request()->is('admin/frames*') ? 'active' : '' }}">
    Kelola Frame
</a>

    <a href="{{ url('/admin/filters') }}"
       class="{{ request()->is('admin/filters*') ? 'active' : '' }}">
        Kelola Filter
    </a>

</aside>
