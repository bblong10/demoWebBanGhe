<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DuyLongShop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        ul {
            width: 100%;
            display: flex;
            justify-content: space-around;
        }

        .carousel-item img {
            width: 100%;
            height: 300px;
            /* Điều chỉnh chiều cao phù hợp với yêu cầu của bạn */
            object-fit: cover;
            /* Đảm bảo ảnh không bị biến dạng */
        }

        .box50 {
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            display: inline-block;
        }

        .myfooter ul {
            list-style: none;
            padding: 0px;
            margin: 0px;
        }

        .myfooter ul>li>a {
            text-decoration: none;
            color: white;
        }
    </style>

</head>

<body>

    <section class="mymaincontent my-3">
        <div class="container">
            <div class="slider mb-3">
                <div id="carouselExampleFade" class="carousel slide carousel-fade">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/public/imagesbanner/slider_1.png" class="d-block w-100" alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="/public/imagesbanner/slider-2.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="/public/imagesbanner/slider-3.png" class="d-block w-100" alt="">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
    </section>
    <script src="js/bootstrap.bundle.min.js"></script>  
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                dots: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 4,
                    },
                    600: {
                        items: 6,
                    },
                    1000: {
                        items: 8,
                        loop: false,
                        margin: 20
                    }
                }
            })
        })
    </script>

</body>