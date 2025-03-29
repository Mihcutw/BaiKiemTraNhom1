<?php include 'header.php'; ?>

<div class="about-wrapper">
    <div class="container animate-in">
        <!-- Giới thiệu về trang web -->
        <section class="about-site">
            <h1>Giới Thiệu Về Trang Web</h1>
            <p>
                Chào mừng bạn đến với <strong>Tên Website</strong>! Chúng tôi là một nền tảng trực tuyến chuyên cung cấp các sản phẩm thời trang chất lượng cao với giá cả hợp lý. Được thành lập vào năm 2025, sứ mệnh của chúng tôi là mang đến cho khách hàng những trải nghiệm mua sắm tuyệt vời, từ quần áo, giày dép đến phụ kiện. Hãy cùng khám phá và tìm kiếm những sản phẩm phù hợp với phong cách của bạn!
            </p>
        </section>

        <!-- Giới thiệu thành viên -->
        <section class="team-members">
            <h2>Đội Ngũ Của Chúng Tôi</h2>
            <div class="members-grid">
                <!-- Thành viên 1 -->
                <div class="member-card">
                    <img src="./images/trollface.png" alt="Đinh Phú Minh">
                    <h3>Đinh Phú Minh</h3>
                    <p class="role">Nhà Phát Triển Web</p>
                    <p class="bio">
                    Đinh Phú Minh là một lập trình viên tài năng với hơn 5 năm kinh nghiệm trong phát triển web. Anh ấy chịu trách nhiệm xây dựng và tối ưu hóa giao diện của trang web.
                    </p>
                </div>

                <!-- Thành viên 2 -->
                <div class="member-card">
                    <img src="./images/trollface2.png" alt="Trần Quang Nhật">
                    <h3>Trần Quang Nhật</h3>
                    <p class="role">Nhà Thiết Kế UI/UX</p>
                    <p class="bio">
                    Trần Quang Nhật là một nhà thiết kế sáng tạo, đảm bảo giao diện của trang web không chỉ đẹp mắt mà còn thân thiện với người dùng.
                    </p>
                </div>

                <!-- Thành viên 3 -->
                <div class="member-card">
                    <img src="./images/trollface3.png" alt="Bùi Quốc Trung">
                    <h3>Bùi Quốc Trung</h3>
                    <p class="role">Quản Lý Sản Phẩm</p>
                    <p class="bio">
                    Bùi Quốc Trung quản lý danh mục sản phẩm và đảm bảo rằng mọi mặt hàng trên trang web đều đáp ứng tiêu chuẩn chất lượng cao nhất.
                    </p>
                </div>
            </div>
        </section>
    </div>
</div>

<?php include 'footer.php'; ?>
<style>
    /* Reset mặc định */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif; /* Sử dụng font Roboto */
}

/* Wrapper cho toàn bộ trang */
.about-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #9c5ffd, #1de0ff); /* Gradient tím-xanh lam */
    padding: 40px 20px;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Hiệu ứng animate-in */
.animate-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease-in-out forwards;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Giới thiệu trang web */
.about-site {
    text-align: center;
    margin-bottom: 50px;
}

.about-site h1 {
    color: #fff;
    font-size: 2.5em;
    font-weight: 500;
    margin-bottom: 20px;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
}

.about-site p {
    color: #e6e0fa;
    font-size: 1.1em;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto;
}

.about-site strong {
    color: #fff;
}

/* Đội ngũ thành viên */
.team-members {
    text-align: center;
}

.team-members h2 {
    color: #fff;
    font-size: 2em;
    font-weight: 500;
    margin-bottom: 40px;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
}

/* Grid cho các thành viên */
.members-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    padding: 0 20px;
}

/* Card thành viên */
.member-card {
    background: rgba(255, 255, 255, 0.9); /* Nền trắng trong suốt */
    backdrop-filter: blur(5px); /* Hiệu ứng mờ nền */
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.member-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.member-card img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 15px;
    display: block;
    border: 3px solid #9c5ffd; /* Viền tím gradient */
}

.member-card h3 {
    color: #9c5ffd;
    font-size: 1.4em;
    font-weight: 500;
    margin-bottom: 5px;
}

.member-card .role {
    color: #1de0ff; /* Màu xanh lam gradient */
    font-size: 1em;
    font-style: italic;
    margin-bottom: 10px;
}

.member-card .bio {
    color: #555;
    font-size: 0.95em;
    line-height: 1.5;
}

/* Responsive */
@media (max-width: 768px) {
    .about-wrapper {
        padding: 20px 10px;
    }

    .about-site h1 {
        font-size: 2em;
    }

    .team-members h2 {
        font-size: 1.8em;
    }

    .members-grid {
        grid-template-columns: 1fr;
        padding: 0;
    }

    .member-card {
        padding: 15px;
    }

    .member-card img {
        width: 100px;
        height: 100px;
    }
}
</style>