<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ Bán Ghế</title>
    <link rel="stylesheet" href="LienHe.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            color: white;
            background-color: #dc3545;
            padding: 10px 0;
            margin-bottom: 20px;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 20px 0;
        }

        .contact-section h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #34495e;
        }

        .contact-info,
        .contact-form,
        .map-container {
            width: 48%;
            margin-bottom: 30px;
        }

        .contact-info p {
            font-size: 1.1rem;
            margin: 10px 0;
        }

        .contact-form form {
            display: flex;
            flex-direction: column;
        }

        .contact-form label {
            font-size: 1.1rem;
            margin: 10px 0 5px;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .contact-form button {
            margin-top: 10px;
            padding: 10px;
            background-color: #3498db;
            border: none;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            border-radius: 5px;
        }

        .contact-form button:hover {
            background-color: #2980b9;
        }

        .map-container iframe {
            width: 100%;
            border: none;
            border-radius: 10px;
        }

        @media (max-width: 768px) {

            .contact-info,
            .contact-form,
            .map-container {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Liên Hệ Bán Ghế</h1>
    </header>

    <section class="contact-section">
        <div class="container">
            <!-- Bản đồ ở trên -->
            <div class="map-container">
                <h2>Bản Đồ</h2>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d576.5155064388532!2d106.71233458967164!3d10.801569717044563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528a529292091%3A0xed4d23edfba9c775!2zMzkxIMSQLiDEkGnhu4duIEJpw6puIFBo4bunLCBQaMaw4budbmcgMjUsIELDrG5oIFRo4bqhbmgsIEjhu5MgQ2jDrCBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1725554429818!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <!-- Form liên hệ ở giữa -->
            <div class="contact-form">
                <h2>Liên Hệ Với Chúng Tôi</h2>
                <form action="#" method="post">
                    <label for="name">Họ và Tên</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Lời nhắn</label>
                    <textarea id="message" name="message" rows="5" required></textarea>

                    <button type="submit">Gửi</button>
                </form>
            </div>

            <!-- Thông tin liên hệ ở dưới -->
            <div class="contact-info">
                <h2>Thông Tin Liên Hệ</h2>
                <p>Email: beccchaanh@gmail.com</p>
                <p>Điện thoại: 0909999909</p>
                <p>Địa chỉ: 391 Điện Biên Phủ, phường 25, quận Bình Thạnh, TP.HCM</p>
            </div>
        </div>
    </section>

</body>

</html>