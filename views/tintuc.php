<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức</title>
    <link rel="stylesheet" href="TinTuc.css">
    <style>
        /* Basic Reset */
        .mb-40 {
            background-color: #DC3545;
            padding: 10px 0;
            margin-bottom: 20px;
            text-align: center;
            color: white;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .articles {
            max-width: 1200px;
            margin: 0 auto;
        }

        .news-content {
            display: flex;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .news-flex {
            display: flex;
            text-decoration: none;
            color: inherit;
            flex: 1;
        }

        .art-img {
            position: relative;
            flex: 0 0 200px;
        }

        .art-img img {
            width: 100%;
            height: auto;
        }

        .post-date {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #d0021b;
            color: #fff;
            text-align: center;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .post-date .day {
            font-size: 20px;
            font-weight: bold;
            display: block;
        }

        .post-date .month {
            font-size: 12px;
            display: block;
        }

        .art-info {
            padding: 15px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .title-article {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
            line-height: 1.3;
        }

        .body-content p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="articles clearfix" id="layout-page">
        <h1 class="mb-40">Tin tức</h1>

        <!-- Begin: Nội dung blog -->
        <div class="news-content">
            <a href="TinTuc/ghe-go-giam-doc.php" class="news-flex">
                <div class="art-img">
                    <img src="https://file.hstatic.net/1000288788/article/0-ghe-go-giam-doc-1-tu-trung-hieu-an-moc_2070f966ab154c51b9a9a1672e03dec7_large.jpg" alt="Top 7+ Mẫu Ghế Gỗ Giám Đốc Đẳng Cấp, Giá Tốt">
                    <div class="post-date">
                        <span class="day">5</span>
                        <span class="month">Tháng 09</span>
                    </div>
                </div>
                <div class="art-info">
                    <h3 class="title-article">Top 7+ Mẫu Ghế Gỗ Giám Đốc Đẳng Cấp, Giá Tốt</h3>
                    <div class="body-content">
                        <p>Trong môi trường làm việc, ghế giám đốc vừa phải đáp ứng yêu cầu thoải mái để đảm bảo năng suất làm việc trong thời gian dài vừa phải thể...</p>
                    </div>
                </div>
            </a>
        </div>


        <div class="news-content">
            <a href="#" class="news-flex">
                <div class="art-img">
                    <img src="https://file.hstatic.net/1000288788/article/0-ghe-don-go-dep-1-tu-trung-hieu-an-moc_7e5dc334090c4e23b62903c9dc84114d_large.jpg" alt="Top 7+ Mẫu Ghế Đôn Gỗ, Ghế Đẩu Gỗ Đẹp Bán Chạy Nhất">
                    <div class="post-date">
                        <span class="day">04</span>
                        <span class="month">Tháng 09</span>
                    </div>
                </div>
                <div class="art-info">
                    <h3 class="title-article">Top 7+ Mẫu Ghế Đôn Gỗ, Ghế Đẩu Gỗ Đẹp Bán Chạy Nhất</h3>
                    <div class="body-content">
                        <p>Ghế đôn gỗ đồ vật quen thuộc trong bếp ăn gia đình Việt ngày xưa. Ngày nay ghế gỗ đôn lại trở thành một mảnh vật trang trí đẹp và...</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="news-content">
            <a href="#" class="news-flex">
                <div class="art-img">
                    <img src="https://file.hstatic.net/1000288788/article/2-xuong-san-xuat-ban-ghe-an-moc-tu-trung-hieu-an-moc_16f04934c3fa4277afd4a1736d6913de_large.jpg" alt="Xưởng sản xuất bàn ghế, sofa theo yêu cầu giá rẻ, uy tín - An Mộc">
                    <div class="post-date">
                        <span class="day">04</span>
                        <span class="month">Tháng 09</span>
                    </div>
                </div>
                <div class="art-info">
                    <h3 class="title-article">Xưởng sản xuất bàn ghế, sofa theo yêu cầu giá rẻ, uy tín - An Mộc</h3>
                    <div class="body-content">
                        <p>Việc chọn lựa xưởng bàn ghế uy tín và chất lượng là một bước quan trọng không thể bỏ qua khi bạn chuẩn bị mở quán kinh doanh. Một lựa...</p>
                    </div>
                </div>
            </a>
        </div>


        <div class="news-content">
            <a href="#" class="news-flex">
                <div class="art-img">
                    <img src="https://file.hstatic.net/1000288788/article/0-ban-ghe-quan-tra-chanh-dep-gia-re-1-tu-trung-hieu-an-moc_900e2541d56a44b09a4d601237af00de_large.jpg" alt="Top 5+ Bộ Bàn Ghế Trà Chanh Vỉa Hè Giá Rẻ Chỉ 1 Triệu">
                    <div class="post-date">
                        <span class="day">07</span>
                        <span class="month">Tháng 05</span>
                    </div>
                </div>
                <div class="art-info">
                    <h3 class="title-article">Top 5+ Bộ Bàn Ghế Trà Chanh Vỉa Hè Giá Rẻ Chỉ 1 Triệu</h3>
                    <div class="body-content">
                        <p>Khi bắt đầu kinh doanh trà chanh, việc chọn lựa bàn ghế không chỉ ảnh hưởng đến ngân sách mà còn quyết định đến thương hiệu và sự thoải mái...</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="news-content">
            <a href="#" class="news-flex">
                <div class="art-img">
                    <img src="https://file.hstatic.net/1000288788/article/0n-ban-ghe-quan-bun-dau-dep-1-tu-trung-hieu-an-moc_bb8944c14a284778bb9149b13b84a897_large.jpg" alt="Top 5+ Bộ Bàn Ghế Quán Bún Đậu Mắm Tôm Đẹp, Giá Rẻ Đậm Chất “Việt”">
                    <div class="post-date">
                        <span class="day">06</span>
                        <span class="month">Tháng 04</span>
                    </div>
                </div>
                <div class="art-info">
                    <h3 class="title-article">Top 5+ Bộ Bàn Ghế Quán Bún Đậu Mắm Tôm Đẹp, Giá Rẻ Đậm Chất “Việt”</h3>
                    <div class="body-content">
                        <p>Bún đậu mắm tôm là món ăn đặc trưng của người “Việt”. Vì vậy khi mở quán việc chọn lựa đúng bàn ghế không chỉ đơn thuần là trang bị...</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="news-content">
            <a href="#" class="news-flex">
                <div class="art-img">
                    <img src="https://file.hstatic.net/1000288788/article/top-7-ghe-go-lam-viec-tot-nhat-2024--tu-trung-hieu-an-moc_0fd59f1be9b04948b35940aed6d21dd4_large.jpg" alt="Top 7 Ghế Gỗ Làm Việc Giá Rẻ, Tốt Nhất 2024">
                    <div class="post-date">
                        <span class="day">27</span>
                        <span class="month">Tháng 02</span>
                    </div>
                </div>
                <div class="art-info">
                    <h3 class="title-article">Top 7 Ghế Gỗ Làm Việc Giá Rẻ, Tốt Nhất 2024</h3>
                    <div class="body-content">
                        <p>Việc lựa chọn đúng ghế làm việc không chỉ đơn thuần là một quyết định về nội thất mà còn là một lựa chọn quan trọng ảnh hưởng đến sức...</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>

</html>