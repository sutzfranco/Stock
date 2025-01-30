// Mostrar el botón cuando se scrollea hacia abajo 20px desde el tope del documento
window.onscroll = function () {
  const scrollToTopButton = document.getElementById("scrollToTopButton");
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    scrollToTopButton.style.display = "block";
  } else {
    scrollToTopButton.style.display = "none";
  }
};

// Scrollear al tope del documento cuando se hace clic en el botón
document.getElementById("scrollToTopButton").onclick = function () {
  window.scrollTo({ top: 0, behavior: "smooth" });
};
