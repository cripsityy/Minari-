document.addEventListener('DOMContentLoaded', function() {
    const codMethod = document.getElementById('codMethod');
    const virtualMethod = document.getElementById('virtualMethod');
    const ewalletMethod = document.getElementById('ewalletMethod');

    loadSelectedPaymentMethod();

    codMethod.addEventListener('click', () => selectMethod('cod'));
    virtualMethod.addEventListener('click', () => selectMethod('virtual'));
    ewalletMethod.addEventListener('click', () => selectMethod('ewallet'));

    function loadSelectedPaymentMethod() {
        const selected = localStorage.getItem('selectedPaymentMethod') || 'cod';

        document.querySelectorAll('.payment-method-item')
            .forEach(item => item.classList.remove('selected'));

        if (selected === 'cod') codMethod.classList.add('selected');
        if (selected === 'virtual') virtualMethod.classList.add('selected');
        if (selected === 'ewallet') ewalletMethod.classList.add('selected');
    }

    function selectMethod(method) {
        localStorage.setItem('selectedPaymentMethod', method);
        loadSelectedPaymentMethod();

        setTimeout(() => {
            window.location.href = "/payment";
        }, 500);
    }
});
