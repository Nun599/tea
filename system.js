// all_js/system.js
document.addEventListener('DOMContentLoaded', function () {
  const tabRegister = document.getElementById('tab-register');
  const tabLogin = document.getElementById('tab-login');
  const regForm = document.getElementById('registerForm');
  const loginForm = document.getElementById('loginForm');

  function showRegister() {
    tabRegister.classList.add('active');
    tabLogin.classList.remove('active');
    regForm.style.display = 'block';
    loginForm.style.display = 'none';
  }

  function showLogin() {
    tabLogin.classList.add('active');
    tabRegister.classList.remove('active');
    loginForm.style.display = 'block';
    regForm.style.display = 'none';
  }

  tabRegister.addEventListener('click', showRegister);
  tabLogin.addEventListener('click', showLogin);

  // ✅ auto switch kung may ?show=login sa URL
  const params = new URLSearchParams(window.location.search);
  if (params.get('show') === 'login') {
    showLogin();
  } else {
    showRegister();
  }
});
