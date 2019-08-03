<div class="container">
    <div>
        <a href="#" class="btn btn-primary">
            {{ __('Edit') }}
        </a>

        <a href="#" class="btn btn-danger">
            {{ __('Delete') }}
        </a>
    </div>

    <dl class="row">
        <dt class="col-md-2">{{ __('ID') }}</dt>
        <dd class="col-md-10">{{ $user->id }}</dd>
        <dt class="col-md-2">{{ __('Name') }}</dt>
        <dd class="col-md-10">{{ $user->name }}</dd>
        <dt class="col-md-2">{{ __('E-Mail Address') }}</dt>
        <dd class="col-md-10">{{ $user->email }}</dd>
    </dl>
</div>