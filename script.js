// Resim listesini karıştıran fonksiyon
function karistir(array) {
    for (let i = array.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

let currentImageIndex = -1;
let imageList = [];

function resimleriOncedenYukle(imageArray) {
    for (let i = 0; i < imageArray.length; i++) {
        const img = new Image();
        img.src = imageArray[i];
    }
}


function loadImages() {
    $.ajax({
        url: 'index.php?ajax=1',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            imageList = data;
            karistir(imageList); // Resim listesini karıştır
            resimleriOncedenYukle(imageList); // Resimleri önceden yükle
            showNextImage();
        },
        error: function () {
            console.error('Resimler yüklenemedi.');
        }
    });
}

function showNextImage() {
    currentImageIndex = (currentImageIndex + 1) % imageList.length;
    const imageSrc = imageList[currentImageIndex];
    const oldImg = $('#imageGallery img');
    const newImg = $('<img>', {
        src: imageSrc,
        alt: 'Sanat Eseri',
        class: 'gallery-image',
        style: 'position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; object-fit: cover; opacity: 0;'
    }).appendTo('#imageGallery');

    newImg.animate({ opacity: 1 }, 1000, function () {
        oldImg.remove();
    });

    if (currentImageIndex === imageList.length - 1) {
        karistir(imageList); // Listenin sonuna geldiğinde tekrar karıştır
    }
}

function handleVisibilityChange() {
    var player = document.querySelector('#radioPlayerContainer audio');
    if (!player) return;

    if (document.hidden || document.visibilityState === "hidden") {
        player.pause(); // Müziği durdur
    } else {
        player.play().catch(function(error) {
            console.error("Otomatik oynatma başlatılamadı: ", error);
            // Burada, kullanıcıya müziği manuel olarak başlatması için bir mesaj gösterebilirsiniz.
        });
    }
}

document.addEventListener("visibilitychange", handleVisibilityChange, false);


function updateVersionDisplay(latestVersion) {
    var versionText = document.getElementById("versionText");
    document.getElementById("currentVersionDisplay").textContent = latestVersion;

    if (localStorage.getItem("siteVersion") !== latestVersion) {
        versionText.classList.add("new-version"); // Yeni sürüm stili ekle
    } else {
        versionText.classList.remove("new-version"); // Stili kaldır
    }
}

function checkForUpdates() {
    $.ajax({
        url: 'version_check.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var latestVersion = response.version;
            var storedVersion = localStorage.getItem("siteVersion");

            updateVersionDisplay(latestVersion); // Sürüm bilgisini güncelle

            if (storedVersion !== latestVersion) {
                // Yeni sürüm varsa "Yenile" düğmesini göster
                document.getElementById("refreshButton").style.display = 'block';
                localStorage.setItem("siteVersion", latestVersion); // Yeni sürümü localStorage'a kaydet
            } else {
                // Yeni sürüm yoksa "Yenile" düğmesini gizle
                document.getElementById("refreshButton").style.display = 'none';
            }
        },
        error: function() {
            console.error("Sürüm kontrolü sırasında bir hata oluştu.");
        }
    });
}

window.onload = checkForUpdates;
setInterval(checkForUpdates, 60000); // Her 5 dakikada bir kontrol et




function startExperience() {
    document.getElementById('welcomeBox').style.display = 'none';
    document.getElementById('content').style.display = 'block';

    loadImages();

    // Radyo player'ı başlatma girişimi
    var playerContainer = document.querySelector('.cc_player');
    if (playerContainer) {
        var player = playerContainer.getElementsByTagName('audio')[0];
        if (player) {
            player.play().catch(function(error) {
                console.error("Otomatik oynatma başlatılamadı: ", error);
                // Kullanıcıya radyo player'ı manuel olarak başlatması için bir mesaj gösterebilirsiniz.
            });
        }
    }
}


setInterval(showNextImage, 10000);