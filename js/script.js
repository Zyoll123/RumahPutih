function toggleLabel(input) {
    const label = input.nextElementSibling;
    if (input.value) {
        label.classList.add('hidden');
    } else {
        label.classList.remove('hidden');
    }
}

// Mengambil semua input number
const inputs = document.querySelectorAll('.numberInput');

// Fungsi untuk menambah nilai
function increment(input) {
    const max = parseInt(input.getAttribute('max'));
    let currentValue = parseInt(input.value);
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
    toggleButtons(input);
}

// Fungsi untuk mengurangi nilai
function decrement(input) {
    const min = parseInt(input.getAttribute('min'));
    let currentValue = parseInt(input.value);
    if (currentValue > min) {
        input.value = currentValue - 1;
    }
    toggleButtons(input);
}

// Fungsi untuk mengatur status tombol plus dan minus
function toggleButtons(input) {
    const container = input.closest('.input-number-container');
    const minusBtn = container.querySelector('.minusBtn');
    const plusBtn = container.querySelector('.plusBtn');
    const min = parseInt(input.getAttribute('min'));
    const max = parseInt(input.getAttribute('max'));

    minusBtn.disabled = parseInt(input.value) <= min;
    plusBtn.disabled = parseInt(input.value) >= max;
}

// Menambahkan event listener ke tombol
document.querySelectorAll('.input-number-container').forEach(container => {
    const input = container.querySelector('.numberInput');
    const minusBtn = container.querySelector('.minusBtn');
    const plusBtn = container.querySelector('.plusBtn');

    minusBtn.addEventListener('click', () => decrement(input));
    plusBtn.addEventListener('click', () => increment(input));

    // Inisialisasi status tombol saat pertama kali
    toggleButtons(input);
});

document.addEventListener("DOMContentLoaded", function () {
    const quantityInputs = document.querySelectorAll(".numberInput");
    const totalHargaElement = document.getElementById("totalHarga");

    function updateTotalHarga() {
        let total = 0;
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const harga = parseInt(input.closest(".menu-item").querySelector(".harga-produk").dataset.harga) || 0;
            total += quantity * harga;
        });
        totalHargaElement.textContent = total.toLocaleString("id-ID");
    }

    quantityInputs.forEach(input => {
        input.addEventListener("input", updateTotalHarga);
    });
});