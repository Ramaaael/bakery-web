document.addEventListener("DOMContentLoaded", function() {
    const plusBtn = document.querySelector(".plus");
    const minusBtn = document.querySelector(".minus");
    const countInput = document.querySelector(".count");

    plusBtn.addEventListener("click", function() {
        countInput.value = parseInt(countInput.value) + 1;
    });

    minusBtn.addEventListener("click", function() {
        if (parseInt(countInput.value) > 1) {
            countInput.value = parseInt(countInput.value) - 1;
        }
    });

    const addToCartBtn = document.querySelector(".add-to-cart");
    addToCartBtn.addEventListener("click", function() {
        const itemName = document.querySelector("h4").innerText;
        const itemPrice = document.querySelector(".menu-price").innerText;
        const quantity = parseInt(countInput.value);

        // Kirim data ke keranjang.php menggunakan AJAX
        fetch('keranjang.php', {
            method: 'POST',
            body: JSON.stringify({ itemName, itemPrice, quantity })
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});