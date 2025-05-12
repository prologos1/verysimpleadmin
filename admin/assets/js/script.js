 
document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', function(event) {
        if (!confirm('Вы уверены, что хотите удалить эту запись?')) {
            event.preventDefault();
        }
    });
});
