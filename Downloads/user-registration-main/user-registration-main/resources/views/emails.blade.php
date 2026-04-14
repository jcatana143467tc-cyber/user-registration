<!DOCTYPE html>
<html>
<head>
    <title>Email List</title>
</head>
<body>

<h2>Add an Email</h2>

<form method="POST" action="/emails">
    @csrf
    <input type="text" name="email" placeholder="Enter email">
    <button type="submit">Add</button>
</form>

<h3>Saved Emails</h3>
<ul>
    @foreach($emails as $index => $email)
        <li>
            <!-- Edit form -->
            <form method="POST" action="/emails/edit/{{ $index }}" style="display:inline;">
                @csrf
                <input type="text" name="email" value="{{ $email }}">
                <button type="submit">Save</button>
            </form>

            <!-- Delete form -->
            <form method="POST" action="/emails/delete/{{ $index }}" style="display:inline;">
                @csrf
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>

</body>
</html>