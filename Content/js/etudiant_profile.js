//Réalisé par Ony
document.addEventListener('DOMContentLoaded', function() {
    window.onscroll = function() {
      document.getElementById("scrollToTop").className = (window.pageYOffset > 100) ? "scrollUpVisible" : "scrollUpInvisible";
    };
  });