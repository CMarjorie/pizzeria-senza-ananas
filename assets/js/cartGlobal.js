document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('btn-cart');
    let cart = document.querySelector('#cartQuantity');
  
    function onClick(e) {
      e.preventDefault();
  
      this.innerHTML = 'Mettre à jour';
      let url = this.parentNode.action;
      let quantity = this.previousElementSibling.value;
  
  
      fetch(`${url}?quantity=${quantity}`)
        .then(response => response.text())
        .then(response => {
          fetch('cartQuantity')
            .then(response => response.text())
            .then(html => {
              cart.innerHTML = html;
            })
        })
  
    }
  
    for (let button of buttons) {
      button.addEventListener('click', onClick);
    }
  
  });
  