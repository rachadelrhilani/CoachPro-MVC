document.addEventListener("DOMContentLoaded", () => {


    const showError = (input, message) => {
        removeError(input);
        const error = document.createElement("p");
        error.className = "text-red-600 text-sm mt-1";
        error.innerText = message;
        input.closest("div").appendChild(error);
        input.classList.add("border-red-500");
    };

    const removeError = (input) => {
        const parent = input.closest("div");
        if (!parent) return;
        parent.querySelectorAll(".text-red-600").forEach(e => e.remove());
        input.classList.remove("border-red-500");
    };

    const isEmailValid = (email) => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    };

    const isPasswordStrong = (password) => {
        return /^(?=.*[A-Za-z])(?=.*\d).{8,}$/.test(password);
    };

    /* =======================
       LOGIN VALIDATION
    ======================= */
    const loginForm = document.querySelector('form[action$="/login"]');

    if (loginForm) {
        loginForm.addEventListener("submit", (e) => {
            let valid = true;

            const email = loginForm.querySelector('input[name="email"]');
            const password = loginForm.querySelector('input[name="password"]');

            removeError(email);
            removeError(password);

            if (!isEmailValid(email.value)) {
                showError(email, "Email invalide");
                valid = false;
            }

            if (password.value.trim() === "") {
                showError(password, "Mot de passe requis");
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    /* =======================
       REGISTER VALIDATION
    ======================= */
    const registerForm = document.querySelector('form[action$="/register"]');

    if (registerForm) {
        registerForm.addEventListener("submit", (e) => {
            let valid = true;

            const nom = registerForm.querySelector('input[name="nom"]');
            const prenom = registerForm.querySelector('input[name="prenom"]');
            const email = registerForm.querySelector('input[name="email"]');
            const password = registerForm.querySelector('input[name="password"]');
            const role = registerForm.querySelector('select[name="role"]');

            const discipline = registerForm.querySelector('input[name="discipline"]');
            const experience = registerForm.querySelector('input[name="experience"]');
            const description = registerForm.querySelector('textarea[name="description"]');

            [nom, prenom, email, password, role, discipline, experience, description]
                .filter(Boolean)
                .forEach(removeError);

            if (nom.value.length < 2) {
                showError(nom, "Nom trop court");
                valid = false;
            }

            if (prenom.value.length < 2) {
                showError(prenom, "Prénom trop court");
                valid = false;
            }

            if (!isEmailValid(email.value)) {
                showError(email, "Email invalide");
                valid = false;
            }

            if (!isPasswordStrong(password.value)) {
                showError(password, "Min 8 caractères avec lettres et chiffres");
                valid = false;
            }

            if (!role.value) {
                showError(role, "Veuillez choisir un rôle");
                valid = false;
            }

            /* Coach fields */
            if (role.value === "coach") {
                if (!discipline.value.trim()) {
                    showError(discipline, "Discipline requise");
                    valid = false;
                }

                if (experience.value < 0 || experience.value === "") {
                    showError(experience, "Expérience invalide");
                    valid = false;
                }

                if (description.value.length < 10) {
                    showError(description, "Description trop courte");
                    valid = false;
                }
            }

            if (!valid) e.preventDefault();
        });
    }
});
document.getElementById('role').addEventListener('change', function () {
    const coachFields = document.getElementById('coach-fields');
    if (this.value === 'coach') {
        coachFields.classList.remove('hidden');
    } else {
        coachFields.classList.add('hidden');
    }
});
