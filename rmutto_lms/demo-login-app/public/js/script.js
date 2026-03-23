document.addEventListener('DOMContentLoaded', () => {

    // 1. Password show / hide toggle functionality (Supports multiple fields)
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');

    if (togglePasswordBtns.length > 0) {
        togglePasswordBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const inputGroup = btn.closest('.password-group');
                const passwordInput = inputGroup.querySelector('input');

                if (passwordInput) {
                    // Toggle type attribute safely
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                    // Toggle the SVG icon within the button
                    if (isPassword) {
                        // 'Eye' Icon indicating text is visible
                        btn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        `;
                    } else {
                        // 'Eye Off' Icon indicating text is hidden
                        btn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        `;
                    }
                }
            });
        });
    }

    // 2. Role switch behavior tracking
    const roleRadios = document.querySelectorAll('input[name="role"]');
    roleRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            console.log(`Role switched to: ${e.target.value}`);
        });
    });

    // 3. Verification Code Input Navigation Auto-focus
    const verifyInputs = document.querySelectorAll('.verification-code input');

    if (verifyInputs.length > 0) {
        verifyInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Ensure only numbers
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                if (e.target.value.length === 1 && index < verifyInputs.length - 1) {
                    verifyInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    verifyInputs[index - 1].focus();
                }
            });
        });
    }

    // 4. Basic form interaction (Login Simulation)
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            const username = document.getElementById('username')?.value.trim();
            const password = document.getElementById('password')?.value.trim();

            if (!username || !password) {
                e.preventDefault();
                alert('Please provide your credentials below');
                return;
            }

            const submitBtn = loginForm.querySelector('.btn-primary');
            submitBtn.textContent = 'Processing...';
            // Do not disable or it won't submit the value
        });
    }
});
