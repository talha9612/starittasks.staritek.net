<!-- <!DOCTYPE html>
<html>
<head>
    <title>Task Due Reminder</title>
</head>
<body>
    <h1>Reminder: Task "{{ $task->heading }}" is due soon!</h1>
    <p>Dear {{ $task->created_by }} and {{ $task->user_id }},</p>
    <p>The task "{{ $task->heading }}" is due on {{ $task->due_date }}.</p>
    <p>Please make sure to complete the necessary actions before the deadline.</p>
    <p>Thank you!</p>
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
    <title>Task Due Reminder</title>
</head>
<body>
    <h1>Reminder: Task "{{ $task->heading }}" is due soon!</h1>
    <p>Dear {{ $task->creator->name }} and {{ $task->assignee->name }},</p>
    <p>The task "{{ $task->heading }}" is due on {{ $task->due_date }}.</p>
    <p>Please make sure to complete the necessary actions before the deadline.</p>
    <p>Thank you!</p>
</body>
</html>
