// small helper for confirm actions
function confirmDelete(msg){
    return confirm(msg || 'هل أنت متأكد من الحذف؟');
}
// Optional: Add logout confirmation
document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function () {
            if (confirm("هل أنت متأكد من رغبتك في الخروج؟")) {
                alert("تم تسجيل الخروج بنجاح.");
                // window.location.href = "login.html"; // Uncomment to redirect
            }
        });
    }
});