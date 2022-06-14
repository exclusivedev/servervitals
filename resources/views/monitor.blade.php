<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Live Server Monitor</title>

  <script src="{{ asset('js/app.js') }}" defer></script>

  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

</head>

<body>
  <div id="app">
    <header>
      <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}">Live Server Monitor</a>
        </div>
      </nav>
    </header>

    <!-- <main class="py-4 container">
      <div class="row"> -->

    <div class="container">
      @forelse ($hosts as $host)
      <div class="dashboard">
        <div class="meter">
          <div class="date">{{\Carbon\Carbon::parse(minValue($host->checks))->toDayDateTimeString()}}</div>
          <ul>
            @forelse ($host->checks()->enabled()->get()->filter->isNumber() as $check)
            <li>
              <i class="fas fa-thermometer-three-quarters"></i>
              <div id="check-{{ $check->id }}" class="number">{{ $check->value }}<span class="symbol">%</span></div>
              <div class="unit">{{ $check->type }}</div>
            </li>
            @empty
            <p class="card-text">No checks yet</p>
            @endforelse
          </ul>
        </div>
        <div class="controls">
          <ul>
            @forelse ($host->checks()->enabled()->get()->filter->isSwitch() as $check)
            <li>
              <i class="fas fa-warehouse"></i>
              <div class="item">{{ $check->type }}</div>
              <div class="switch">
                <input id="check-{{ $check->id }}" type="checkbox" {!! $check->value ? "checked" : "" !!} />
                <label for="check-{{ $check->id }}"></label>
              </div>
            </li>
            @empty
            <p class="card-text">No checks yet</p>
            @endforelse
          </ul>
        </div>
      </div>
      @empty
      <p>No hosts yet</p>
      @endforelse
    </div>

    <!-- @forelse ($hosts as $host)
        <div class="col">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">{{ $host->name }}</h5>
              <h6 class="card-subtitle mb-2 text-muted" id="host-{{ $host->id }}">Last updated: {{ minValue($host->checks) }}</h6>
              @forelse (onlyEnabled($host->checks) as $check)
              <ul class="mt-3">
                <li id="check-{{ $check->id }}">
                  {{ $check->type }}: <span class="{{ $check->type }} {{ numberTextClass($check->type, $check->status, $check->last_run_message) }}">{{ $check->last_run_message }}</span>
                </li>
              </ul>
              @empty
              <p class="card-text">No checks yet</p>
              @endforelse
            </div>
          </div>
        </div>
        @empty
        <p>No hosts yet</p>
        @endforelse -->

    <!-- </div>
    </main> -->
  </div>

  <script src="{{ asset('js/index.js') }}" defer></script>

</body>

</html>