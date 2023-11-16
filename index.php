<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ajax'])) {
    $directory = 'RESIMLER/';
    $images = glob($directory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    $imagePaths = array();
    foreach ($images as $image) {
        array_push($imagePaths, $image);
    }
    echo json_encode($imagePaths);
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Taylan Soylu'nun özgün grafik tasarımlarını keşfedin. Sanat ve teknolojiyi birleştiren eserler, canlı radyo yayını ile birlikte.">
    <meta name="keywords" content="Taylan Soylu, Sanat Galerisi, Eğitim, Teknoloji, Grafik Tasarım, Müzik, Python, PHP">
    <meta name="author" content="Taylan Soylu">
    <title>Taylan Soylu'nun Sanat ve Teknoloji Dünyası</title>

    <!-- Sosyal Medya için Ek Meta Etiketleri -->
    <meta property="og:title" content="Taylan Soylu'nun Sanat ve Teknoloji Dünyası">
    <meta property="og:description" content="İlkokul öğretmeni Taylan Soylu'nun kişisel sanat galerisi ve teknoloji dünyasına bir bakış.">
    <meta property="og:image" content="image_linkitaylansoylu.jpg">
    <meta property="og:url" content="test.taylansoylu.com">
    <meta name="twitter:card" content="summary_large_image">
    <style>
        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            text-align: center;
            overflow: hidden;
        }
        #welcomeBox {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            color: #333;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        #welcomeBox button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #welcomeBox button:hover {
            background-color: #45a049;
        }
        #radioPlayerContainer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: rgba(51, 51, 51, 0.5); /* Transparan arka plan */
        color: white;
        text-align: center;
        padding: 5px 0; /* Daha ince bir görünüm için padding'i azalt */
        z-index: 10;
    }

    #radioPlayerContainer audio {
        max-width: 90%; /* Gerekiyorsa genişliği ayarlayın */
        height: auto; /* Yüksekliği otomatik ayarla */
    }
        #imageGallery {
        position: relative;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
    }
    .gallery-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        object-fit: cover;
    }
    #infoBar {
        position: fixed;
        bottom: 50px; /* Radyo player'ın hemen üzerinde yer alacak */
        left: 0;
        width: 100%;
        background-color: rgba(51, 51, 51, 0.5); /* Transparan arka plan */
        color: white;
        text-align: center;
        padding: 5px 0;
        font-size: 14px; /* Yazı boyutunu ayarlayın */
        z-index: 9;
        box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.5); /* Alt gölge efekti */
        font-family: 'Arial', sans-serif; /* Yazı tipini değiştir */
        font-size: 16px; /* Yazı boyutunu büyüt */
        color: #fff; /* Yazı rengini beyaz yap */
    }

    #infoBar p {
        margin: 0;
        padding: 0;
        text-shadow: 1px 1px 2px black; /* Yazıya gölgeleme efekti ekle */
        letter-spacing: 0.5px; /* Harf aralıklarını ayarla */
    }
/* Mobil cihazlar için özel stil tanımları */
    @media (max-width: 768px) {
        #infoBar p {
            font-size: 14px; /* Mobil cihazlar için yazı boyutunu küçült */
        }
    }
    #versionInfo {
        position: absolute;
        top: 5px; /* Üstten daha az mesafe */
        left: 5px; /* Soldan daha az mesafe */
        background-color: rgba(51, 51, 51, 0.5); /* Transparan arka plan */
        color: white;
        padding: 3px 6px; /* Daha az padding */
        border-radius: 3px; /* Daha küçük yuvarlak köşeler */
        font-size: 12px; /* Daha küçük yazı boyutu */
        z-index: 100;
        box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.5); /* Alt gölge efekti */
        display: flex; /* Flexbox kullanarak içerikleri aynı satırda hizala */
        align-items: center; /* Dikey olarak ortala */
        display: flex; /* Flexbox kullanarak içerikleri aynı satırda hizala */
        align-items: center; /* Dikey olarak ortala */
    }

        .new-version {
            color: red; /* Yeni sürüm olduğunda metin rengi */
            font-weight: bold; /* Metni kalın yap */
        }
img {
    pointer-events: none;
}
.social-share-button {
        padding: 2px 5px;
        margin-left: 10px; /* Sürüm bilgisiyle arasında boşluk */
        font-size: 20px; /* Daha küçük yazı boyutu */
        vertical-align: middle; /* Dikey hizalama */
        text-decoration: none; /* Link altı çizgisini kaldır */
        color: white; /* Link rengini beyaz yap */
    }
    /* Modal Stilleri */
    .modal {
        display: none;
        position: fixed;
        z-index: 200;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-icerik {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        position: relative; /* Modal içeriği için pozisyon */
    }

    .kapatBtn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .kapatBtn:hover,
    .kapatBtn:focus {
        color: black;
        text-decoration: none;
    }

    .modal-icerik img {
        margin-bottom: 20px;
        border-radius: 10px;
    }
     .modal-icerik p {
        text-align: left; /* Metni sola hizala */
        text-indent: 20px; /* İlk satırda girinti oluştur */
        margin-bottom: 15px; /* Paragraflar arasında boşluk */
    }
    .modal-icerik .imza {
        position: absolute; /* İmza için pozisyon */
        right: 20px; /* Sağdan 20px */
        bottom: 20px; /* Alttan 20px */
        text-align: right;
        font-weight: bold;
        font-size: 16px;
        color: #333;
    }
    </style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <!-- Hoşgeldiniz Kutusu -->
    <div id="welcomeBox">
        <p>Hoşgeldiniz. Ben Taylan Soylu. Burada müzik eşliğinde Grafik Tasarımlarımı izleyebilirsiniz.</p>
        <button onclick="startExperience()">Haydi Başlayalım</button>
    </div>
</div>
<div id="content" style="display:none;">
<!-- Sürüm bilgisi ve yenileme düğmesi -->
    <div id="versionInfo">
        <p id="versionText">Versiyon: <span id="currentVersionDisplay"></span></p>
        <button id="refreshButton" style="display: none;" onclick="location.reload();">Yenile</button>
        <!-- Sosyal Medya Butonları -->
   <a href="https://twitter.com/intent/tweet?text=Hoşuma giden bir sanat eseri&url=https://www.sitenizinadresi.com" target="_blank" class="social-share-button">
        <i class="fab fa-twitter"></i>
    </a>
    <a href="https://www.instagram.com/kullaniciadiniz" target="_blank" class="social-share-button instagram-button">
        <i class="fab fa-instagram"></i>
    </a>
    <a href="#hakkimdaModal" class="social-share-button" id="hakkimdaBtn">
        <i class="fas fa-user"></i>
    </a>
    </div>
<!-- About Me Modal -->
<div id="hakkimdaModal" class="modal">
    <div class="modal-icerik">
        <span class="kapatBtn">&times;</span>
        <h2>Taylan Soylu<br>Bir Öğretmenin Teknolojiyle Dansı</h2>
        <img src="taylansoylu.jpg" alt="Taylan Soylu" style="width:100%; max-width:300px; height:auto;">
        <p>Merhaba, ben Taylan Soylu. Gündüzleri ilkokul öğretmeni olarak genç zihinleri şekillendirirken, geceleri teknolojiye olan tutkumu keşfetmenin derinliklerine dalıyorum. Kodlama benim için sadece bir hobi değil, aynı zamanda sürekli öğrenme ve kendimi geliştirme yolculuğumun bir parçası. Python ve PHP'de edindiğim bilgilerle, düşüncelerimi dijital dünyada hayata geçiriyorum.</p>
        <p>Müzik, ruhumun gıdası. Her türden müziği dinlemekten keyif alıyorum ve bu, yaratıcılığımı besleyen bir kaynak. Müzik, benim için sadece bir arka plan sesi değil, aynı zamanda ilhamımın ve enerjimin kaynağı. Her notada, hayatın farklı bir yönünü keşfediyorum.</p>
        <p>Hayatım, öğretmek, öğrenmek ve yaratmak arasında sürekli bir döngü. Her gün, yeni bir şeyler keşfetmek, yeni bir hikaye yazmak için bir fırsat. Teknoloji ve eğitim arasındaki bu harika dansa katılmak, benim için paha biçilemez bir serüven.</p>
        <br> <!-- Ekstra boşluk -->
        <div class="imza"><br>Taylan Soylu</div> <!-- İmza -->
    </div>
</div>

<div id="infoBar">
    <p>Tasarım ve Kodlama: © Taylan Soylu - 2023</p>
    <p>Tüm Materyaller ve Müzikler telif yasalarına tabidir.</p>
</div>

        <div id="radioPlayerContainer">
            <div class="cc_player" data-username="bingoweb" data-size="sm" data-style="light">Loading ...</div>
        </div>
        <div id="imageGallery"></div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js?v=1.6"></script>
    <script language="javascript" type="text/javascript" src="https://eu1.fastcast4u.com/system/player.js"></script>

<script>
    var modal = document.getElementById('hakkimdaModal');
    var btn = document.getElementById('hakkimdaBtn');
    var span = document.getElementsByClassName('kapatBtn')[0];

    btn.onclick = function() {
        modal.style.display = 'block';
    }

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

<script>
    window.addEventListener('load', function() {
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        }, false);
    });
</script>

</body>
</html>
