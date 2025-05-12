document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('dataForm');

    form.addEventListener('submit', function(event) {
        let isValid = true;
        const formElements = form.querySelectorAll('input, select, textarea');

        formElements.forEach(element => {
            if (element.hasAttribute('required') && element.value.trim() === '') {
                isValid = false;
                element.classList.add('is-invalid'); // Добавляем класс Bootstrap для отображения ошибки
            } else {
                element.classList.remove('is-invalid');
            }

            // Дополнительная валидация для числовых полей
            if (element.type === 'number') {
                if (isNaN(element.value)) {
                    isValid = false;
                    element.classList.add('is-invalid');
                }
            }

        });

        if (!isValid) {
            event.preventDefault(); // Предотвращаем отправку формы
            alert('Пожалуйста, заполните все обязательные поля.');
        }
    });
});
