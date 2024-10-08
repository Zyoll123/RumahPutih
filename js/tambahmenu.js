const fileInput = document.getElementById("fileUpload");
const fileNameDisplay = document.getElementById("fileName");

fileInput.addEventListener("change", function () {
    if (fileInput.files.length > 0) {
        fileNameDisplay.textContent = fileInput.files[0].name; // Menampilkan nama file yang dipilih
    } else {
        fileNameDisplay.textContent = "Tidak ada file yang dipilih.";
    }
});

function toggleLabel(input) {
    const label = input.nextElementSibling;
    if (input.value) {
        label.classList.add('hidden');
    } else {
        label.classList.remove('hidden');
    }
}