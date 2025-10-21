/*!
* Start Bootstrap - Modern Business v5.0.7 (https://startbootstrap.com/template-overviews/modern-business)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-modern-business/blob/master/LICENSE)
*/

// Use this file to add JavaScript to your project


// NOTE: Login and Registration forms will be fully implemented later
document.addEventListener('DOMContentLoaded', () => {
    // Registration Form
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const password = document.getElementById('password')?.value.trim();
            const confirmPassword = document.getElementById('confirmPassword')?.value.trim();
  
            if (!registrationForm.checkValidity()) {
                registrationForm.reportValidity();
                return;
            }
  
            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                return;
            }
  
            alert("Registration successful!");
            registrationForm.reset();
        });
    }
  
    // Login Form
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!loginForm.checkValidity()) {
                loginForm.reportValidity();
                return;
            }
            alert("Login successful!");
            loginForm.reset();
        });
    }
  
  });
  