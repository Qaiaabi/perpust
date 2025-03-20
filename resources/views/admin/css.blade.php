<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Sidebar */
    #sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        padding: 20px;
        transition: all 0.3s;
    }

    #page-content-wrapper {
        margin-left: 250px;
        width: calc(100% - 250px);
        transition: all 0.3s;
    }

    /* Sidebar toggled */
    #wrapper.toggled #sidebar {
        margin-left: -250px;
    }

    #wrapper.toggled #page-content-wrapper {
        margin-left: 0;
        width: 100%;
    }

    /* Navbar */
    .navbar {
        padding: 15px;
    }

    /* Card Styling */
    .card {
        border-radius: 8px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        #sidebar {
            margin-left: -250px;
        }

        #page-content-wrapper {
            margin-left: 0;
            width: 100%;
        }

        #wrapper.toggled #sidebar {
            margin-left: 0;
        }
    }
    /* Indentasi submenu Buku */
#sidebar ul ul {
    margin-left: 15px;
}

#sidebar .nav-link {
    padding: 8px 15px;
}

#sidebar .nav-link:hover {
    background-color: #495057; /* Warna hover */
    color: white;
}

/* Ikon dan teks submenu */
#sidebar ul ul .nav-link {
    font-size: 14px;
    color: rgb(190, 190, 190);
}

#sidebar ul ul .nav-link:hover {
    color: white;
}

/* Aktifkan transisi untuk pengalaman yang lebih mulus */
#sidebar .nav-link {
    transition: background-color 0.2s, color 0.2s;
}

</style>