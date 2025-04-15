document.addEventListener('DOMContentLoaded', function() {
    // Aktifkan semua elemen secara bertahap
    var sections = document.querySelectorAll('.reveal-section');
    for (var i = 0; i < sections.length; i++) {
        (function(index) {
            setTimeout(function() {
                if (isElementInViewport(sections[index])) {
                    sections[index].classList.add('active');
                }
            }, 300 + (index * 200)); // Tambahkan delay bertahap untuk setiap elemen
        })(i);
    }
    
    // Fungsi untuk mengecek apakah elemen sudah terlihat di viewport
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8
        );
    }
    
    // Fungsi untuk memeriksa dan mengaktifkan elemen saat scroll
    function checkScroll() {
        var elements = document.querySelectorAll('.reveal-section:not(.active)');
        for (var i = 0; i < elements.length; i++) {
            if (isElementInViewport(elements[i])) {
                elements[i].classList.add('active');
            }
        }
    }
    
    // Event listener untuk scroll
    window.addEventListener('scroll', checkScroll);
    // Panggil checkScroll saat halaman dimuat untuk mengaktifkan elemen yang sudah terlihat
    checkScroll();
}); 