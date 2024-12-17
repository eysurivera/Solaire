let codes = document.querySelectorAll('.otp_field')

codes[0].focus()

codes.forEach(function (code, idx) {
    code.addEventListener('keydown', function (e) {
        if (e.key >= 0 && e.key <= 9) {
            codes[idx].value = ''
            setTimeout(() => codes[idx + 1].focus(), 6)
        } else if (e.key === 'Backspace') {
            setTimeout(() => codes[idx - 1].focus(), 6)
        }
    })
})