<div class="container">
    @foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td><a href="{{ url('users/'.$user->id) }}">{{ $user->name }}</a></td>
    </tr>
    @endforeach 
</div>
