<p>Hello {{ $proposal->group->name }},</p>

<p>Your proposal titled "{{ $proposal->title }}" has been reviewed by your supervisor.</p>

@if($status == 'Approved')
    <p>The proposal has been approved.</p>
@else
    <p>The proposal requires revision. The supervisor commented:</p>
    <blockquote>{{ $comment->comment }}</blockquote>
@endif

<p>You can log in to the system to view the proposal details and any additional comments.</p>

<p>Best regards,<br>Your Institution</p>
