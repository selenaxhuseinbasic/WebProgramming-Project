/*!
* Start Bootstrap - Modern Business v5.0.7 (https://startbootstrap.com/template-overviews/modern-business)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-modern-business/blob/master/LICENSE)
*/

document.addEventListener('DOMContentLoaded', () => {
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', e => {
            e.preventDefault();
            const password = document.getElementById('password')?.value.trim();
            const confirmPassword = document.getElementById('confirmPassword')?.value.trim();
            if (!registrationForm.checkValidity()) { registrationForm.reportValidity(); return; }
            if (password !== confirmPassword) { alert("Passwords do not match."); return; }
            alert("Registration successful!"); registrationForm.reset();
        });
    }

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', e => {
            e.preventDefault();
            if (!loginForm.checkValidity()) { loginForm.reportValidity(); return; }
            alert("Login successful!"); loginForm.reset();
        });
    }

    // User Profile Modal
    const userProfileModalEl = document.getElementById('userProfileModal');
    const userProfileModal = new bootstrap.Modal(userProfileModalEl);
    const profileSaveBtn = document.getElementById('profileSaveBtn');
    const profileForm = document.getElementById('userProfileForm');
    const profileInputs = Array.from(profileForm.querySelectorAll('input'));
    const userNameHeader = document.getElementById('userNameHeader');
    const profilePhotoInput = document.getElementById('profilePhoto');
    const profilePhotoPreview = document.getElementById('profilePhotoPreview');
    const profilePhotoEditBtn = document.getElementById('profilePhotoEditBtn');
    const uploadPhotoBtn = document.getElementById('uploadPhotoBtn');
    const deletePhotoBtn = document.getElementById('deletePhotoBtn');
    const photoDropdown = document.getElementById('photoOptionsDropdown');

    let userData = {
        firstName: "Selena",
        lastName: "Huseinbasic",
        email: "selena.huseinbasic@stu.ibu.edu.ba",
        phone: "(555) 123-4567",
        password: "",
        photo: "assets/photos/staff-IC.jpg"
    };
    const defaultAvatar = "assets/photos/default-avatar.svg";

    document.querySelector('#openProfileModalBtn')?.addEventListener('click', e => {
        e.preventDefault();
        profileInputs.forEach(input => {
            if (input.id === 'profileFirstName') input.value = userData.firstName;
            if (input.id === 'profileLastName') input.value = userData.lastName;
            if (input.id === 'profileEmail') input.value = userData.email;
            if (input.id === 'profilePhone') input.value = userData.phone;
            if (input.id === 'profilePassword') input.value = "";
        });
        userNameHeader.textContent = userData.firstName;
        profilePhotoPreview.src = userData.photo;
        profileSaveBtn.disabled = true;
        userProfileModal.show();
    });

    profileInputs.forEach(input => {
        input.addEventListener('input', () => {
            profileSaveBtn.disabled = false;
            userNameHeader.textContent = document.getElementById('profileFirstName').value || "User";
        });
    });

    // Edit dropdown toggle
    profilePhotoEditBtn.addEventListener('click', e => {
        e.stopPropagation();
        photoDropdown.classList.toggle('show');
    });
    document.addEventListener('click', () => photoDropdown.classList.remove('show'));

    uploadPhotoBtn.addEventListener('click', () => profilePhotoInput.click());
    deletePhotoBtn.addEventListener('click', () => {
        profilePhotoPreview.src = defaultAvatar;
        profileSaveBtn.disabled = false;
    });

    profilePhotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => profilePhotoPreview.src = e.target.result;
            reader.readAsDataURL(file);
            profileSaveBtn.disabled = false;
        }
    });

    // Profile Save Changes
    profileSaveBtn.addEventListener('click', () => {
        // Update user data
        userData.firstName = document.getElementById('profileFirstName').value.trim();
        userData.lastName = document.getElementById('profileLastName').value.trim();
        userData.email = document.getElementById('profileEmail').value.trim();
        userData.phone = document.getElementById('profilePhone').value.trim();
        const newPassword = document.getElementById('profilePassword').value.trim();
        if (newPassword) userData.password = newPassword;
        if (profilePhotoPreview.src !== userData.photo) userData.photo = profilePhotoPreview.src;
        userNameHeader.textContent = userData.firstName;
        profileSaveBtn.disabled = true;

        alert("Profile changes saved (frontend simulation).");
    });

    // Logout button
    document.getElementById('logoutBtn').addEventListener('click', () => alert("Logged out (simulation)."));
});

// Sparkle effect <3
const sparkleContainer = document.getElementById('sparkleContainer');
let sparkleInterval;
function createSparkle() {
    const sparkle = document.createElement('div');
    sparkle.classList.add('sparkle');
    sparkle.style.left = Math.random() * window.innerWidth + 'px';
    sparkle.style.top = Math.random() * window.innerHeight + 'px';
    sparkleContainer.appendChild(sparkle);
    setTimeout(() => sparkle.remove(), 2000);
}
document.getElementById('userProfileModal').addEventListener('show.bs.modal', () => {
    sparkleInterval = setInterval(createSparkle, 100);
});
document.getElementById('userProfileModal').addEventListener('hidden.bs.modal', () => {
    clearInterval(sparkleInterval);
});
