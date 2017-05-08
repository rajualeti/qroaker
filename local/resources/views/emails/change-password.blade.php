Password changed successfully. 
<br>
<br>
Your login details are below.
<br>
Email: {{ $data['email'] }}
<br>
Secret pin: {{ $data['password'] }}
<br>
<br>

<a href="{{ url('auth/login') }}" target="_blank">Click here</a> to login into <a href="{{ url('home') }}" target="_blank">Qroaker</a>.

