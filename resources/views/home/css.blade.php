<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LibraryQ</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<style>
    body {
        background-color: #001327;
        color: aliceblue;
    }

    h1 {
        text-align: center;
        position: relative;
        font-weight: bold;
    }

    .about p {
        font-size: 1.1em;
        text-align: center;
        color: #444;
        line-height: 1.8;
        max-width: 800px;
        margin: 20px auto;
        padding: 0 20px;
    }

    svg {
        display: block;
    }

    /* Navbar fixed */
    .navbar {
        box-shadow: 0 4px 10px #003369bd;
        background: #001327;
        color: white;
    }

    /* Mengatur tampilan tombol di navbar */
    .navbar .btn {
        font-weight: 500;
        border-radius: 5px;
    }

    /* Responsif: tombol login/register ke tengah pada layar kecil */
    @media (max-width: 992px) {
        .navbar .d-flex {
            flex-direction: column;
            width: 100%;
            align-items: center;
        }

        .navbar .d-flex form {
            width: 100%;
            margin-bottom: 10px;
        }

        .navbar .btn {
            width: 100%;
            margin-bottom: 5px;
        }
    }


    /* Slogan */
    .slogan {
        text-align: center;
        font-size: 1.8rem;
        font-weight: bold;
        color: #007bff;
        margin-top: 100px;
        padding: 15px;
        background: linear-gradient(90deg, rgba(0, 123, 255, 0.1) 0%, rgba(0, 123, 255, 0.3) 100%);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Genre List */
    .genre-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin: 20px 0;
    }

    .genre-list span {
        padding: 8px 15px;
        font-size: 1rem;
        font-weight: 600;
        color: #007bff;
        border-radius: 20px;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .genre-list span:hover {
        background: #007bff;
        color: white;
    }


    /* swipper */

    .swiper-container {
        width: 100%;
        max-width: 100%;
        margin: auto;
        overflow: hidden;
        position: relative;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
    }

    .card {
        background-color: #162245;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 20px;
        display: flex;
        flex-direction: row;
        /* Gambar di kiri */
        align-items: center;
        gap: 20px;
        color: #fff;
        width: 100%;
        max-width: 1000px;
        height: auto;
    }

    .card img {
        width: 225px;
        height: 100%;
        border-radius: 8px;
    }

    .card-content {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }

    .card-content h3 {
        margin: 0;
        font-size: 18px;
    }

    .card-content p {
        margin: 0;
        font-size: 14px;
        line-height: 1.5;
    }

    .card-content button {
        background-color: #4e73df;
        border: none;
        border-radius: 6px;
        color: white;
        padding: 8px 16px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
        align-self: center;
        /* Tombol di tengah */
    }

    .card-content button:hover {
        background-color: #375bc7;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #fff;
        background-color: rgba(22, 34, 69, 0.8);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .swiper-button-prev::after,
    .swiper-button-next::after {
        font-size: 18px;
        color: white;
    }

    @media (max-width: 768px) {
        .card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .card img {
            width: 120px;
        }

        .card-content button {
            align-self: center;
            /* Tombol di tengah */
        }

        .swiper-button-next,
        .swiper-button-prev {
            width: 30px;
            height: 30px;
        }

        .swiper-button-next {
            right: 5%;
        }

        .swiper-button-prev {
            left: 5%;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slogan {
            font-size: 1.5rem;
            padding: 10px;
        }
    }


    .genre-section {
        background-color: #162245;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .genre-title {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .book-container {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    .book-container::-webkit-scrollbar {
        height: 8px;
    }

    .book-container::-webkit-scrollbar-thumb {
        background: #30363d;
        border-radius: 10px;
    }

    .book-container::-webkit-scrollbar-thumb:hover {
        background: #213264;
    }

    .koleksi-buku {
        flex: 0 0 auto;
        background: #213264;
        border: 1px solid #146acc;
        border-radius: 10px;
        padding: 15px;
        width: 250px;
        text-align: center;
    }

    .koleksi-buku img {
        width: 100%;
        height: 325px;
        object-fit: cover;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .koleksi-buku h6 {
        font-size: 15px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .koleksi-buku p {
        font-size: 12px;
        color: #8b949e;
        margin-bottom: 10px;
    }

    .koleksi-buku .btn {
        background-color: #146acc;
        color: white;
        font-size: 15px;
        border: none;
        padding: 10px 40%;
        border-radius: 5px;
    }

    .koleksi-buku .btn:hover {
        background-color: #007bff;
    }


    footer a {
        text-decoration: none;
        color: #8aa6c1;
        /* Warna teks link awal */
        transition: color 0.3s;
    }

    footer a:hover {
        color: #f0f0f0;
        /* Warna teks saat hover */
    }

    footer hr {
        border: none;
        height: 1px;
        background-color: #1e3a56;
        /* Garis pembatas */
    }
</style>