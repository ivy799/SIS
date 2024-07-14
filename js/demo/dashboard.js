document.querySelectorAll('.edit-button').forEach(button => {
    button.addEventListener('click', event => {
        const id = event.currentTarget.getAttribute('data-id');
        const nisn = event.currentTarget.getAttribute('data-nisn');
        const tahun = event.currentTarget.getAttribute('data-tahun');
        const nama = event.currentTarget.getAttribute('data-nama');
        const gender = event.currentTarget.getAttribute('data-gender');
        const ttl = event.currentTarget.getAttribute('data-ttl');
        const nomor = event.currentTarget.getAttribute('data-nomor');
        const alamat = event.currentTarget.getAttribute('data-alamat');
        const kelas = event.currentTarget.getAttribute('data-kelas');
        const status = event.currentTarget.getAttribute('data-status');

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nisn').value = nisn;
        document.getElementById('edit-tahun').value = tahun;
        document.getElementById('edit-nama').value = nama;
        document.querySelector(`input[name="gender"][value="${gender}"]`).checked = true;
        document.getElementById('edit-ttl').value = ttl;
        document.getElementById('edit-nomor').value = nomor;
        document.getElementById('edit-alamat').value = alamat;
        document.querySelector(`select[name="kelas"] option[value="${kelas}"]`).selected = true;
        document.querySelector(`input[name="status"][value="${status}"]`).checked = true;
    });
});


