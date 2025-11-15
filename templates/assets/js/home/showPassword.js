document.querySelectorAll(".toggle-password").forEach(btn => {
    btn.addEventListener("click", function () {
        const input = this.previousElementSibling; // Lấy input nằm trước nút
        if (input.type === "password") {
            input.type = "text";
            this.textContent = "🙈";
        } else {
            input.type = "password";
            this.textContent = "👁";
        }
    });
});