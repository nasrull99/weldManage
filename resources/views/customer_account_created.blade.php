<p>Hello,</p>
<p>Your account has been created by the admin. Here are your login details:</p>
<ul>
    <li><strong>Username:</strong> {{ $username }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
</ul>
<p>
    <a href="{{ url('/login') }}" style="color: #fff; background: #007bff; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
        Click here to log in
    </a>
</p>
<p>Please log in and change your password after your first login.</p>