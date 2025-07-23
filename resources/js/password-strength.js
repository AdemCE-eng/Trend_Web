// Password Strength Checker
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthBars = document.querySelectorAll('.strength-bar');
    const strengthText = document.querySelector('.strength-text');
    const requirements = document.querySelectorAll('.requirement');
    
    // Exit early if required elements don't exist
    if (!passwordInput || !strengthText || strengthBars.length === 0) return;
    
    // Password strength checker function
    function checkPasswordStrength(password) {
        let strength = 0;
        let strengthLevel = 'Very Weak';
        
        // Define requirements
        const checks = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /\d/.test(password),
            special: /[@$!%*?&]/.test(password)
        };
        
        // Update requirement indicators (only if they exist)
        if (requirements.length > 0) {
            requirements.forEach(req => {
                const requirement = req.dataset.requirement;
                const icon = req.querySelector('.requirement-icon');
                
                if (icon && checks[requirement]) {
                    req.classList.add('text-success');
                    req.classList.remove('text-base-content/60');
                    icon.textContent = '✓';
                    icon.classList.add('text-success');
                    icon.classList.remove('text-base-content/40');
                    strength++;
                } else if (icon) {
                    req.classList.remove('text-success');
                    req.classList.add('text-base-content/60');
                    icon.textContent = '○';
                    icon.classList.remove('text-success');
                    icon.classList.add('text-base-content/40');
                }
            });
        }
        
        // Determine strength level and colors
        if (password.length === 0) {
            strengthLevel = 'Enter password';
            strength = 0;
        } else if (strength <= 1) {
            strengthLevel = 'Very Weak';
        } else if (strength === 2) {
            strengthLevel = 'Weak';
        } else if (strength === 3) {
            strengthLevel = 'Fair';
        } else if (strength === 4) {
            strengthLevel = 'Good';
        } else if (strength === 5) {
            strengthLevel = 'Strong';
        }
        
        // Update strength bars (only if they exist)
        if (strengthBars.length > 0) {
            strengthBars.forEach((bar, index) => {
                // Reset all colors
                bar.classList.remove('bg-error', 'bg-warning', 'bg-success', 'bg-info');
                
                if (index < strength) {
                    if (strength <= 2) {
                        bar.classList.add('bg-error'); // Red for weak
                    } else if (strength === 3) {
                        bar.classList.add('bg-warning'); // Yellow for fair
                    } else if (strength === 4) {
                        bar.classList.add('bg-info'); // Blue for good
                    } else {
                        bar.classList.add('bg-success'); // Green for strong
                    }
                } else {
                    // Keep default bg-base-300 for inactive bars
                }
            });
        }
        
        // Update strength text with appropriate color (only if element exists)
        if (strengthText) {
            strengthText.textContent = strengthLevel;
            strengthText.classList.remove('text-error', 'text-warning', 'text-success', 'text-info');
            
            if (password.length === 0) {
                strengthText.classList.add('text-base-content/70');
            } else if (strength <= 2) {
                strengthText.classList.add('text-error');
            } else if (strength === 3) {
                strengthText.classList.add('text-warning');
            } else if (strength === 4) {
                strengthText.classList.add('text-info');
            } else {
                strengthText.classList.add('text-success');
            }
        }
        
        return strength;
    }
    
    // Listen for password input changes
    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
    
    // Initialize with empty password
    checkPasswordStrength('');
});
