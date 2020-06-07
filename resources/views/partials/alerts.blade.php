@if(session('error'))
    <div class="uk-width-1-1">
        <x-alert type="error" :message="session('error')"></x-alert>
    </div>
@endif

@if(session('success'))
    <div class="uk-width-1-1">
        <x-alert type="success" :message="session('success')"></x-alert>
    </div>
@endif

@if(session('warning'))
    <div class="uk-width-1-1">
        <x-alert type="warning" :message="session('warning')"></x-alert>
    </div>
@endif


