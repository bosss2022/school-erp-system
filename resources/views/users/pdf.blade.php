<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>System Users</title>

<style>

body{

    font-family: DejaVu Sans;

    font-size:12px;

}

h2{

    text-align:center;

    margin-bottom:5px;

}

p{

    text-align:center;

    margin-top:0;

    margin-bottom:20px;

}

table{

    width:100%;

    border-collapse:collapse;

}

table th{

    background:#198754;

    color:#fff;

    border:1px solid #000;

    padding:8px;

}

table td{

    border:1px solid #000;

    padding:6px;

}

.role{

    text-transform:capitalize;

}

.footer{

    margin-top:20px;

    text-align:center;

    font-size:11px;

}

</style>

</head>

<body>

<h2>MASU SCHOOL OF GRACE</h2>

<p>System User Login Credentials</p>

<table>

<thead>

<tr>

<th>#</th>

<th>Name</th>

<th>Email</th>

<th>Role</th>

<th>Default Password</th>

</tr>

</thead>

<tbody>

@foreach($users as $user)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $user->name }}</td>

<td>{{ $user->email }}</td>

<td class="role">{{ ucfirst($user->role) }}</td>

<td>{{ $user->default_password }}</td>

</tr>

@endforeach

</tbody>

</table>

<div class="footer">

Generated on {{ now()->format('d M Y H:i') }}

</div>

</body>

</html>