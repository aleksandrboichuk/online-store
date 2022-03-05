$('input').on('input invalid', function() {
    this.setCustomValidity('');
    if (this.validity.valueMissing) {
        this.setCustomValidity("Будь-ласка, заповніть це поле")
    }
    if (this.validity.typeMismatch) {
        this.setCustomValidity("Не відповідає типу поля")
    }
    if (this.validity.patternMismatch) {
        this.setCustomValidity("Не відповідає патерну")
    }
})