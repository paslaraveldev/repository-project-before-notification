<!DOCTYPE html>
<html>
<head>
    <title>Proposal Modified</title>
</head>
<body>
    <p>Dear {{ $proposal->group->supervisor->name }},</p>

    <p>The proposal titled <strong>{{ $proposal->title }}</strong> has been modified by the student group.</p>

    <p>Description Update: {{ $proposal->description }}</p>

    <p>You can review the updated proposal using the following link:</p>
    <a href="{{ url('/proposals/' . $proposal->id) }}">View Proposal</a>

    <p>Best Regards,<br>
    Research Repository Team</p>
</body>
</html>
