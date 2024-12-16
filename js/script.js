document.querySelectorAll('.plusBtn').forEach((button) => {
    button.addEventListener('click', (e) => {
        const input = e.target.parentElement.querySelector('.numberInput');
        input.value = parseInt(input.value) + 1;
        updateTotalHarga();
    });
});

document.querySelectorAll('.minusBtn').forEach((button) => {
    button.addEventListener('click', (e) => {
        const input = e.target.parentElement.querySelector('.numberInput');
        if (input.value > 0) {
            input.value = parseInt(input.value) - 1;
            updateTotalHarga();
        }
    });
});

function updateTotalHarga() {
    let total = 0;

    document.querySelectorAll('.numberInput').forEach((input) => {
        const quantity = parseInt(input.value) || 0; // Default ke 0 jika kosong atau bukan angka
        const price = parseInt(input.getAttribute('data-harga')) || 0; // Pastikan harga produk valid
        total += quantity * price; // Hitung total harga
    });

    document.getElementById('totalHarga').textContent = total.toLocaleString();
}

// Memastikan total harga diperbarui ketika pengguna mengubah input secara manual
document.querySelectorAll('.numberInput').forEach((input) => {
    input.addEventListener('input', updateTotalHarga);
});
