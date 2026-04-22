<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Login BK System</title>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>

body{
    font-family:Poppins;
    background:#f5f6fa;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    background:white;
    padding:40px;
    border-radius:12px;
    width:350px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.login-box h2{
    text-align:center;
    margin-bottom:20px;
}

/* ALERT */
.alert{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    font-size:14px;
    animation:fadeIn 0.4s ease-in-out;
}

.error-alert{
    background:#ffe5e5;
    color:#d63031;
    border-left:5px solid #d63031;
}

.alert i{
    font-size:18px;
}

/* INPUT */
.form-group{
    margin-bottom:15px;
    position:relative;
}

.form-group input{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:6px;
}

input:focus{
    outline:none;
    border-color:#3C91E6;
}

input.error-input{
    border-color:#d63031;
    background:#fff5f5;
}

small{
    color:#d63031;
}

/* BUTTON */
button{
    width:100%;
    padding:10px;
    background:#3C91E6;
    border:none;
    color:white;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#2d7dd2;
}

/* ICON PASSWORD */
.toggle-icon{
    position:absolute;
    right:10px;
    top:10px;
    cursor:pointer;
    font-size:18px;
    color:#555;
}

/* ANIMATION */
@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(-10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

</style>

</head>

<body>

<div class="login-box">

<h2>Login Admin</h2>

{{-- ERROR GLOBAL --}}
@if(session('error'))
<div class="alert error-alert">
    <i class='bx bx-error-circle'></i>
    <span>{{ session('error') }}</span>
</div>
@endif

<form action="/login" method="POST">
@csrf

<!-- EMAIL -->
<div class="form-group">
    <input
        type="email"
        name="email"
        placeholder="Email"
        value="{{ old('email') }}"
        class="@error('email') error-input @enderror"
    >

    @error('email')
    <small>{{ $message }}</small>
    @enderror
</div>

<!-- PASSWORD -->
<div class="form-group">
    <input
        type="password"
        id="password"
        name="password"
        placeholder="Password"
        class="@error('password') error-input @enderror"
    >

    <i class='bx bx-hide toggle-icon' id="togglePassword"></i>

    @error('password')
    <small>{{ $message }}</small>
    @enderror
</div>

<!-- REMEMBER -->
<div style="margin-bottom:15px;">
    <input type="checkbox" name="remember"> Remember Me
</div>

<!-- BUTTON -->
<button type="submit" id="loginBtn">
Login
</button>

</form>

</div>

<script>

// TOGGLE PASSWORD
const toggle = document.getElementById('togglePassword');
const password = document.getElementById('password');

toggle.addEventListener('click', function () {
    const isPassword = password.type === 'password';

    password.type = isPassword ? 'text' : 'password';

    this.classList.toggle('bx-show');
    this.classList.toggle('bx-hide');
});

// LOADING BUTTON
document.querySelector("form").addEventListener("submit", function(){
    document.getElementById("loginBtn").innerText = "Loading...";
});

</script>

</body>
</html>
