<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>Guardian Meeting Invitation</h2>

    <p>Dear {{ $guardian->first_name }},</p>

    <p>
        You are invited to attend the following school meeting:
    </p>

    <table cellpadding="8">

        <tr>
            <td><strong>Title:</strong></td>
            <td>{{ $meeting->title }}</td>
        </tr>

        <tr>
            <td><strong>Date:</strong></td>
            <td>{{ $meeting->meeting_date }}</td>
        </tr>

        <tr>
            <td><strong>Time:</strong></td>
            <td>{{ $meeting->meeting_time }}</td>
        </tr>

        <tr>
            <td><strong>Venue:</strong></td>
            <td>{{ $meeting->venue }}</td>
        </tr>

    </table>

    <h4>Agenda</h4>

    <p>
        {{ $meeting->agenda }}
    </p>

    <br>

    <p>
        We look forward to your attendance.
    </p>

    <p>
        Regards,<br>
        School Administration
    </p>

</body>
</html>