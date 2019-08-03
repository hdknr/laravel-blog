<div class="container">
    @foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td><a href="#">{{ $user->name }}</a></td>
    </tr>
    @endforeach 
</div>
