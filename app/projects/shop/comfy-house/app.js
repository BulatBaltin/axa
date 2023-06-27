const client = contentful.createClient({
    // This is the space ID. A space is like a project folder in Contentful terms
    space: "muyak1iavaaz",
    // This is the access token for this space. Normally you get both ID and the token in the Contentful web app
    accessToken: "-QkyMUrdSOZTngUri8B_K3jALjJ4SZ8_gniqZnvp3G4"
});

// client.getEntries()
//     .then((response) => console.log(response.items))
//     .catch(console.error);

// console.log(client);

// variables

const cartBtn = document.querySelector('.cart-btn');
const closeCartBtn = document.querySelector('.close-cart');
const clearCartBtn = document.querySelector('.clear-cart');
const cartDOM = document.querySelector('.cart');
const cartOverlay = document.querySelector('.cart-overlay');
const cartItems = document.querySelector('.cart-items');
const cartTotal = document.querySelector('.cart-total');
const cartContent = document.querySelector('.cart-content');
const productsDOM = document.querySelector('.products-center');
// const btns = document.querySelectorAll('.bag-btn');

// cart
let cart = [];
let buttonsDOM = [];

// getting products
class Products {
    async getProducts() {
        try {

            let contentful = await client.getEntries({
                content_type: 'product'
            });
            // .then((response) => console.log(response.items))
            // .catch(console.error);
            console.log(contentful);

            // client.getEntries({
            //     content_type: '<content_type_id>'
            // });
            // .then((response) => console.log(response.items))
            // .catch(console.error)

            // var fileProd = new File("products.json");
            // if(isfileexist('products.json')) {
            //     alert ('Found')
            // } else 
            //     alert ('NOT Found');

            // let result = await fetch('products.json');
            // console.log('products.json');
            // console.log(result);

            // let data = await result.json();


            // let products = data.items.map(
            //     item => {
            //         const { title, price } = item.fields;
            //         const { id } = item.sys;
            //         const image = item.fields.image.fields.file.url;
            //         return { title, price, id, image }
            //     }
            // );

            let products = contentful.items.map(
                item => {
                    const { title, price } = item.fields;
                    const { id } = item.sys;
                    const image = item.fields.image.fields.file.url;
                    return { title, price, id, image }
                }
            );

            return products;

        } catch (error) {
            console.log(error);
        }
    }
}

// user interface
class UI {
    displayProducts(products) {
        let result = '';
        products.forEach(product => {
            result += `
            <!-- single product -->
            <article class="product">
                <div class="img-container">
                    <img src=${product.image} alt="product-1" class="product-img">
                    <button class="bag-btn" data-id=${product.id}>
                        <i class="fas fa-shopping-cart"></i>
                        add to bag
                    </button>
                </div>
                <h3>${product.title}</h3>
                <h4>$${product.price}</h4>
            </article>
            <!-- end of single product -->
            
            `;
        });
        productsDOM.innerHTML = result;
    }
    getBagButtons() {
        const buttons = [...document.querySelectorAll('.bag-btn')];
        buttonsDOM = buttons;
        buttons.forEach(button => {
            let id = button.dataset.id;
            // console.log(id);
            let inCart = cart.find(item => item.id === id);
            if (inCart) {
                button.innerText = "In Cart";
                button.disabled = true;
            } // } else {
            button.addEventListener('click', (event) => {
                // console.log(event);
                event.target.innerText = 'In Cart';
                event.target.disabled = true;
                // console.log(id);
                let cartItem = { ...Storage.getProducts(id), amount: 1 };
                // console.log(cartItem);
                cart = [...cart, cartItem];
                Storage.saveCart(cart);
                this.setCartValues(cart);
                this.addCartItem(cartItem);
                this.showCart();
            })
            // }
        });
    }
    addCartItem(item) {
        const div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `
            <img src=${item.image} alt="product">
            <div>
                <h4>${item.title}</h4>
                <h5>$${item.price}</h5>
                <span class="remove-item" data-id=${item.id}>remove</span>
            </div>
            <div>
                <i class="fas fa-chevron-up" data-id=${item.id}></i>
                <p class="item-amount">${item.amount}</p>
                <i class="fas fa-chevron-down" data-id=${item.id}></i>
            </div>
        `;
        cartContent.appendChild(div);
    }
    setCartValues(cart) {
        let tempTotal = 0;
        let itemsTotal = 0;
        cart.map(item => {
            tempTotal += item.price * item.amount;
            itemsTotal += item.amount;
        });
        cartTotal.innerText = parseFloat(tempTotal.toFixed(2));
        cartItems.innerText = parseInt(itemsTotal);

    }
    showCart() {
        cartOverlay.classList.add('transparentBcg');
        cartDOM.classList.add('showCart');
    }
    setupApp() {
        cart = Storage.getCart();
        this.setCartValues(cart);
        this.populateCart(cart);
        cartBtn.addEventListener('click', this.showCart);
        closeCartBtn.addEventListener('click', this.hideCart);
    }
    populateCart(cart) {
        cart.forEach(item => this.addCartItem(item));

    }
    hideCart() {
        cartOverlay.classList.remove('transparentBcg');
        cartDOM.classList.remove('showCart');
    }
    cartLogic() {
        // clear Cart
        clearCartBtn.addEventListener('click', () => { this.clearCart(); });

        // cart functionality
        cartContent.addEventListener('click', event => {
            // console.log(event.target);
            if (event.target.classList.contains('remove-item')) {
                let removeItem = event.target;
                let id = removeItem.dataset.id;
                let Child = removeItem.parentElement.parentElement;
                // console.log(Child);

                cartContent.removeChild(Child);
                this.removeItem(id);
            } else if (event.target.classList.contains('fa-chevron-up')) {
                let upItem = event.target;
                let id = upItem.dataset.id;
                let tempItem = cart.find(item => item.id === id);
                tempItem.amount = tempItem.amount + 1;
                Storage.saveCart(cart);
                this.setCartValues(cart);
                upItem.nextElementSibling.innerText = tempItem.amount;

            } else if (event.target.classList.contains('fa-chevron-down')) {
                let arrowItem = event.target;
                let id = arrowItem.dataset.id;
                let tempItem = cart.find(item => item.id === id);
                if (tempItem.amount > 1) {

                    tempItem.amount = tempItem.amount - 1;
                    Storage.saveCart(cart);
                    this.setCartValues(cart);
                    arrowItem.previousElementSibling.innerText = tempItem.amount;
                } else {
                    cartContent.removeChild(arrowItem.parentElement.parentElement);
                    this.removeItem(id);
                }

            }

        });

    }
    clearCart() {
        let cartItems = cart.map(item => item.id);
        // console.log(cartItems);
        cartItems.forEach(id => this.removeItem(id));

        while (cartContent.children.length > 0) {
            cartContent.removeChild(cartContent.children[0]);
        }
        this.hideCart();
    }
    removeItem(id) {
        // cartContent.find(id => item.id);
        cart = cart.filter(item => item.id !== id);
        this.setCartValues(cart);
        Storage.saveCart(cart);
        let button = this.getSingleButton(id);
        button.disabled = false;
        button.innerHTML = `<i class='fas fa-shopping-cart'></i>add to cart`;

    }
    getSingleButton(id) {
        return buttonsDOM.find(button => button.dataset.id === id); // data-id ='...'
    }
}
// local storage
class Storage {
    static saveProducts(products) {
        localStorage.setItem('products', JSON.stringify(products));
    }
    static getProducts(id) {
        let products = JSON.parse(localStorage.getItem('products'));
        let product = products.find(product => product.id === id);
        return product;
    }
    static getCart() {
        // let cart = JSON.parse(localStorage.getItem('cart'));
        let cart = localStorage.getItem('cart');
        return cart ? JSON.parse(cart) : [];
    }
    static saveCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
}
document.addEventListener("DOMContentLoaded", () => {
    const ui = new UI();
    const products = new Products();
    //
    ui.setupApp();
    products.getProducts().then(products => {
        ui.displayProducts(products);
        Storage.saveProducts(products);
    }
    ).then(() => {
        ui.getBagButtons();
        ui.cartLogic();
    });
})

//</script>
