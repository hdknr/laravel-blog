<div class="container">
    <form action="{{ url('users/'.$user->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">
            {{ __('Name') }}
            </label>
            <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">
            {{ __('Submit') }}
        </button>
    </form>
</div>