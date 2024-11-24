<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Buku</title>
</head>
<body>
    <h1>Daftar Buku</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tanggal Terbit</th>
            </tr>
        </thead>
        <tbody id="book-table-body">
        </tbody>
    </table>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
<script>
    axios.get('http://127.0.0.1:8000/api/buku')
        .then(response => {
            const books = response.data.data.data;
            const tableBody = document.getElementById('book-table-body');

            books.forEach(book => {
                const row = `<tr>
                    <td>${book.id}</td>
                    <td>${book.judul}</td>
                    <td>${book.penulis}</td>
                    <td>${book.harga}</td>
                    <td>${new Date(book.tgl_terbit).toLocaleDateString()}</td>
                </tr>`;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
</script>
</html>

