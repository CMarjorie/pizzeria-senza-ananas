document.addEventListener('DOMContentLoaded', function () {

    let cart = document.querySelector('#cartQuantity');

    fetch('cartQuantity')
          .then(response => response.text())
          .then(html => {
            cart.innerHTML = html;
          })
})